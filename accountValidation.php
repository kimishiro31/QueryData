<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
doProtect();
doAccountActiveRedirect($accountData['id']);

        /* EMAIL */
        
        if (empty($_POST) === false && getToken('tokenEditEmail')) {
            if(isAccountExist(getAccountIDPerEmail($_POST['email'])) !== false) {
                $errors[] = "O Email informado, já se encontra registrado em nosso banco de dados.";
            }
        }

        if (empty($_POST) === false && empty($errors)  && getToken('tokenEditEmail')) {

            $account_data =  array(
                'account_ID' 	    => $accountData['id'],
                'email' 	    	=> $_POST['email'],
                'username' 	    	=> $_POST['email'],
            );

            $msg[] = "Seu email foi alterado com sucesso!!";
            $msg[] = "Foi encaminhado um novo código para o seu email.";
            $msg = implode('<br/>', $msg);
            echo doPopupSuccess($msg);
            doUpdateAccount($account_data);
            setAccountNewCodeEmail($accountData['id'], $userData['id']);
            
//            header('refresh: 5, login.php');
        }
  

        if (empty($_POST) === false && getToken('tokenSendECode')) {
            
            if(getAccountEmailCodeDate($accountData['id']) > date("Y-m-d H:i:s")) {
                echo doPopupWarning("Aguarde até ".doDateConvert(getAccountEmailCodeDate($accountData['id']), true).", e tente novamente.");
            } else {
                $msg[] = "Seu código foi enviado com sucesso!!";
                $msg[] = "Verifique a mensagem com instruções de ativação da conta que foi encaminho no email cadastrado.";
                $msg = implode('<br/>', $msg);
                echo doPopupSuccess($msg);
                setAccountNewCodeEmail($accountData['id'], $userData['id']);    
            }
        }
        /*********************************************************
        **
        ** VALIDAÇÃO DO FORMULARIO
        **
        **********************************************************/
        if (empty($_POST) === false && getToken('tokenConfirmECode')) {
            $required_fields = array('eCode');

            foreach($_POST as $key => $value) {
                if (empty($value) && in_array($key, $required_fields) === true) {
                    $errors[] = "Obrigatório o preenchimento de todos os campos.";
                    break 1;
                }                    
           }
           
            if ($_POST['eCode'] !== getAccountEmailCode($accountData['id'])) {
                $errors[] = "O código preenchido é invalido.";
            }
        }

        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors)  && getToken('tokenConfirmECode')) {

            $msg[] = "Seu cadastro foi efetuado com sucesso!!";
            $msg[] = "Foi encaminhado uma mensagem com instruções de ativação da conta para o email cadastrado.";
            $msg = implode('<br/>', $msg);
            echo doPopupSuccess($msg);
            doActiveEmail($accountData['id']);
            if(config('accountConfirm')['phone'] === false) 
            header('refresh: 5, myaccount.php');
        }
        
        
        /* TELEFONE */

        
        if (empty($_POST) === false && getToken('tokenEditPhone')) {
            if(isAccountExist(getAccountIDPerFPhone($_POST['phone'])) !== false) {
                $errors[] = "O Telefone informado, já se encontra registrado em nosso banco de dados.";
            }
        }
        
        if (empty($_POST) === false && empty($errors)  && getToken('tokenEditPhone')) {

            $account_data =  array(
                'account_ID' 	    => $accountData['id'],
                'phone' 	    	=> $_POST['phone'],
            );

            $msg[] = "Seu telefone foi alterado com sucesso!!";
            $msg[] = "Foi encaminhado um novo código para o seu telefone.";
            $msg = implode('<br/>', $msg);
            echo doPopupSuccess($msg);
            doUpdateAccount($account_data);
            setAccountNewCodePhone($accountData['id'], $userData['id']);
            
//            header('refresh: 5, login.php');
        }
  


        if (empty($_POST) === false && getToken('tokenSendTCode')) {
            
            if(getAccountPhoneCodeDate($accountData['id']) > date("Y-m-d H:i:s")) {
                echo doPopupWarning("Aguarde até ".doDateConvert(getAccountPhoneCodeDate($accountData['id']), true).", e tente novamente.");
            } else {
                $msg[] = "Seu código foi enviado com sucesso!!";
                $msg[] = "Verifique a mensagem com instruções de ativação da conta que foi encaminho no telefone cadastrado.";
                $msg = implode('<br/>', $msg);
                echo doPopupSuccess($msg);
                setAccountNewCodePhone($accountData['id'], $userData['id']);    
            }
        }
        /*********************************************************
        **
        ** VALIDAÇÃO DO FORMULARIO
        **
        **********************************************************/
        if (empty($_POST) === false && getToken('tokenConfirmTCode')) {
            $required_fields = array('tCode');

            foreach($_POST as $key => $value) {
                if (empty($value) && in_array($key, $required_fields) === true) {
                    $errors[] = "Obrigatório o preenchimento de todos os campos.";
                    break 1;
                }                    
           }
           
            if ($_POST['tCode'] !== getAccountPhoneCode($accountData['id'])) {
                $errors[] = "O código preenchido é invalido.";
            }
        }

        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors)  && getToken('tokenConfirmTCode')) {

            $msg[] = "Sua conta foi ativada com sucesso!!";
            $msg = implode('<br/>', $msg);
            echo doPopupSuccess($msg);
            doActivePhone($accountData['id']);
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

<div id="divAValidationContent">

    <center>
        <label class="labelTitleContainer_2">Validação de Conta</label>
    </center>
    <hr size="1" align="center" noshade></br></br></br>
    <p>Seja bem vindo <b>Thiago de Oliveira Lima</b>, para que melhor possamos atender você, precisamos que confirme seu email e número de telefone. Foi encaminhado um código para o email e telefone cadastrado, favor inserir.</p></br>

    <div id="divAValidationContainer">
        <?php
        if(getAccountEmailActive($accountData['id']) === false) {
        ?>
            <div id="divProgressContainer">
                <ol class="progress" data-steps="4">
                    <li class="active">
                        <span class="name">Verificação de Email</span>
                        <span class="step"><span>1</span></span>
                    </li>
                    <li>
                        <span class="name">Verificação de Telefone</span>
                        <span class="step"><span>2</span></span>
                    </li>
                    <li>
                        <span class="name">Concluído</span>
                        <span class="step"><span>3</span></span>
                    </li>
                </ol>
            </div>
            </br>
            <form action="" method="post">
                <?php setToken('tokenConfirmECode') ?>
                <input name="token" type="text" value="<?php echo addToken('tokenConfirmECode') ?>" hidden/>
                <input class="mediumInputTxt" type="text" placeholder="Código Email" name="eCode"/></br></br>
                <button type="submit" class="otherButton">Confirmar</button>
            </form>
            </br>
            <form action="" method="post">   
                <?php setToken('tokenSendECode') ?>
                <input name="token" type="text" value="<?php echo addToken('tokenSendECode') ?>" hidden/>
                <button type="submit" class="enterButton">Reenviar Código</button>
            </form>

            </br></br>
            </br></br>
            </br></br>
            </br></br>
            </br></br>
            </br></br>

            <p>Caso o Email esteja errado, você pode corrigir aqui:</p>
                <form action="" method="post">
                    <?php setToken('tokenEditEmail') ?>
                    <input name="token" type="text" value="<?php echo addToken('tokenEditEmail') ?>" hidden/>
                    <input class="mediumInputTxt" name="email" value="<?php echo getAccountEmail($userData['id']); ?>">                    
                    <button type="submit" class="otherButton">Corrigir</button>
                </form>
        <?php
        }
        if(getAccountEmailActive($accountData['id']) === true && getAccountPhoneActive($accountData['id']) === false) {
        ?>
            <div id="divProgressContainer">
                <ol class="progress" data-steps="4">
                    <li class="done">
                        <span class="name">Verificação de Email</span>
                        <span class="step"><span>1</span></span>
                    </li>
                    <li class="active">
                        <span class="name">Verificação de Telefone</span>
                        <span class="step"><span>2</span></span>
                    </li>
                    <li>
                        <span class="name">Concluído</span>
                        <span class="step"><span>3</span></span>
                    </li>
                </ol>
            </div>
            </br>
            <form action="" method="post">
                <?php setToken('tokenConfirmTCode') ?>
                <input name="token" type="text" value="<?php echo addToken('tokenConfirmTCode') ?>" hidden/>
                <input class="mediumInputTxt" type="text" placeholder="Código Telefone" name="tCode"/></br></br>
                <button type="submit" class="otherButton">Confirmar</button>
            </form>
            </br>
            <form action="" method="post">   
                <?php setToken('tokenSendTCode') ?>
                <input name="token" type="text" value="<?php echo addToken('tokenSendTCode') ?>" hidden/>
                <button type="submit" class="enterButton">Reenviar Código</button>
            </form>
            </br></br>
            </br></br>
            </br></br>
            </br></br>
            </br></br>
            </br></br>

            <p>Caso o Telefone esteja errado, você pode corrigir aqui:</p>
                <form action="" method="post">
                    <?php setToken('tokenEditPhone') ?>
                    <input name="token" type="text" value="<?php echo addToken('tokenEditPhone') ?>" hidden/>
                    <input class="mediumInputTxt" name="phone" value="<?php echo getAccountPhone($userData['id']); ?>">
                    <button type="submit" class="otherButton">Corrigir</button>
                </form>
        <?php
        }        
        if(getAccountEmailActive($accountData['id']) === true && getAccountPhoneActive($accountData['id']) === true) {
        ?>
            <div id="divProgressContainer">
                <ol class="progress" data-steps="4">
                    <li class="done">
                        <span class="name">Verificação de Email</span>
                        <span class="step"><span>1</span></span>
                    </li>
                    <li class="done">
                        <span class="name">Verificação de Telefone</span>
                        <span class="step"><span>2</span></span>
                    </li>
                    <li class="active">
                        <span class="name">Concluído</span>
                        <span class="step"><span>3</span></span>
                    </li>
                </ol>
                </br>
                <p>Parabêns, foi concluído todas as verificações.</p></br>
                <a href="myaccount.php">
                    <button type="submit" class="otherButton">Confirmar</button>
                </a>
            </div>
            </br>
        <?php
        }
        ?>
    </div>


</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
