<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
$inviteCode = (isset($_GET['code']) && !empty($_GET['code'])) ? $_GET['code'] : false;

        /*********************************************************
        **
        ** VALIDAÇÃO DO FORMULARIO
        **
        **********************************************************/
        if (empty($_POST) === false) {
            $required_fields = array('fName', 'sName', 'bDate', 'fPhone', 'cpf', 'email', 'password');
            
            foreach($_POST as $key => $value) {
                if (empty($value) && in_array($key, $required_fields) === true) {
                    $errors[] = "Obrigatório o preenchimento de todos os campos.";
                    break 1;
                }                    
           }

            if(getSizeString($_POST['fName'], 2, 12) !== true || getWordCount($_POST['fName'], 1) === false) {
                $errors[] = "Nome invalido, o mesmo é muito curto ou muito longo.";
            }

            if (getStringAZ($_POST['fName']) === false) {
                $errors[] = "No campo nome, somente é aceito caracteres alfabetico e sem acentuação.";
            }

            if (getStringAZ($_POST['sName']) === false) {
                $errors[] = "No campo sobrenome, somente é aceito caracteres alfabetico e sem acentuação.";
            }

            if(getSizeString($_POST['password'], 8, 20) !== true) {
                $errors[] = "A senha está muito pequena ou muito grande, MIN: 8 | MAX: 20 caracteres.";
            }
            
            if (preg_match("/^[0-9]+$/", $_POST['bDate']) === false) {
                $errors[] = "No campo data de nascimento, somente é aceito caracteres numérico.";
            }
            
            if (getOfAge($_POST['bDate']) === false && config('ofDate') === true) {
                $errors[] = "É necessário ser maior de idade.";
            }

            if(isSameCharacter(sanitizeString($_POST['fPhone'])) || preg_match("/^[0-9]+$/", sanitizeString($_POST['fPhone'])) === false) {
                $errors[] = "O campo telefone foi preenchido invalidamente, só é aceito caracteres numérico.";
            }

            if(isSameCharacter(sanitizeString($_POST['cpf'])) || preg_match("/^[0-9]+$/", sanitizeString($_POST['cpf'])) === false) {
                $errors[] = "O campo CPF foi preenchido invalidamente, só é aceito caracteres numérico.";
            }

            if(doCPFValidation(sanitizeString($_POST['cpf'])) === false) {
                $errors[] = "O CPF preenchido é invalido.";
            }

            if(isset($_POST['rules']) === false) {
                $errors[] = "É obrigatório aceitar as regras.";
            }

            if(isUserExist(sanitizeString(getUserIDPerCPF(sanitizeString($_POST['cpf'])))) !== false) {
                $errors[] = "O CPF informado, já se encontra registrado em nosso banco de dados, caso você tenha esquecido a senha, entre em contato com o suporte.";
            }
            if(isAccountExist(getAccountIDPerEmail($_POST['email'])) !== false) {
                $errors[] = "O Email informado, já se encontra registrado em nosso banco de dados, caso você tenha esquecido a senha, entre em contato com o suporte.";
            }
            if(isAccountExist(sanitizeString(getAccountIDPerFPhone($_POST['fPhone']))) !== false) {
                $errors[] = "O telefone informado, já se encontra registrado em nosso banco de dados, caso você tenha esquecido a senha, entre em contato com o suporte.";
            }
            if(!empty($_POST['cInvite']) && isExisitInviteCode($_POST['cInvite']) === false) {
                $errors[] = "Esse codigo de convite, não existe.";
            }
        }

        /*********************************************************
        **
        ** SE O FORMULARIO VALIDAR SEM ERROS
        **
        **********************************************************/
        if (empty($_POST) === false && empty($errors)) {

            $register_data = array(
                'fName' => $_POST['fName'],
                'sName' => $_POST['sName'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'bDate' => $_POST['bDate'],
                'fPhone' => sanitizeString($_POST['fPhone']),
                'cpf' => sanitizeString($_POST['cpf']),
                'rules' => $_POST['rules'],
                'cInvite' => $_POST['cInvite']
            );
            $msg[] = "Seu cadastro foi efetuado com sucesso!!";
            $msg[] = "Foi encaminhado uma mensagem com instruções de ativação da conta para o email cadastrado.";
            $msg = implode('<br/>', $msg);
            doCreateUser($register_data);
            echo doPopupSuccess($msg, 'login.php');
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
	jQuery(function($){ 
		$("#fPhone").mask("(99) 9999-99990"); 
		$("#cpf").mask("999.999.999/90"); 
    }); 
</script>

<div id="divRegisterContent">

    <div id="divRegisterContainer">

        <label class="labelTitleContainer">CADASTRO</label>
        <hr size="1" align="center" noshade></br></br>
        <form action="register.php" method="POST">
            <table style="width: 500px;margin: auto;">
                <tr>
                    <td>
                        <label class="labelTitleInput">Nome:</label> 
                    </td>
                    <td>
                        <input class="mediumInputTxt" type="text" name="fName" placeholder="Ex: Joel">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="labelTitleInput">Sobre Nome:</label> 
                    </td>
                    <td>
                        <input class="mediumInputTxt" type="text" name="sName" placeholder="Ex: da Conceição Santos">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="labelTitleInput">Email</label> 
                    </td>
                    <td>
                        <input class="mediumInputTxt" type="text" name="email" placeholder="Ex: email@gmail.com">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="labelTitleInput">Senha:</label> 
                    </td>
                    <td>
                        <input class="mediumInputTxt" type="password" name="password"  placeholder="********">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="labelTitleInput" >Data de Nascimento:</label> 
                    </td>
                    <td>
                        <input class="mediumInputTxt" type="date" name="bDate">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="labelTitleInput">Telefone:</label> 
                    </td>
                    <td>
                        <input class="mediumInputTxt" type="text" name="fPhone" id="fPhone">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="labelTitleInput">CPF</label> 
                    </td>
                    <td>
                        <input class="mediumInputTxt" type="text" name="cpf" id="cpf" placeholder="Ex: 123.123.123/12">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="labelTitleInput">Codigo de Convite</label> 
                    </td>
                    <td>
                        <input class="mediumInputTxt" type="text" name="cInvite" value="<?php echo $inviteCode; ?>" placeholder="Caso tenha sido convidado">
                    </td>
                </tr>
            </table></br>
            <input type="checkbox" name="rules"/>  <font color="white">Concordo que li o <b><a href="rules.php">Termo de Uso</a></b> e <a href="privacyPolicy.php"><b>Política de Privacidade</b>,</a> <a href="coockiesPolicy.php"><b>Política de Coockies</b>.</a></font></br></br>
            
            <button type="submit" class="enterButton">Cadastrar</button>
        </form>
    </div>


</div>

<script>
    var phone_number = window.intlTelInput(document.querySelector("#fPhone"), {
    separateDialCode: true,
    preferredCountries:["br"],
    hiddenInput: "full",
    utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    });
        
    $("form").submit(function() {
    var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
    $("input[name='fPhone'").val(full_number);    
    });
</script>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
