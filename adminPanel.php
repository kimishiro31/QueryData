<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
getAttendantAccess();
doAccountActiveRedirect($accountData['id'], true);

        /*********************************************************
        **
        ** VALIDAÇÃO DO FORMULARIO
        **
        **********************************************************/
        if (empty($_POST) === false && getToken('tokenQuery')) {
        }

        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors) && getToken('tokenQuery')) {

            $msg[] = "Sua consulta foi enviada com sucesso.";
            $msg[] = "O resultado será encaminhado via Whatszap e Email.";
            $msg = implode('<br/>', $msg);
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
                <a href="adminCredits.php">
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
    <div id="divApContainer">
    </div>
 

</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
