<?php


function doSendSMS($tel, $msg) {
    $conf = config('telConfig');
    $smsFacade = new SmsFacade($conf['alias'], $conf['code'], "https://api-rest.zenvia.com");

    $sms = new Sms();
    $sms->setTo($tel);
    $sms->setMsg($msg);
    $sms->setId(uniqid());
    $sms->setCallbackOption(Sms::CALLBACK_NONE);
                      
                      
    try{
        //Envia a mensagem para o webservice e retorna um objeto do tipo SmsResponse com o status da mensagem enviada
        $response = $smsFacade->send($sms);
    /*                  
        echo "Status: ".$response->getStatusCode() . " - " . $response->getStatusDescription();
        echo "<br />Detalhe: ".$response->getDetailCode() . " - " . $response->getDetailDescription();
                      
        if($response->getStatusCode()!="00"){
            echo "<br />Mensagem não pôde ser enviada.";
        }
    */                
    }
    catch(Exception $ex){
     //   echo "Falha ao fazer o envio da mensagem. Exceção: ".$ex->getMessage()."<br />".$ex->getTraceAsString();
    }
                      
}


?>