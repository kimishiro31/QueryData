<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
getManagerAccess();

doAccountActiveRedirect($accountData['id'], true);

        /*********************************************************
        **
        ** VALIDAÇÃO DO FORMULARIO DE DELETE
        **
        **********************************************************/
        if (empty($_POST) === false && getToken('tokenUserDeleted')) {
            setToken('tokenUserDConfirmed');
            $warning = "
                    Você está prestes a deletar este usuário, se você apertar no botão confirmar, serão apagados todos os dados abaixo:</br>
                    * Dados da Conta </br>
                    * Informações do Usuário </br>
                    * Informações de Consulta </br>
                    * Histórico de Crédito </br>
                    * Histórico de Pagamento </br>
                    * Outros dados relacionados ao mesmo </br></br></br>
                    <b>Você confirma que quer fazer isso?</b></br></br>
                    <form action='' method='POST'>
                        <input name='token' type='text' value='".addToken('tokenUserDConfirmed')."' hidden/>
                        <input name='user_ID' type='text' value='".$_POST['user_ID']."' hidden/>
                        <button type='submit' class='enterButton'>Confirmar</button>
                        <button type='button' onclick='window.location.href=window.location.href'  class='backButton'>Cancelar</button>
                    </form>
            ";
            echo doPopupWarning($warning);
        }
        
        if (empty($_POST) === false && getToken('tokenUserDConfirmed')) {
            if(isUserExist($_POST['user_ID']) === false) {
                $errors[] = 'Usuário selecionado não existe.';
            }
        }

        /*********************************************************
        **
        ** SE O FORMULARIO DE DELETE VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors) && getToken('tokenUserDConfirmed')) {
            doDeleteUser($_POST['user_ID']);
            echo doPopupSuccess("O usuário foi deletado do banco de dados com sucesso.");
        }
        






















        /*********************************************************
        **
        ** VALIDAÇÃO DO FORMULARIO
        **
        **********************************************************/
        if (empty($_POST) === false && getToken('tokenUserEdited')) {
            
            if(isUserExist($_POST['user_ID']) === false) {
                $errors[] = 'Usuário selecionado não existe.';
            }

            if(!empty($_POST['password']) && getSizeString($_POST['password'], 8, 20) !== true) {
                $errors[] = "A senha está muito pequena ou muito grande, MIN: 8 | MAX: 20 caracteres.";
            }

            /* VALIDAÇÕES DADOS PESSOAIS - GÊNERO */
            if ($_POST['gender'] !== 'M' && $_POST['gender'] !== 'F') {
                $errors[] = "Favor verificar o gênero, o mesmo está errado.";
            }

            /* VALIDAÇÕES DADOS PESSOAIS - GÊNERO */
            if ($_POST['accountStatus'] !== '0' && $_POST['accountStatus'] !== '1') {
                $errors[] = "Favor verificar o status da conta, o mesmo está errado.";
            }

            /* VALIDAÇÕES DADOS PESSOAIS - TELEFONE */
            if (!empty(sanitizeString($_POST['phone01'])) && is_numeric(sanitizeString($_POST['phone01'])) === false) {
                $errors[] = "Numero de telefone só pode ter numeros.";
            }
            if(!empty(sanitizeString($_POST['phone01'])) && getSizeString(sanitizeString($_POST['phone01']), 8, 20) !== true) {
                $errors[] = "Numero de telefone invalido.";
            }
                
            /* VALIDAÇÕES ENDEREÇO - CEP */
            if (!empty(sanitizeString($_POST['cep'])) && is_numeric(sanitizeString($_POST['cep'])) === false) {
                $errors[] = "No CEP somente é aceito numeração.";
            }
            elseif (!empty(sanitizeString($_POST['cep'])) && strlen(sanitizeString($_POST['cep'])) < 1 || strlen(sanitizeString($_POST['cep'])) > 8) {
                $errors[] = "CEP tem que conter no minímo de 8 caracteres.";
            }
            elseif (!empty(sanitizeString($_POST['cep'])) && isSameCharacter(sanitizeString($_POST['cep']))) {
                $errors[] = "CEP invalido.";
            }
        }

        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors) && getToken('tokenUserEdited')) {
            
            $user_data =  array(
                'user_ID' 	        => $_POST['user_ID'],
                'rg' 			    => $_POST['rg'],
                'gender' 			=> $_POST['gender'],
                'street' 			=> $_POST['street'],
                'district' 		    => $_POST['district'],
                'number' 		    => $_POST['number'],
                'complement'        => $_POST['complement'],
                'cep'               => sanitizeString($_POST['cep']),
                'city'              => $_POST['city'],
                'uf'                => $_POST['uf'],
                'nacionality'       => $_POST['nacionality']
            );
            doUpdateUser($user_data);

            
            $account_data =  array(
                'account_ID' 	    => getUserAccountID($_POST['user_ID']),
                'password' 			=> $_POST['password'],
                'phone' 		    => sanitizeString($_POST['phone01']),
                'email' 	    	=> $_POST['email'],
                'group' 			=> $_POST['group'],
                'status'            => $_POST['accountStatus']
            );
                
            doUpdateAccount($account_data);
            echo doPopupSuccess("Essa consulta foi finalizada com sucesso.");
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
    function popupAdminClose(){
		window.location.href = "adminUsers.php";
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


	jQuery(function($){ 
		$("#phone01").mask("(99) 9999-99990"); 
		$("#address_cep").mask("99999-990"); 
    }); 
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
                <a href="#divApStart">
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
            <label id="divApStart" class="labelTitleContainer_2">Usuários</label>
        </center>
        <hr size="1" align="center" noshade></br></br></br>

        <div id="divApSearchContainer">
            <form action="" method="get">
                <input name="search" class="mediumInputTxt" placeholder="Procure..."/>
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
                <th>NOME COMPLETO</th>
                <th>CPF</th>
                <th>TELEFONE</th>
                <th>EMAIL</th>
            </tr>
            <?php
                    
            if(isset($_GET['search']) && !empty($_GET['search']))
                $queriesUsers = getAllUsers($rp['ppage'], $rp['rowsPerPage'], $_GET['search']);
            else
                $queriesUsers = getAllUsers($rp['ppage'], $rp['rowsPerPage']);

            if($queriesUsers) {
                foreach($queriesUsers as $key) {
            ?>
                        <tr onclick="location.href='adminUsers.php?cod=<?php echo $key['id']; ?>'">
                            <td><?php echo doTransformCode($key['id']) ?></td>
                            <td><?php echo getUserCompleteName($key['id']) ?></td>
                            <td><?php echo getUserCPF($key['id']); ?></td>
                            <td><?php echo getAccountPhone(getUserAccountID($key['id'])) ?></td>
                            <td><?php echo getAccountEmail(getUserAccountID($key['id'])) ?></td>
                        </tr>
            <?php
                }
            }              
            ?>
        </table>

        <!-- PARTE DO MODAL -->
        <?php

        if(isset($_GET['cod']) && !empty($_GET['cod'])) {
            $user_ID = $_GET['cod'];
            $account_ID = getUserAccountID($user_ID);
        ?>
            <div id="divAdminUserBody">
                    <div id="divAdminUserMainDescription">
                        <button  onclick="popupAdminClose('divAdminUserBody', 'flex')" type="button" id="divQuerUserCloseDescription">X</button>
                        <div id="divAdminUserBorderDescription">
                            <div id="divQuerUserContentDescription">
                                <center>
                                    <label id="divApStart" class="labelTitleContainer_2">Usuário - <?php echo doTransformCode($user_ID) ?></label>
                                </center>
                                <hr size="1" align="center" noshade></br>
                                <form action="" method="POST">
                                    <table class="classTableListQueries">
                                        <tr>
                                            <th colspan="10">Dados do Usuário</th>                                    
                                        </tr>
                                        <tr>
                                            <td>Codigo</td>
                                            <td><?php echo doTransformCode($user_ID) ?></td>
                                            <td>Nome Completo</td>
                                            <td><?php echo getUserCompleteName($user_ID); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Data de Nascimento</td>
                                            <td><?php echo getUserBirthDate($user_ID); ?></td>
                                            <td>Gênero</td>
                                            <td>
                                                <select name="gender" style="height: 25px;" class="smallSelectInp">
                                                    <option value="F" <?php if(getUserGender($user_ID) === 'F') echo 'selected' ?>>Feminino</option>
                                                    <option value="M" <?php if(getUserGender($user_ID) === 'M') echo 'selected' ?>>Masculino</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CPF</td>
                                            <td><?php echo getUserCPF($user_ID); ?></td>
                                            <td>RG</td>
                                            <td>
                                                <input name="rg" class="tableInputTxt" type="text" placeholder="<?php echo getUserRG($user_ID); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CEP</td>
                                            <td>
                                                <input name="cep" id="address_cep" class="tableInputTxt" type="text" placeholder="<?php echo getUserAddressCEP($user_ID); ?>"/>
                                            </td>
                                            <td>Rua</td>
                                            <td>
                                                <input name="street" id="address_street" class="tableInputTxt" type="text" placeholder="<?php echo getUserAddressStreet($user_ID); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nº</td>
                                            <td>
                                                <input name="number" id="address_number" class="tableInputTxt" type="text" placeholder="<?php echo getUserAddressNumber($user_ID); ?>"/>
                                            </td>
                                            <td>Complemento</td>
                                            <td>
                                                <input name="complement" id="address_complement" class="tableInputTxt" type="text" placeholder="<?php echo getUserAddressComplement($user_ID); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bairro</td>
                                            <td>
                                                <input name="district" id="address_district" class="tableInputTxt" type="text" placeholder="<?php echo getUserAddressDistrict($user_ID); ?>"/>
                                            </td>
                                            <td>Cidade</td>
                                            <td>
                                            <input name="city" id="address_city" class="tableInputTxt" type="text" placeholder="<?php echo getUserAddressCity($user_ID); ?>"/>/
                                            <input name="uf" id="address_uf" style="width: 50px;" class="tableInputTxt" type="text" placeholder="<?php echo getUserAddressUF($user_ID); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nacionalidade</td>
                                            <td>
                                                <input name="nacionality" class="tableInputTxt" type="text" placeholder="<?php echo getUserNacionality($user_ID); ?>"/>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="10">Dados da Conta</th>                                    
                                        </tr>
                                        <tr>
                                            <td>Codigo</td>
                                            <td>0001</td>
                                            <td>Status</td>
                                            <td>
                                                <select name="accountStatus" style="height: 25px;" class="smallSelectInp">
                                                    <option value="1" <?php if(getAccountStatus($user_ID) == 1) echo 'selected' ?>>Ativado</option>
                                                    <option value="0" <?php if(getAccountStatus($user_ID) == 0) echo 'selected' ?>>Desativado</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Usuário</td>
                                            <td><?php echo getAccountUserName($account_ID); ?></td>
                                            <td>Senha</td>
                                            <td>
                                                <input name="password" class="tableInputTxt" type="password" placeholder="Senha"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>
                                                <input name="email" class="tableInputTxt" type="text" placeholder="<?php echo getAccountEmail($account_ID); ?>"/>
                                            </td>
                                            <td>Email Status</td>
                                            <td><?php echo getStatusVerify(getAccountEmailActive($account_ID)); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Telefone</td>
                                            <td>
                                                <input name="phone01" class="tableInputTxt" type="text" placeholder="<?php echo getAccountPhone($account_ID); ?>"/>
                                            </td>
                                            <td>Telefone Status</td>
                                            <td><?php echo getStatusVerify(getAccountPhoneActive($account_ID)); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Data de Criação</td>
                                            <td><?php echo getAccountDateCreated($account_ID); ?></td>
                                            <td>IP</td>
                                            <td><?php echo getAccountIPCreated($account_ID); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nível de Acesso</td>
                                            <td>
                                                <select <?php if(isAdmin($accountData['id']) === false) echo 'disabled'; else echo 'name="group"'; ?> class="mediumSelectInp">
                                                    <?php
                                                        $selectGroup = config('adminGroups'); 
                                                        if($selectGroup !== false) {
                                                            foreach($selectGroup as $key => $value) {
                                                    ?>
                                                                <option value="<?php echo $key ?>" <?php if(getAccountGroup($account_ID) == $key) echo 'selected' ?>><?php echo $value ?></option>';
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="10">Créditos e Medalhas</th>                                    
                                        </tr>
                                        <tr>
                                            <td>Crédito</td>
                                            <td><?php echo getCreditUserValue(getCreditUser($user_ID)) ?></td>
                                            <td>Medalha Bronze</td>
                                            <td><?php echo getUserPackValue($user_ID, 1); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Medalha Prata</td>
                                            <td><?php echo getUserPackValue($user_ID, 2); ?></td>
                                            <td>Medalha Ouro</td>
                                            <td><?php echo getUserPackValue($user_ID, 3); ?></td>
                                        </tr>
                                    </table>
                                    </br></br>
                                    <center>
                                    <label id="divApStart" class="labelTitleContainer_2">Consultas - Aguardando</label>
                                    </center>
                                    <hr size="1" align="center" noshade></br>
                                    <table class="classTableGeneral classTableClick">
                                        <tr>
                                            <th>COD</th>
                                            <th>CONSULTA</th>
                                            <th>DATA CONSULTA</th>
                                            <th>ATRIBUIDO A</th>
                                            <th>STATUS</th>
                                        </tr>
                                        <?php
                                        $queriesWaiting = getQueriesUser($user_ID, 0, 10);
                                        if($queriesWaiting) {
                                            foreach($queriesWaiting as $key) {
                                                if(getQueryType($key['id']) == 1)
                                                    $queryValue = getTypeQuery(getQueryType($key['id'])).':</br>'.getQueryValue($key['id']).' - '.doDateConvert(getQueryValue($key['id'], 2));
                                                else
                                                    $queryValue = getTypeQuery(getQueryType($key['id'])).': '.getQueryValue($key['id']);
                                        ?>
                                                    <tr onclick="location.href='adminListQueries.php?cod=<?php echo $key['id']; ?>&user=<?php echo $user_ID; ?>'">
                                                        <td><?php echo doTransformCode($key['id']) ?></td>
                                                        <td><?php echo $queryValue ?></td>
                                                        <td><?php echo doDateConvert(getQueryDate($key['id'])).' - '.getQueryTime($key['id']) ?></td>
                                                        <td><?php echo getUserCompleteName(getQueryAssigned($key['id'])) ?></td>
                                                        <td><div style="--progress: <?php echo getPercentProgressBar((getQueryDate($key['id']).' '.getQueryTime($key['id'])), doSetDateTime((getQueryDate($key['id']).' '.getQueryTime($key['id'])), getTypeCreditTime(getQueryCreditType($key['id'])))) ?>"class="classProgressBar" ></div></td>
                                                    </tr>
                                        <?php
                                            }
                                        }              
                                        ?>
                                    </table>

                                    <center>
                                    <label id="divApStart" class="labelTitleContainer_2">Consultas - Finalizada</label>
                                    </center>
                                    <hr size="1" align="center" noshade></br>
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
                                                    
                                        $queriesLogs = getQueriesLogsUser(getQueryLogsUserID($user_ID), 0, 10);
                                        if($queriesLogs) {
                                            foreach($queriesLogs as $key) {
                                                if(getQueryLogsType($key['id']) == 1)
                                                    $queryValue = getTypeQuery(getQueryLogsType($key['id'])).':</br>'.getQueryLogsValue($key['id']).' - '.doDateConvert(getQueryValue($key['id'], 2));
                                                else
                                                    $queryValue = getTypeQuery(getQueryLogsType($key['id'])).': '.getQueryLogsValue($key['id']);
                                        ?>
                                                    <tr onclick="location.href='adminQueriesLogs.php?cod=<?php echo $key['id']; ?>&user=<?php echo getQueryLogsUserID($key['id']); ?>'">
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

                                    <?php setToken('tokenUserEdited') ?>
                                    <input name="token" type="text" value="<?php echo addToken('tokenUserEdited') ?>" hidden/>
                                    <input name="user_ID" type="text" value="<?php echo $user_ID ?>" hidden/>
                                    </br></br>
                                    <center>
                                        <button type="submit" class="enterButton">Salvar</button>

                                    </form>
                                        <form action="" method="post" style="display: contents;">
                                            <?php setToken('tokenUserDeleted') ?>
                                            <input name="token" type="text" value="<?php echo addToken('tokenUserDeleted') ?>" hidden/>
                                            <input name="user_ID" type="text" value="<?php echo $user_ID ?>" hidden/>
                                            <button type="submit" class="backButton">Deletar</button>
                                        </form
                                    </center>
                            </div>
                        </div>
                    </div>
            </div>
        <?php
        }
        ?>
    </div>
 

</div>



<!-- JAVA SCRIPT -->
<script type="text/javascript">
	$("#address_cep").focusout(function(){
		$.ajax({
			url: 'https://viacep.com.br/ws/'+$(this).val()+'/json/',
			dataType: 'json',
			success: function(resposta){
				$("#address_street").val(resposta.logradouro);
				$("#address_complement").val(resposta.complemento);
				$("#address_district").val(resposta.bairro);
				$("#address_city").val(resposta.localidade);
				$("#address_uf").val(resposta.uf);
				$("#address_number").focus();
			}
		});
	});
</script>


<?php
require_once 'layout/overall/footer/footer.php'; 
?>
