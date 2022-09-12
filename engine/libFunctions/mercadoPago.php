<?php


function doAddItemMarket($id, $title, $description,$quantity, $unit_price) {
    $accessToken = config('marketConfig')['accessToken'];

    MercadoPago\SDK::setAccessToken($accessToken);

    // Cria um objeto de preferência
    $preference = new MercadoPago\Preference();
    
    // Cria um item na preferência
    $item = new MercadoPago\Item();
    $item->id = $id;
    $item->title = $title;
    $item->description = $description;
    $item->category_id = "coins";
    $item->currency_id = "BRL";
    $item->quantity = $quantity;
    $item->unit_price = $unit_price;
    $preference->items = array($item);
  
    $preference->back_urls = array(
      "success" => 'localhost/userDeposit.php?sub=success',
      "failure" => 'localhost/userDeposit.php?sub=failure',
      "pending" => 'localhost/userDeposit.php?sub=pending'
    );
    
    $preference->auto_return = "approved";

    $preference->save();
    
    return ($preference->init_point);
  }

function getPurchaseInfo($collection_ID) {
    $collection_ID = sanitize($collection_ID);
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

    return $payment_info;
}

function getPurchaseStatus($collection_ID) {

    $data = getPurchaseInfo($collection_ID);

    return $data['status_detail'];
}

function getPurchaseID($collection_ID) {
    $data = getPurchaseInfo($collection_ID);

    return $data['id'];
}

function getPurchaseItemID($collection_ID) {
    $data = getPurchaseInfo($collection_ID);

    return $data['additional_info']['items'][0]['id'];
}

function getPurchaseMethodPayment($collection_ID) {
    $data = getPurchaseInfo($collection_ID);

    return $data['payment_type_id'];
}

function getPurchaseCreatedDateTime($collection_ID) {
    $data = getPurchaseInfo($collection_ID);

    return $data['date_created'];
}

function getPurchaseLastUpdate($collection_ID) {
    $data = getPurchaseInfo($collection_ID);

    return $data['date_last_updated'];
}

function getPurchaseStatusApproved($collection_ID) {
    $data = getPurchaseInfo($collection_ID);

    return $data['date_approved'];
}


function getPurchaseCreatedExpirationDateTime($collection_ID) {
    $data = getPurchaseInfo($collection_ID);

    return $data['date_of_expiration'];
}

function getPurchaseIP($collection_ID) {
    $data = getPurchaseInfo($collection_ID);

    return $data['additional_info']['ip_address'];
}
  
  
  ?>