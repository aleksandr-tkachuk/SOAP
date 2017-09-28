<?php

class SoapXML
{
    public $data = '2017-09-27';
    public $client;
    public $obj;

    public function __construct()
    {
        $this->client = new SoapClient("http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL");
        $currencies = $this->client->GetCursOnDate(['On_date' => $this->data]);

        $currencies1 = new SimpleXMLElement($currencies->GetCursOnDateResult->any);

        $this->obj = $currencies1->ValuteData->ValuteCursOnDate;
    }

    public function getCurrency()
    {

        return $this->obj;
    }

    public function getCurs($code)
    {

        foreach ($this->obj as $currency) {
            $currencyArr['chCode'] = trim($currency->VchCode);
            if ($currencyArr['chCode'] == $code) {
                $result[] = trim($currency->Vname);
                $result[] = trim($currency->Vnom);
                $result[] = trim($currency->Vcurs);
                $result[] = trim($currency->Vcode);
                $result[] = trim($currency->VchCode);
            }
        }
        return $result;
    }
}
