<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
doProtect();
doAccountActiveRedirect($accountData['id'], true);



        /*********************************************************
        **
        ** VALIDAÇÃO DO FORMULARIO
        **
        **********************************************************/
        if (empty($_POST) === false && getToken('tokenBuyPackage')) {
            if(isPackageExist($_POST['package']) === false) {
                $errors[] = 'Pacote invalido!';
            }

            if(getCreditUserValue($userData['id']) < getPackageCost($_POST['package'])) {
                $errors[] = 'Você não possui saldo suficiente para comprar este pacote.';
            }
            if((isPackExist($userData['id']) && isPackContracted($userData['id']) != $_POST['package'])) {
                $errors[] = "Você já possui vouncher de outra espécie, não é possivel o uso de duas medalhas.";
            }
        }

        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors) && getToken('tokenBuyPackage')) {
                $msg[] = "O seu pacote foi adicionado com sucesso!!";
                $msg = implode('<br/>', $msg);
                
                if(isPackExist($userData['id']) === true) {
                    doUpdateUserVouncherValue($userData['id'], getPackageValue($_POST['package']), $_POST['package']);
                    doRemoveUserCredit($userData['id'], getPackageCost($_POST['package']));
                }
                else {
                    doAddUserVouncher($userData['id'], getPackageValue($_POST['package']), $_POST['package'], getPackageCost($_POST['package']), getIp());
                    doRemoveUserCredit($userData['id'], getPackageCost($_POST['package']));
                }
                echo doPopupSuccess($msg);
    //            header('refresh: 5, login.php');
        }
        
        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR COM ERROS
        **
        **********************************************************/
        if (empty($errors) === false) {
            header("HTTP/1.1 401 Not Found");
            echo doPopupError($errors);
        }



?>

<div id="divMaContent">

    <center>
        <label id="divMaStart" class="labelTitleContainer_2">Painel de Usúario</label>
    </center>
    <hr size="1" align="center" noshade></br></br></br>

    <?php include 'layout/overall/menu/bodyMenuUser.php'; ?>


    <!-- PAGINA 1 -->
        <div id="divDPContainer">
            <center>
                <label id="divMaQuery" class="labelTitleContainer_2">Medalhas</label>
            </center>
            <hr size="1" align="center" noshade></br>

            <div id="divDPValuesContainer">
                <?php
                $list = doListPackages();
                if($list !== false) {
                    setToken('tokenBuyPackage');
                    foreach($list as $key) {
                ?>
                        <div class="classValuePay">
                            <div class="classValuePayImg">
                                <img src="\layout\marketing\p<?php echo $key['id']; ?>.png"></img>
                            </div>
                            <form action="" method="post">
                                <input name="token" type="text" value="<?php echo addToken('tokenBuyPackage') ?>" hidden/>
                                <input name="package" type="text" value="<?php echo $key['id'] ?>" hidden/>
                                <center><input type="text" disabled class="smallInputTxt" value="QD$ <?php echo getPackageCost($key['id']); ?>"/></center>
                                <button type="submit" class="otherButton">Comprar</button>
                            </form>
                        </div>
                <?php
                    }
                }
                    
                ?>
            </div>
            </br></br>
        </div>
</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
