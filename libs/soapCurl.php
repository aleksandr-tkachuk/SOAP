<?php

class SoapCurl
{
    public $soapUrl;

    public function __construct()
    {
        $this->soapUrl = "http://footballpool.dataaccess.eu/data/info.wso?op=AllCards"; // asmx URL of WSDL
    }


    public function xmlString()
    {
        // xml post structure
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
    <AllCards xmlns="http://footballpool.dataaccess.eu">
    </AllCards>
    </soap:Body>
    </soap:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice",
            "Content-length: " . strlen($xml_post_string),
        );

        // PHP cURL  for https connection with auth
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting

        $response = curl_exec($ch);
        //   print_r($response);
        curl_close($ch);


        // converting
        $response1 = str_replace("<soap:Body>", "", $response);
        $response2 = str_replace("</soap:Body>", "", $response1);
        $response3 = str_replace("m:", "", $response2);

        // convertingc to XML
        $parser = simplexml_load_string($response3);
        /*        $jsonEncode = json_encode($parser);
                $jsonDecode = json_decode($jsonEncode, true);*/

        $obj = $parser->AllCardsResponse->AllCardsResult->tCardInfo;

        foreach ($obj as $currency) {
            $currencyArr['Game'] = trim($currency->dGame);
            $currencyArr['GameTeam1'] = trim($currency->sGameTeam1);
            $currencyArr['GameTeam2'] = trim($currency->sGameTeam2);
            $currencyArr['PlayerName'] = trim($currency->sPlayerName);
            $result[] = $currencyArr;
        }

        return $result;
    }


}

?>
