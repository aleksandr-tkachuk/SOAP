<?php

class SoapCurlXML
{
    public $obj;
    // public $dataFromTheForm;//$_POST['fieldName'];  request data from the form
    public $soapUrl;

    function __construct()
    {
        $this->soapUrl = "http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL"; // asmx URL of WSDL
        //$this->dataFromTheForm = date("Y-m-d");
    }

    public function xmlPost($data)
    {
// xml post structure
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
      <soap:Body>
        <GetCursOnDateXML xmlns="http://web.cbr.ru/">
          <On_date>' . $data . '</On_date>
        </GetCursOnDateXML>
      </soap:Body>
    </soap:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
        ); //SOAPAction: your op URL

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
        //print_r($response);
        curl_close($ch);


// converting
        $response = str_replace("<soap:Body>", "", $response);
        $response = str_replace("</soap:Body>", "", $response);
        $response = str_replace("m:", "", $response);

// convertingc to XML
        $parser = simplexml_load_string($response);
// user $parser to get your data out of XML response and to display it.
        $this->obj = $parser->GetCursOnDateXMLResponse->GetCursOnDateXMLResult->ValuteData->ValuteCursOnDate;

        return $this->obj;
    }

    public function getCurrencyPost($obj)
    {
        foreach ($obj as $currency) {
            $currencyArr['name'] = trim($currency->Vname);
            $currencyArr['nom'] = trim($currency->Vnom);
            $currencyArr['curs'] = trim($currency->Vcurs);
            $currencyArr['code'] = trim($currency->Vcode);
            $currencyArr['chCode'] = trim($currency->VchCode);
            $result[] = $currencyArr;
        }
        return $result;
    }


    public function getCurrencyByCode($obj, $code)
    {
        $value = [];
        foreach ($obj as $item) {
            if ($item['chCode'] == $code) {
                $value[] = $item['name'];
                $value[] = $item['curs'];
            }
        }
        return $value;
    }
}


