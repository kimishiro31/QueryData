<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
?>



<div id="divBannerContent">

    <div id="divBannerContainer">
        <img src="layout\marketing\indexMarketing.png"/>
    </div>

</div>


</br></br><hr size="1" align="center" noshade></br></br>

<div id="divWSNontent">
    <h1>Entregando um serviço de qualidade</h1></br>
    <div id="divWSNContainer">
       <div class="classInfoContainer">
            <div class="classInfoIMG">
                <img src="layout\marketing\wsn2.png">
            </div>
            <div class="classInfoText"></br>
                <label class="labelTitleInfoContainer">Agilidade e Qualidade</label>
                </br><hr size="1" align="center" noshade/></br>
                <p>Nossos profissionais buscam concluir o serviço no menor tempo possível, e acima de tudo, mantendo a qualidade das informações disponibilizadas.</p>
            </div>
       </div>
       
       <div class="classInfoContainer">
            <div class="classInfoIMG">
                <img src="layout\marketing\wsn1.png">
            </div>
            <div class="classInfoText"></br>
                <label class="labelTitleInfoContainer">Segurança</label>
                </br><hr size="1" align="center" noshade/></br>
                <p>Sabemos que dados pessoais são confidenciais, todos os dados fornecidos em seu cadastro estão protegidos em nosso banco de dados, e resultado da consulta não ficam armazenados em nosso servidor.</p>
            </div>
       </div>
       
       <div class="classInfoContainer">
            <div class="classInfoIMG">
                <img src="layout\marketing\wsn3.png">
            </div>
            <div class="classInfoText"></br>
                <label class="labelTitleInfoContainer">Garantia</label>
                </br><hr size="1" align="center" noshade/></br>
                <p>Buscamos deixar nossos clientes satisfeito, então em caso de não obtivermos resultados, devolvemos o valor pago.</p>
            </div>
       </div>
       
       <div class="classInfoContainer">
            <div class="classInfoIMG">
                <img src="layout\marketing\wsn4.png">
            </div>
            <div class="classInfoText"></br>
                <label class="labelTitleInfoContainer">Objetivo</label>
                </br><hr size="1" align="center" noshade/></br>
                <p>Facilitar a sua vida a encontrar informações de maneira simples.</p>
            </div>
       </div>
       
    </div>
</div>
</br></br><hr size="1" align="center" noshade></br></br>

<div id="divMVVContent">
    <h1>Missão, visão e valores</h1>
    <div id="divMVVContainer">
        <div class="classMissionFrame">
            <div class="classFlipperContainer">
                <div class="classMissionImg">
                    <img src="layout\marketing\missao.png"></img>
                </div>
                <div class="classMissionText"></br></br>
                    <label class="labelTitleContainer">Missão</label>
                    </br><hr size="1" align="center" noshade/></br></br></br>
                    <p><?php echo $mvv['mission']; ?></p>
                </div>
            </div>
        </div>

        <div class="classVisionFrame">
            <div class="classFlipperContainer">
                <div class="classVisionImg">
                    <img src="layout\marketing\visao.png"></img>
                </div>
                <div class="classVisionText"></br></br>
                    <label class="labelTitleContainer">Visão</label>
                    </br><hr size="1" align="center" noshade/></br></br></br>
                    <p><?php echo $mvv['vision']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="classMissionFrame">
            <div class="classFlipperContainer">
                <div class="classValueImg">
                    <img src="layout\marketing\valores.png"></img>
                </div>
                <div class="classValueText"></br></br>
                    <label class="labelTitleContainer">Valores</label>
                    </br><hr size="1" align="center" noshade/></br></br></br>
                    <p><?php echo $mvv['value']; ?></p>
                </div>
            </div>
        </div>

    </div>

</div>


<?php
require_once 'layout/overall/footer/footer.php'; 
?>
