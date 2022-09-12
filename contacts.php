<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
?>

<div id="divRulesContent">

    <center>
        <label class="labelTitleContainer_2">Contatos</label>
    </center>
    <hr size="1" align="center" noshade></br></br></br>
    <p><b>Email:</b> <?php echo $contact['email']; ?></p>
    <p><b>Whatszapp:</b> <?php echo $contact['whatsapp']; ?></p>
    <div id="divRulesContainer">
    </div>


</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
