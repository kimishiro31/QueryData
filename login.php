<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
doLoginRedirect();

if (empty($_POST) === false) {
    $username = $_POST['username'];
    $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $errors[] = "Obrigatório o preenchimento de todos os campos.";
        } 
        else if (isAccountLoginExist($username) === false) {
            $errors[] = "Usuário digitado é invalido.";
        } 
        else {
            // Começa o login
            $login = getLoginValidation($username, $password);
            if ($login === false) {
                $errors[] = "Usuário ou senha invalido.";
            }
            elseif (isBlockedAccount($login) === true) {
                $errors[] = "Sua conta está temporariamente suspensa, entre em contato com um funcionário para o desbloqueio da mesma.";
            }
            else {          
                setSession('user_id', $login);
                if(getAccountPhoneActive($login) === false || getAccountEmailActive($login) === false) {
                    header('Location: accountValidation.php');
                    exit();
                } else {
                    header('Location: myaccount.php');
                    exit();
                }
            }
        }
}

if (empty($errors) === false) {
    echo doPopupError($errors);
}
?>

<div id="divLoginContent">

    <div id="divLoginContainer">

        <label class="labelTitleContainer">LOGIN</label>
        <hr size="1" align="center" noshade></br></br>
        <form action="" method="post">
            <input class="mediumInputTxt" name="username" type="text" placeholder="login"></br></br>
            <input class="mediumInputTxt" name="password" type="password"" placeholder="senha"></br></br>
            <button type="submit" class="enterButton">Entrar</button>
            <a href="register.php">
                <button type="button" class="otherButton">Registrar</button>
            </a>
        </form>
    </div>


</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
