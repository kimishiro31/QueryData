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
        if (empty($_POST) === false && getToken('tokenQuery')) {

            if(array_key_exists($_POST['selectQuery'], config('configQueries')) === false) {
                $errors[] = 'Escolha um tipo de consulta valido!';
            }

            if(array_key_exists($_POST['selectCredit'], config('typeCredits')) === false) {
                $errors[] = 'Escolha um tipo de pagamento valido!';
            }

            if($_POST['selectQuery'] === '1' && (empty($_POST['cName']) || empty($_POST['bDate']))) {
                $errors[] = 'Favor preencher o nome e data de nascimento, respeitando as regras:</br> * Sem abreviação</br> * Sem acêntuação.';
            }
            
            if($_POST['selectQuery'] === '1' && getWordCount($_POST['cName'], 1) === true) {
                $errors[] = "Nome invalido, o mesmo é muito curto.";
            }

            if ($_POST['selectQuery'] === '1' && getStringAZ($_POST['cName']) === false) {
                $errors[] = "No campo sobrenome, somente é aceito caracteres alfabetico e sem acentuação.";
            }


            if($_POST['selectQuery'] === '2' && (empty($_POST['cpf']))) {
                $errors[] = 'Favor preencher com um CPF.';
            }
            
            if($_POST['selectQuery'] === '2' && getSizeString($_POST['cpf'], 11, 11) !== true) {
                $errors[] = "CPF invalido, o mesmo é muito curto ou muito longo.";
            }


            if($_POST['selectQuery'] === '3' && (empty($_POST['cnpj']))) {
                $errors[] = 'Favor preencher com um CNPJ.';
            }

            if($_POST['selectQuery'] === '3' && getSizeString($_POST['cnpj'], 14, 14) !== true) {
                $errors[] = "cnpj invalido, o mesmo é muito curto ou muito longo.";
            }

            if($_POST['selectQuery'] === '4' && (empty($_POST['board']))) {
                $errors[] = 'Favor preencher com um Board.';
            }

            if($_POST['selectQuery'] === '5' && (empty($_POST['score']))) {
                $errors[] = 'Favor preencher com um CPF.';
            }

            if($_POST['selectQuery'] === '5' && getSizeString($_POST['score'], 11, 11) !== true) {
                $errors[] = "CPF invalido, o mesmo é muito curto ou muito longo.";
            }
            /* VALIDAÇÕES DADOS PESSOAIS - TELEFONE */
            if ($_POST['selectQuery'] === '6' && (!empty(sanitizeString($_POST['phone'])) && is_numeric(sanitizeString($_POST['phone'])) === false)) {
                $errors[] = "Numero de telefone só pode ter numeros.";
            }
            if ($_POST['selectQuery'] === '6' && (!empty(sanitizeString($_POST['phone'])) && getSizeString(sanitizeString($_POST['phone']), 8, 20) !== true)) {
                $errors[] = "Numero de telefone formato invalido.";
            }

        }

        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors) && getToken('tokenQuery')) {

            if($_POST['selectQuery'] == 1) {
                $value01 = $_POST['cName'];
                $value02 = $_POST['bDate'];
            }
            elseif($_POST['selectQuery'] == 2) {
                $value01 =  $_POST['cpf'];
                $value02 = NULL;
            }
            elseif($_POST['selectQuery'] == 3) {
                $value01 =  $_POST['cnpj'];
                $value02 = NULL;
            }
            elseif($_POST['selectQuery'] == 4) {
                $value01 =  $_POST['board'];
                $value02 = NULL;
            }
            elseif($_POST['selectQuery'] == 5) {
                $value01 =  $_POST['score'];
                $value02 = NULL;
            }
            elseif($_POST['selectQuery'] == 6) {
                $value01 =  $_POST['phone'];
                $value02 = NULL;
            }

            
            if($_POST['selectCredit'] == 1 && (getCreditUserValue(getCreditUser($userData['id'])) < getConfigQueryCost($_POST['selectQuery']))) {
                $errors[] = "Você não possui nenhum crédito para fazer consulta.";
            }
            elseif($_POST['selectCredit'] == 2 && (getUserPackValue($userData['id'], 1) < 1)) {
                $errors[] = "Você não possui nenhum vouncher de bronze para fazer consulta.";
            }
            elseif($_POST['selectCredit'] == 3 && (getUserPackValue($userData['id'], 2) < 1)) {
                $errors[] = "Você não possui nenhum vouncher de prata para fazer consulta.";
            }
            elseif($_POST['selectCredit'] == 4 && (getUserPackValue($userData['id'], 3) < 1)) {
                $errors[] = "Você não possui nenhum vouncher de ouro para fazer consulta.";
            }
            else {
                $queries_data = array(
                    'user_id' => $userData['id'],
                    'type' => $_POST['selectQuery'],
                    'value01' => $value01,
                    'value02' => $value02,
                    'pay_type' => $_POST['selectCredit'],
                    'date' => date("Y-m-d"),
                    'time' => date("H:i:s"),
                    'ip' => 12,
                    'status' => 3
                );
                if($_POST['selectCredit'] == 1) {
                    doRemoveUserCredit($userData['id'], getConfigQueryCost($_POST['selectQuery']));
                    $pay = true;
                }
                elseif($_POST['selectCredit'] == 2) {
                    doRemoveUserVouncher($userData['id'], 1, 1);
                    $pay = true;
                }
                elseif($_POST['selectCredit'] == 3) {
                    doRemoveUserVouncher($userData['id'], 1, 2);
                    $pay = true;
                }
                elseif($_POST['selectCredit'] == 4) {
                    doRemoveUserVouncher($userData['id'], 1, 3);
                    $pay = true;
                }
                
                $msg[] = "Sua consulta foi enviada com sucesso.";
                $msg[] = "O resultado será encaminhado via Email.";
                $msg = implode('<br/>', $msg);
                doAddQuery($queries_data);
                echo doPopupSuccess($msg);
    //            header('refresh: 5, login.php');
            }
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

<div id="divUqContent">

    <center>
        <label id="divUqStart" class="labelTitleContainer_2">Painel de Usúario</label>
    </center>
    <hr size="1" align="center" noshade></br></br></br>

    
    <?php include 'layout/overall/menu/bodyMenuUser.php'; ?>
   <div id="divUqContainer">
        <script>
        function exibir_ocultar(){
            var valor = $("#divSelectQuery").val();

            if(valor == '0') {
                $("#divUqName").hide();
                $("#divUqBDate").hide();
                $("#divUqCPF").hide();
                $("#divUqCNPJ").hide();
                $("#divUqBoard").hide();
                $("#divUqScore").hide();
                $("#divUqPhone").hide();
            } 
            else if(valor == '1') {
                $("#divUqName").show();
                $("#divUqBDate").show();
                $("#divUqCPF").hide();
                $("#divUqCNPJ").hide();
                $("#divUqBoard").hide();
                $("#divUqScore").hide();
                $("#divUqPhone").hide();
            } 
            else if(valor == '2') {
                $("#divUqName").hide();
                $("#divUqBDate").hide();
                $("#divUqCPF").show();
                $("#divUqCNPJ").hide();
                $("#divUqBoard").hide();
                $("#divUqScore").hide();
                $("#divUqPhone").hide();
            }
            else if(valor == '3') {
                $("#divUqName").hide();
                $("#divUqBDate").hide();
                $("#divUqCPF").hide();
                $("#divUqCNPJ").show();
                $("#divUqBoard").hide();
                $("#divUqScore").hide();
                $("#divUqPhone").hide();
            }
            else if(valor == '4') {
                $("#divUqName").hide();
                $("#divUqBDate").hide();
                $("#divUqCPF").hide();
                $("#divUqCNPJ").hide();
                $("#divUqBoard").show();
                $("#divUqScore").hide();
                $("#divUqPhone").hide();
            }
            else if(valor == '5') {
                $("#divUqName").hide();
                $("#divUqBDate").hide();
                $("#divUqCPF").hide();
                $("#divUqCNPJ").hide();
                $("#divUqBoard").hide();
                $("#divUqScore").show();
                $("#divUqPhone").hide();
            }
            else if(valor == '6') {
                $("#divUqName").hide();
                $("#divUqBDate").hide();
                $("#divUqCPF").hide();
                $("#divUqCNPJ").hide();
                $("#divUqBoard").hide();
                $("#divUqScore").hide();
                $("#divUqPhone").show();
            }
        };
        </script>
        <center>
            <label id="divUqQuery" class="labelTitleContainer_2">Consultar</label>
        </center>
        <hr size="1" align="center" noshade></br>

        <div id="divUqSelecsOption">
            <form action="" method="post">
                <select id="divSelectQuery" name="selectQuery" class="mediumSelectInp" onchange="exibir_ocultar()">
                    <option value="0" selected>-- TIPO DE CONSULTA --</option>
                    <option value="1"><?php echo getTypeQuery(1).' - QD$ '.getConfigQueryCost(1); ?></option>
                    <option value="2"><?php echo getTypeQuery(2).' - QD$ '.getConfigQueryCost(2); ?></option>
                    <option value="3"><?php echo getTypeQuery(3).' - QD$ '.getConfigQueryCost(3); ?></option>
                    <option value="4"><?php echo getTypeQuery(4).' - QD$ '.getConfigQueryCost(4); ?></option>
                    <option value="5"><?php echo getTypeQuery(5).' - QD$ '.getConfigQueryCost(5); ?></option>
                    <option value="6"><?php echo getTypeQuery(6).' - QD$'.getConfigQueryCost(6); ?></option>
                </select>
                <select name="selectCredit" class="mediumSelectInp">
                    <option value="0" selected>-- Tipo de Pagamento --</option>
                    <option value="1"><?php echo getTypeCreditName(1); ?></option>
                    <option value="2"><?php echo getTypeCreditName(2); ?></option>
                    <option value="3"><?php echo getTypeCreditName(3); ?></option>
                    <option value="4"><?php echo getTypeCreditName(4); ?></option>
                </select>
                <input id="divUqName" hidden name="cName" class="mediumInputTxt" type="text" placeholder="Nome Completo"/>
                <input id="divUqBDate" hidden name="bDate" class="mediumInputTxt" type="date"/>
                <input id="divUqCPF" hidden name="cpf" class="mediumInputTxt" type="text" placeholder="CPF"/>
                <input id="divUqCNPJ" hidden name="cnpj" class="mediumInputTxt" type="text" placeholder="CNPJ"/>
                <input id="divUqBoard" hidden name="board" class="mediumInputTxt" type="text" placeholder="Placa"/>
                <input id="divUqScore" hidden name="score" class="mediumInputTxt" type="text" placeholder="CPF"/>
                <input id="divUqPhone" hidden name="phone" class="mediumInputTxt" type="text" placeholder="Telefone"/>
                <?php setToken('tokenQuery') ?>
                <input name="token" type="text" value="<?php echo addToken('tokenQuery') ?>" hidden/>
                </br></br>
                <button type="submit" class="enterButton">Consultar</button>
            </form>
        </div>
        </br></br>
        
        <center>
            <label id="divUqQueryLogs" class="labelTitleContainer_2">Consultas em Processamento</label>
        </center>
        <hr size="1" align="center" noshade></br>

        <div id="divUqHistoryContainer">
            <table class="classTableGeneral">
                <tr>
                    <th>COD</th>
                    <th>CONSULTA</th>
                    <th>MOEDA</th>
                    <th>DATA CONSULTA</th>
                    <th>STATUS</th>
                </tr>
                <?php 
                
            $queries = getQueriesUser($userData['id'], 0, 5);
            if($queries) {
                foreach($queries as $key) {
                    if(getQueryType($key['id']) == 1)
                        $queryValue = getTypeQuery(getQueryType($key['id'])).':</br>'.getQueryValue($key['id']).' - '.doDateConvert(getQueryValue($key['id'], 2));
                    else
                        $queryValue = getTypeQuery(getQueryType($key['id'])).': '.getQueryValue($key['id']);

                    echo '
                        <tr>
                            <td>'.doTransformCode($key['id']).'</td>
                            <td>'.$queryValue.'</td>
                            <td>'.getTypeCreditName(getQueryCreditType($key['id'])).'</td>
                            <td>'.doDateConvert(getQueryDate($key['id'])).' - '.getQueryTime($key['id']).'</td>
                            <td>'.getStatusQuery(getQueryStatus($key['id'])).'</td>
                        </tr>
                    ';
                }
            }
                ?>
            </table>
        </br></br></br>
            
        <center>
            <label id="divUqQueryLogs" class="labelTitleContainer_2">Histórico de Consultas</label>
        </center>
        <hr size="1" align="center" noshade></br>

        <div id="divUqQueryHistoryContainer">
            <table class="classTableGeneral">
                <tr>
                    <th>COD</th>
                    <th>CONSULTA</th>
                    <th>MOEDA</th>
                    <th>DATA CONSULTA</th>
                    <th>STATUS</th>
                </tr>
                <?php 
                
            $queriesLogs = getQueriesLogsUser($userData['id'], 0, 5);
            if($queriesLogs) {
                foreach($queriesLogs as $key) {
                    if(getQueryLogsType($key['id']) == 1)
                        $QueryLogsValue = getTypeQuery(getQueryLogsType($key['id'])).':</br>'.getQueryLogsValue($key['id']).' - '.doDateConvert(getQueryLogsValue($key['id'], 2));
                    else
                        $QueryLogsValue = getTypeQuery(getQueryLogsType($key['id'])).': '.getQueryLogsValue($key['id']);

                    echo '
                        <tr>
                            <td>'.doTransformCode($key['id']).'</td>
                            <td>'.$QueryLogsValue.'</td>
                            <td>'.getTypeCreditName(getQueryLogsCreditType($key['id'])).'</td>
                            <td>'.doDateConvert(getQueryLogsDate($key['id'])).' - '.getQueryLogsTime($key['id']).'</td>
                            <td>'.getStatusQuery(getQueryLogsStatus($key['id'])).'</td>
                        </tr>
                    ';
                }
            }
                ?>
            </table>
        </div>
    </div>


</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
