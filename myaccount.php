<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
doProtect();
doAccountActiveRedirect($accountData['id'], true);
doLiberationPayment($userData['id']);
?>

<div id="divMaContent">

    <center>
        <label id="divMaStart" class="labelTitleContainer_2">Painel de Usúario</label>
    </center>
    <hr size="1" align="center" noshade></br></br></br>
    <?php include 'layout/overall/menu/bodyMenuUser.php'; ?>
    <div id="divMaContainer">
        <div id="divMaCreditsContainer">
            <li class="classMaCreditValue classMaCreditReal tooltip" title="Saldo em R$">R$ <?php echo getCreditUserValue(getCreditUser($userData['id'])); ?></li>
            <li class="classMaCreditValue classMaCreditBronze tooltip" title="Vounchers Medalha Bronze">
                <img class="classMedalIcon" src="layout\ico\p3.ico"/>
                <?php echo getUserPackValue($userData['id'], 1) ?>
            </li>
            <li class="classMaCreditValue classMaCreditSilver tooltip" title="Vounchers Medalha Prata">
                <img class="classMedalIcon" src="layout\ico\p2.ico"/>
                <?php echo getUserPackValue($userData['id'], 2) ?>
            </li>
            <li class="classMaCreditValue classMaCreditGold tooltip" title="Vounchers Medalha Ouro">
                <img class="classMedalIcon" src="layout\ico\p1.ico"/>
                <?php echo getUserPackValue($userData['id'], 3) ?>
            </li>
        </div></br>

        <script>
            function doCopy() {
                let copyText = document.getElementById('divQueryCopy');
                let input = document.createElement("input");
                input.id = "inp";
                input.value = copyText.innerHTML;
                copyText.appendChild(input);
                
                let copy = document.getElementById('inp');
                copy.select();
                document.execCommand("Copy");
                alert("O texto foi copiado.");
                
                copyText.removeChild(input);
            }

        </script>
        <hr size="1" align="center" noshade></br>

        <div id="divMaQueryContainer">
            Seja bem vindo ao seu painel <?php echo getUserCompleteName($userData['id']) ?>, que tal ganhar uma consulta gratuitamente? basta copiar o código abaixo e encaminhar para um amigo.</br></br>
            <div id="divQueryCopy" onclick="doCopy()"><?php echo getInviteCodeUser($accountData['id']); ?></div></br></br>
        
            <table class="classTableGeneral">
                <tr>
                    <th>COD</th>
                    <th>VALOR</th>
                    <th>DATA</th>
                    <th>STATUS DA COMPRA</th>
                </tr>
                <?php 
                    $data = doListCreditSold($userData['id'], 0, 5);
                    if($data) {
                        foreach($data as $key) {
                            echo '
                                <tr>
                                    <td>'.doTransformCode($key['id']).'</td>
                                    <td>'.getCreditQuantity(getCreditSoldCreditID($key['id'])).'</td>
                                    <td>'.doDateConvert(getCreditSoldCreated($key['id'])).'</td>
                                    <td>'.getCreditSoldStatus($key['id']).'</td>
                                </tr>
                            ';
                        }
                    }
                ?>
            </table>
        </br></br></br>

        </div>
        </br></br>
        
        
    </div>


</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
