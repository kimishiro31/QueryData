<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
getManagerAccess();
doAccountActiveRedirect($accountData['id'], true);
$ip = 1;
        /*********************************************************
        **
        ** VALIDAÇÃO DO FORMULARIO
        **
        **********************************************************/
        if (empty($_POST) === false && getToken('tokenAddCredit')) {
            if(isUserExist($_POST['user_ID']) === false) {
                $errors[] = "O usuário informado não foi localizado.";
            }

            if($_POST['value'] <= 0) {
                $errors[] = "O valor informado é invalido, é necessário ser maior que zero.";
            }
            if(is_numeric($_POST['value']) === false) {
                $errors[] = "O valor informado não é um numero.";
            }
            
            if ($_POST['selectFunction'] !== '0' && $_POST['selectFunction'] !== '1') {
                $errors[] = "Favor verificar o que deseja fazer ADD/REM.";
            }
            
            if (($_POST['value'] > getCreditUserValue(getCreditUser($_POST['user_ID']))) && $_POST['selectFunction'] != 1) {
                $errors[] = "O usuário não possui esse saldo.";
            }
        }

        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors) && getToken('tokenAddCredit')) {

            if($_POST['selectFunction'] == 0) {
                doRemoveUserCredit($_POST['user_ID'], $_POST['value']);
                $msg[] = "Foi removido com sucesso no saldo deste usuário.";
                $msg = implode('<br/>', $msg);
            } 
            elseif($_POST['selectFunction'] == 1) {
                doAddUserCredit($_POST['user_ID'], $_POST['value']);
                $msg[] = "Foi adicionado com sucesso no saldo deste usuário.";
                $msg = implode('<br/>', $msg);

            }
            
            echo doPopupSuccess($msg);
        }















        /*********************************************************
        **
        ** VALIDAÇÃO DO FORMULARIO PACK
        **
        **********************************************************/
        if (empty($_POST) === false && getToken('tokenAddPack')) {
            if(isUserExist($_POST['user_ID']) === false) {
                $errors[] = "O usuário informado não foi localizado.";
            }

            if($_POST['value'] <= 0) {
                $errors[] = "O valor informado é invalido, é necessário ser maior que zero.";
            }
            if(is_numeric($_POST['value']) === false) {
                $errors[] = "O valor informado não é um numero.";
            }

            if (isPackageExist($_POST['selectCredit']) === false) {
                $errors[] = 'Escolha uma medalha valida!';
            }
            
            if ($_POST['selectFunction'] !== '0' && $_POST['selectFunction'] !== '1') {
                $errors[] = "Favor verificar o que deseja fazer ADD/REM.";
            }

            if((isPackContracted($_POST['user_ID']) == $_POST['selectCredit']) && $_POST['selectFunction'] == 0 &&  getPackValue(getUserPack($userData['id'])) < $_POST['value']) {
                $errors[] = "O usuário não possui está quantidade de vouncher.";
            }
            
            if((isPackContracted($_POST['user_ID']) != $_POST['selectCredit']) && $_POST['selectFunction'] == 0) {
                $errors[] = "O usuário não possui nenhum vouncher desta espécie.";
            }
            
            if((isPackExist($_POST['user_ID']) && isPackContracted($_POST['user_ID']) != $_POST['selectCredit']) && $_POST['selectFunction'] == 1) {
                $errors[] = "Você não pode adicionar vouncher dessa espécie para esse usuário, pois o mesmo já tem do vouncher de outra medalha.";
            }
        }



        /*********************************************************
        **
        ** SE O FORMULARIO PACK VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors) && getToken('tokenAddPack')) {

            if($_POST['selectFunction'] == 0) {
                doRemoveUserVouncher($_POST['user_ID'], $_POST['value'], $_POST['selectCredit']);
                $msg[] = "Foi removido com sucesso no saldo deste usuário.";
                $msg = implode('<br/>', $msg);
            } 
            elseif($_POST['selectFunction'] == 1) {
                if(isPackExist($_POST['user_ID']) === true) 
                    doUpdateUserVouncherValue($_POST['user_ID'], $_POST['value'], $_POST['selectCredit']);
                else
                    doAddUserVouncher($_POST['user_ID'], $_POST['value'], $_POST['selectCredit'], 0, $ip);


                $msg[] = "Foi adicionado com sucesso no saldo deste usuário.";
                $msg = implode('<br/>', $msg);

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

<div id="divAPContent">

    <center>
        <label id="divApStart" class="labelTitleContainer_2">Painel Administrativo</label>
    </center>
    <hr size="1" align="center" noshade></br></br></br>

    <nav id="divMaBar">
        <ul>
            <?php
            if(isAttendant($accountData['id'])) {
            ?>
                <a href="#divApStart">
                    <li>
                        <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                        Inicio
                    </li>
                </a>
                <a href="adminListQueries.php">
                    <li>
                        <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                        Fila de Consulta
                    </li>
                </a>
                <a href="adminQueriesLogs.php">
                    <li>
                        <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                        Histórico de Consultas
                    </li>
                </a>
            <?php
            }
            if(isManager($accountData['id'])) {
            ?>
                <a href="adminUsers.php">
                    <li>
                        <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                        Usuários
                    </li>
                </a>
            <?php
            }
            if(isManager($accountData['id'])) {
            ?>
                <a href="#divApStart">
                    <li>
                        <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                        Créditos e Pacotes
                    </li>
                </a>
            <?php
            }
            ?>
            <a href="logout.php">
                <li>
                    <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                    Sair
                </li>
            </a>


        </ul>
    </nav>
    <div id="divApCreditsContainer">
        <center>
            <label id="divApStart" class="labelTitleContainer_2">Recarga de Crédito</label>
        </center>
        <hr size="1" align="center" noshade></br></br></br>
        
        <form action="" method="post">
            <input name="user_ID" class="smallInputTxt" type="text" placeholder="Codigo do usuário"/>
            <input name="value" class="smallInputTxt" type="text" placeholder="Valor"/>
            <select name="selectFunction" class="mediumSelectInp">
                <option value="0">Remover</option>
                <option value="1">Adicionar</option>
            </select></br></br>
            <?php setToken('tokenAddCredit') ?>
            <input name="token" type="text" value="<?php echo addToken('tokenAddCredit') ?>" hidden/>

            <button type="submit" class="enterButton">Enviar</button>
        </form>
        </br></br>
        
        <center>
            <label id="divApStart" class="labelTitleContainer_2">Recarga de Pacote</label>
        </center>
        <hr size="1" align="center" noshade></br></br></br>
        <form action="" method="post">
            <input name="user_ID" class="smallInputTxt" type="text" placeholder="Codigo do usuário"/>
            <input name="value" class="smallInputTxt" type="text" placeholder="Valor"/>
            <select name="selectCredit" class="mediumSelectInp">
                <option value="0" selected>-- Pacote --</option>
                <option value="1"><?php echo getTypeCreditName(2); ?></option>
                <option value="2"><?php echo getTypeCreditName(3); ?></option>
                <option value="3"><?php echo getTypeCreditName(4); ?></option>
            </select>
            <select name="selectFunction" class="mediumSelectInp">
                <option value="0">Remover</option>
                <option value="1">Adicionar</option>
            </select></br></br>
            <?php setToken('tokenAddPack') ?>
            <input name="token" type="text" value="<?php echo addToken('tokenAddPack') ?>" hidden/>

            <button type="submit" class="enterButton">Enviar</button>
        </form>

    </div>
 

</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
