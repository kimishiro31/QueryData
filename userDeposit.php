<?php
require_once 'engine/init.php'; 
require_once 'layout/overall/header/header.php'; 
doProtect();
doAccountActiveRedirect($accountData['id'], true);

if(isset($_GET["status"]) && $_GET['status'] == 'approved' && isset($_GET["collection_id"]) && (isCreditSoldPurchaseUIDExist($_GET["collection_id"]) === false)) {
    $collection_ID = $_GET['collection_id'];
    $accessToken = config('marketConfig')['accessToken']; 
    
        $curl = curl_init();
      
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/'.$collection_ID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ARRAY(
                'Authorization: Bearer '.$accessToken
            ),
            ));
            
        $payment_info = json_decode(curl_exec($curl), true);
        curl_close($curl);

    if($payment_info['status_detail'] === 'accredited' && (isCreditSoldPurchaseUIDExist($collection_ID) === false)) {

        $dateCreated = explode('T', $payment_info['date_created']);
        $hourCreated = explode('.', $dateCreated[1]);
        $dateUpdate = explode('T', $payment_info['date_last_updated']);
        $hourUpdate = explode('.', $dateUpdate[1]);

        $register_data = array(
            'credit_id' => $payment_info['additional_info']['items'][0]['id'],
            'user_id' => $userData['id'],
            'purchase_uid' => $payment_info['id'],
            'method_payment' => $payment_info['payment_type_id'],
            'created_dateTime' => $dateCreated[0].' '.$hourCreated[0],
            'status' => 'APROVADO',
            'status_dateTime' => $dateUpdate[0].' '.$hourUpdate[0],
            'ip_address' => $payment_info['additional_info']['ip_address']
        );

        echo doPopupSuccess(" Parabêns, você comprou o pacote <b>200 QDCoins</b>, e as moedas já foi encaminhada para a sua conta.");
        doAddCreditSold($register_data);
        doAddUserCredit($userData['id'], getCreditQuantity(getCreditSoldCreditID($payment_info['additional_info']['items'][0]['id'])));
    }
}


if(isset($_GET["status"]) && $_GET['status'] == 'in_process' && isset($_GET["collection_id"]) && (isCreditSoldPurchaseUIDExist($_GET["collection_id"]) === false)) {
    $collection_ID = $_GET['collection_id'];
    $accessToken = config('marketConfig')['accessToken']; 
    
        $curl = curl_init();
      
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/'.$collection_ID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ARRAY(
                'Authorization: Bearer '.$accessToken
            ),
            ));
            
        $payment_info = json_decode(curl_exec($curl), true);
        curl_close($curl);

    if($payment_info['status_detail'] === 'pending_contingency' && (isCreditSoldPurchaseUIDExist($collection_ID) === false)) {

        $dateCreated = explode('T', $payment_info['date_created']);
        $hourCreated = explode('.', $dateCreated[1]);
        $dateUpdate = explode('T', $payment_info['date_last_updated']);
        $hourUpdate = explode('.', $dateUpdate[1]);
        
        $register_data = array(
            'credit_id' => $payment_info['additional_info']['items'][0]['id'],
            'user_id' => $userData['id'],
            'purchase_uid' => $payment_info['id'],
            'method_payment' => $payment_info['payment_type_id'],
            'created_dateTime' => $dateCreated[0].' '.$hourCreated[0],
            'status' => 'EM ANALISE',
            'status_dateTime' => $dateUpdate[0].' '.$hourUpdate[0],
            'ip_address' => $payment_info['additional_info']['ip_address']
        );

        echo doPopupWarning("A sua compra está em analise, o MercadoPago vai te avisar assim que o status da compra for alterado.");
        doAddCreditSold($register_data);
    }
}

?>

<div id="divMaContent">

    <center>
        <label id="divMaStart" class="labelTitleContainer_2">Painel de Usúario</label>
    </center>
    <hr size="1" align="center" noshade></br></br></br>

    <?php include 'layout/overall/menu/bodyMenuUser.php'; ?>


    <!-- PAGINA 1 -->
        <div id="divDPContainer">
            <center>
                <label id="divMaQuery" class="labelTitleContainer_2">Depositar</label>
            </center>
            <hr size="1" align="center" noshade></br>

            <div id="divDPValuesContainer">
                <?php
                $list = doListCredits();
                if($list !== false) {
                    foreach($list as $key) {
                ?>
                        <div class="classValuePay">
                            <div class="classValuePayImg">
                                <img src="\layout\images\qdcoins\<?php echo getCreditQuantity($key['id']); ?>.png"></img>
                            </div>
                            <a href="<?php echo doAddItemMarket($key['id'],getCreditName($key['id']), getCreditDescription($key['id']), getCreditQuantity($key['id']), getCreditCost($key['id'])); ?>">
                                <button type="button" class="otherButton">Comprar</button>
                            </a>
                        </div>
                <?php
                    }
                }
                    
                ?>
            </div>
            </br></br>
        </div>
</div>



<?php
require_once 'layout/overall/footer/footer.php'; 
?>
