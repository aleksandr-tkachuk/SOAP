<?php
include('libs/soap.php');
include('libs/soapCurl.php');
include('libs/soapCurlXML.php');
include('libs/soapXML.php');

$soap = new Soap;
$player = implode('<br>', $soap->players());

$stadium = implode('<br>', $soap->stadium());

$SoapXML = new SoapXML;

$resultCurrency = $SoapXML->getCurrency();
if (($_POST['currency'])) {
    $data = $SoapXML->getCurs($_POST['currency']);
}


/*$soap = new SoapCurl;
print_r($soap->xmlString());*/

$SoapCurlXML = new SoapCurlXML;
if (isset($_POST['Ymd'])) {
    $dataCurl = $SoapCurlXML->xmlPost($_POST['Ymd']);
    $resCurl = $SoapCurlXML->getCurrencyPost($dataCurl);
} else {
    $dataCurl = $SoapCurlXML->xmlPost(date('Y-m-d'));
    $resCurl = $SoapCurlXML->getCurrencyPost($dataCurl);
}

if (!empty($_POST['currency2'])) {
    $curs = $SoapCurlXML->getCurrencyByCode($resCurl, $_POST['currency2']);
}

include("templates/index.php");
