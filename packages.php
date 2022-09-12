<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
?>

<script>
    function popupToggle(element, style){
        if(document.getElementById(element).style.display != style)
            document.getElementById(element).style.display =  style;
        else
		    document.getElementById(element).style.display =  "none";
	}
</script>


<div id="divPackagesContent">
    <center>
        <label class="labelTitleContainer_2">Medalhas de Consulta</label>
    </center>
    <hr size="1" align="center" noshade></br></br></br>
    <p>Disponibilizamos três tipos de planos para você, porem, você também pode estar fazendo o pagamento de apenas uma consulta. As informações que são disponibilizada no resultado da pesquisa, são baseado em dados do Cartório, decisões judiciais publicadas, diários oficiais, foros, redes sociais e consultas em sites públicos na internet.</p>
    </br></br></br>
    <div id="divPackagesContainer">
        <div id="divMedalSilverContainer">
            <img src="layout\marketing\p2.png" onclick="popupToggle('divMedalSilverBodyDescription', 'flex')"/>
            
            <div id="divMedalSilverBodyDescription">
                <div id="divMedalMainDescription">
                    <button type="button" onclick="popupToggle('divMedalSilverBodyDescription', 'flex')" id="divMedalButtonCloseDescription">X</button>
                    <div id="divMedalBorderDescription">
                        <div id="divMedalContentDescription">
                            <div class="classMedalFrame">
                                    <img style="cursor: default;" src="layout\marketing\p2.png"/>
                            </div>
                                <hr size="1" align="center" noshade></br></br></br>
                            <p>Você adquirindo a medalha de Prata, poderá fazer até <?php echo getPackageValue(2) ?> Consultas Mensais</p>
                            <div id="divMedalServicesContainer">
                                <?php
                                foreach (config('configQueries') as $key => $value) {
                                ?>
                                    <div class="classMedalServiceFrame">
                                        <img style="cursor: default;" src="layout\images\queries\<?php echo $key ?>.jpg"/>
                                        <div class="classMedalServiceName tooltip" title="<?php echo getConfigQueryDescription($key) ?>"><?php echo getTypeQuery($key) ?></div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>









        <div id="divMedalGoldContainer">
            <img onclick="popupToggle('divMedalGoldBodyDescription', 'flex')" src="layout\marketing\p1.png"/>
            <div id="divMedalGoldBodyDescription">
                <div id="divMedalMainDescription">
                    <button type="button" onclick="popupToggle('divMedalGoldBodyDescription', 'flex')" id="divMedalButtonCloseDescription">X</button>
                    <div id="divMedalBorderDescription">
                        <div id="divMedalContentDescription">
                            <div class="classMedalFrame">
                                    <img style="cursor: default;" src="layout\marketing\p1.png"/>
                            </div>
                                <hr size="1" align="center" noshade></br></br></br>
                                <p>Você adquirindo a medalha de Ouro, poderá fazer até <?php echo getPackageValue(3) ?> Consultas Mensais</p>
                                <div id="divMedalServicesContainer">
                                <?php
                                foreach (config('configQueries') as $key => $value) {
                                ?>
                                    <div class="classMedalServiceFrame">
                                        <img style="cursor: default;" src="layout\images\queries\<?php echo $key ?>.jpg"/>
                                        <div class="classMedalServiceName tooltip" title="<?php echo getConfigQueryDescription($key) ?>"><?php echo getTypeQuery($key) ?></div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="divMedalBronzeContainer">
            <img onclick="popupToggle('divMedalBronzeBodyDescription', 'flex')" src="layout\marketing\p3.png"/>

            <div id="divMedalBronzeBodyDescription">
                <div id="divMedalMainDescription">
                    <button type="button" onclick="popupToggle('divMedalBronzeBodyDescription', 'flex')" id="divMedalButtonCloseDescription">X</button>
                    <div id="divMedalBorderDescription">
                        <div id="divMedalContentDescription">
                            <div class="classMedalFrame">
                                    <img style="cursor: default;" src="layout\marketing\p3.png"/>
                            </div>
                                <hr size="1" align="center" noshade></br></br></br>
                                <p>Você adquirindo a medalha de Bronze, poderá fazer até <?php echo getPackageValue(1) ?> Consultas Mensais</p>
                                <div id="divMedalServicesContainer">
                                <?php
                                foreach (config('configQueries') as $key => $value) {
                                ?>
                                    <div class="classMedalServiceFrame">
                                        <img style="cursor: default;" src="layout\images\queries\<?php echo $key ?>.jpg"/>
                                        <div class="classMedalServiceName tooltip" title="<?php echo getConfigQueryDescription($key) ?>"><?php echo getTypeQuery($key) ?></div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
