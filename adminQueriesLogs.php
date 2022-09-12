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
        if (empty($_POST) === false && getToken('tokenQueryEdit')) {
            
            if(array_key_exists($_POST['selectQStatus'], config('statusQuery')) === false) {
                $errors[] = 'Status selecionado é inexistente.';
            }

            if(isUserExist($_POST['selectAssigned']) === false) {
                $errors[] = 'Usuário selecionado não existe.';
            }

            if(isQueryExist($_POST['query_ID']) === false) {
                $errors[] = 'Consulta não existe.';
            }
        }

        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors) && getToken('tokenQueryEdit')) {
            
            if($_POST['selectQStatus'] == 4 || $_POST['selectQStatus'] == 5 || $_POST['selectQStatus'] == 6) {

                $register_data =  array(
                    'id' 		    => $_POST['query_ID'],
                    'user_id' 		=> getQueryUserID($_POST['query_ID']),
                    'type' 			=> getQueryType($_POST['query_ID']),
                    'value01' 		=> getQueryValue($_POST['query_ID'], 1),
                    'value02' 		=> getQueryValue($_POST['query_ID'], 2),
                    'pay_type' 		=> getQueryCreditType($_POST['query_ID']),
                    'date' 			=> getQueryDate($_POST['query_ID']),
                    'time' 			=> getQueryTime($_POST['query_ID']),
                    'ip' 			=> getQueryIP($_POST['query_ID']),
                    'status' 		=> $_POST['selectQStatus'],
                    'assigned' 		=> $_POST['selectAssigned'],
                    'assigned_date' => date("Y-m-d"),
                    'assigned_time' => date("H:i:s"),
                    'queryEnd_user_id' => $userData['id'],
                    'queryEnd_date' => date("Y-m-d"),
                    'queryEnd_time' => date("H:i:s")
                );
                doAddQueryLogs($register_data);
                doDeleteQuery($_POST['query_ID']);
                echo doPopupSuccess("Essa consulta foi finalizada com sucesso.", "adminQueriesLogs.php");
            }
            else {
                $update_data =  array(
                    'query_ID' 		=> $_POST['query_ID'],
                    'status' 		=> $_POST['selectQStatus'],
                    'assigned' 		=> $_POST['selectAssigned'],
                    'assigned_date' => date("Y-m-d"),
                    'assigned_time' => date("H:i:s")
                );
    
                doUpdateQuery($update_data);    
                echo doPopupSuccess("Essa consulta foi salva com sucesso.");
            }
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

<script>
    function popupQueryClose(){
		window.location.href = "adminQueriesLogs.php";
	}
    
    function autoRefresh() {
        window.location = window.location.href;
    }
    setInterval('autoRefresh()', (<?php echo config('timeRefresh'); ?>) * 60 * 1000);

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
                <a href="adminPanel.php">
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
        <center>
            <label id="divApStart" class="labelTitleContainer_2">Histórico de Consultas</label>
        </center>
        <hr size="1" align="center" noshade></br></br></br>

        <div id="divApSearchContainer">
            <form action="" method="get">
                <input name="search" class="mediumInputTxt" placeholder="Código"/>
                <button class="enterButton" type="submit">Procurar</button>
            </form>
        </div>
        </br>
        </br>
        <?php $rp = doListQueriesConsult(); ?>
        </br>
        </br>
        <table class="classTableGeneral classTableClick">
            <tr>
                <th>COD</th>
                <th>CONSULTA</th>
                <th>DATA CONSULTA</th>
                <th>ATRIBUIDO A</th>
                <th>Finalizado Por</th>
                <th>STATUS</th>
            </tr>
            <?php
            if(isset($_GET['search']) && !empty($_GET['search']))
                $queries = getAllQueriesLogs($rp['ppage'], $rp['rowsPerPage'], $_GET['search']);
            else
                $queries = getAllQueriesLogs($rp['ppage'], $rp['rowsPerPage']);


            if($queries) {
                foreach($queries as $key) {
                    if(getQueryLogsType($key['id']) == 1)
                        $queryValue = getTypeQuery(getQueryLogsType($key['id'])).':</br>'.getQueryLogsValue($key['id']).' - '.doDateConvert(getQueryValue($key['id'], 2));
                    else
                        $queryValue = getTypeQuery(getQueryLogsType($key['id'])).': '.getQueryLogsValue($key['id']);
            ?>
                        <tr onclick="location.href='adminQueriesLogs.php?cod=<?php echo $key['id']; ?>'">
                            <td><?php echo doTransformCode($key['id']) ?></td>
                            <td><?php echo $queryValue ?></td>
                            <td><?php echo doDateConvert(getQueryLogsDate($key['id'])).' - '.getQueryLogsTime($key['id']) ?></td>
                            <td><?php echo getUserCompleteName(getQueryLogsAssigned($key['id'])) ?></td>
                            <td><?php echo getUserCompleteName(getQueryLogsFinishedUserId($key['id'])); ?></td>
                            <td><?php echo getStatusQuery(getQueryLogsStatus($key['id'])); ?></td>
                        </tr>
            <?php
                }
            }              
            ?>
        </table>

        <!-- PARTE DO MODAL -->
        <?php

        if(isset($_GET['cod']) && !empty($_GET['cod'])) {
            $query_ID = $_GET['cod'];
        ?>
            <div id="divQueryUserBody">
                    <div id="divQueryUserMainDescription">
                        <button  onclick="popupQueryClose('divQueryUserBody', 'flex')" type="button" id="divQuerUserCloseDescription">X</button>
                        <div id="divQueryUserBorderDescription">
                            <div id="divQuerUserContentDescription">
                                <center>
                                    <label id="divApStart" class="labelTitleContainer_2">Consulta - <?php echo doTransformCode($query_ID) ?></label>
                                </center>
                                <hr size="1" align="center" noshade></br></br>
                                <label ID="divQueryCopyType">Dados para Consulta</label>
                                <div id="divQueryCopy" onclick="doCopy()"><?php echo $queryValue ?></div>

                                </br>
                                <form action="" method="POST">
                                    <table class="classTableListQueries">
                                        <tr>
                                            <th colspan="10">Dados do Usuário</th>                                    
                                        </tr>
                                        <tr>
                                            <td>Nome completo</td>
                                            <td><?php echo getUserCompleteName(getQueryLogsUserID($query_ID));?> </td>
                                            <td>CPF</td>
                                            <td><?php echo getUserCPF(getQueryLogsUserID($query_ID));?> </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><?php echo  getAccountEmail(getUserAccountID(getQueryLogsUserID($query_ID)));?> </td>
                                            <td>Celular</td>
                                            <td><?php echo  getAccountPhone(getUserAccountID(getQueryLogsUserID($query_ID)));?> </td>
                                        </tr>
                                        <tr>
                                            <th colspan="10">Dados da Solicitação</th>                                    
                                        </tr>
                                        <tr>
                                            <td>Data da Solicitação</td>
                                            <td><?php echo doDateConvert(getQueryLogsDate($query_ID)).' - '.getQueryLogsTime($query_ID) ?> </td>
                                            <td>Tipo de Pagamento</td>
                                            <td><?php echo  getTypeCreditName(getQueryLogsCreditType($query_ID));?></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td><?php echo getStatusQuery(getQueryLogsStatus($query_ID)); ?></td>
                                            <td>Cronômetro</td>
                                            <td><div style="--progress: <?php echo getPercentProgressBarStopped((getQueryLogsDate($query_ID).' '.getQueryLogsTime($query_ID)), (getQueryLogsFinishedDate($query_ID).' '.getQueryLogsFinishedTime($query_ID)), doSetDateTime((getQueryLogsDate($query_ID).' '.getQueryLogsTime($query_ID)), getTypeCreditTime(getQueryLogsCreditType($query_ID)))) ?>"class="classProgressBar" ></div></td>
                                        </tr>
                                        <tr>
                                            <td>Atribuido a</td>
                                            <td><?php echo getUserCompleteName(getQueryLogsAssigned($query_ID)) ?></td>
                                            <td>Data da Atribuição</td>
                                            <td><?php echo  doDateConvert(getQueryLogsAssignedDate($query_ID)).' - '.getQueryLogsAssignedTime($query_ID);?></td>
                                        </tr>
                                        <tr>
                                            <td>Fechado Por</td>
                                            <td><?php echo getUserCompleteName(getQueryLogsFinishedUserId($query_ID)) ?></td>
                                            <td>Data do Fechamento:</td>
                                            <td><?php echo  doDateConvert(getQueryLogsFinishedDate($query_ID)).' - '.getQueryLogsFinishedTime($query_ID);?></td>
                                        </tr>
                                    </table>
                                    </br>
                                    <?php setToken('tokenQueryEdit') ?>
                                    <input name="token" type="text" value="<?php echo addToken('tokenQueryEdit') ?>" hidden/>
                                    <input name="query_ID" type="text" value="<?php echo $query_ID ?>" hidden/>
                                    <?php
                                    if(!isset($_GET['user'])) {
                                    ?>
                                        <center>
                                            <a href="adminQueriesLogs.php">
                                                <button type="button" class="otherButton">Voltar</button>
                                            </a>
                                        </center>
                                    <?php
                                    } else {
                                    ?>
                                    <center>
                                        <a href="adminUsers.php?cod=<?php echo $_GET['user']; ?>">
                                            <button type="button" class="otherButton">Voltar</button>
                                        </a>
                                    </center>
                                    <?php
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        <?php
        }
        ?>
    </div>
 

</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
