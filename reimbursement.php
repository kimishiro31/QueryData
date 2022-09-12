<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
?>

<div id="divReimbursementContent">

    <center>
        <label class="labelTitleContainer_2">Política de Reembolso</label>
    </center>
    <hr size="1" align="center" noshade></br></br></br>
    <p>
        <h2>Quando é aplicado o reembolso automático?</h2>
        Quando o usuário faz uma consulta, e a mesma não gera resultados.</br></br>

        <h2>Comprei uma medalha e quero reembolso</h2>
        Somente será efetuado o reembolso, nos casos em que não foram utilizado nenhum vouncher que é disponibilizado pela medalha.</br></br>
        
        <h2>Comprei uma consulta, porem não quero usar</h2>
        Caso a consulta não fazer parte do pacote de medalhas, se o usuário quiser, poderá sim solicitar o reembolso, se ainda não tiver sido utilizado.</br></br>
    
        <h2>Fiz a aquisição de uma medalha, porem a consulta não retornou resultados e agora?</h2>
        Em caso do vouncher utilizado for de origem da medalha, o mesmo é retornado para a conta.</br></br>
    </p>
    <div id="divReimbursementContainer">
    </div>


</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
