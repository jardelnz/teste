<?php 
require('env.php');

$caracteresChamadaPadrao = array("ersDataResult>","[","]", "risesResult>");
$caracteresChamadaPadrao2 = array("prisesResult>","Body>","Envelope>");
$caracteresChamadaImpressora = array('"PrinterDeviceID":','"PrinterName":"', 
'"SerialNumber":"', '"},', '"', "}");
$caracteresChamadaEmpresa = array('"EnterpriseID":','"EnterpriseName":"', '"},', '"', "}");

$caractereTransformarArrayPadrao = '{';
$caractereTransformarArrayPadrao2 = '*';
$caractereTransformarArrayImpressora = ',';

function separaTags($textoXml){
  $arr = array();
  $string = "";
  $string_aux = "";
  $flagTag = 0;
  $flagKey = 0;
  $i = 0;
  for($i = 0; $i < strlen($textoXml); $i++){
    if($textoXml[$i] == "["){
      $flagTag = 1;
    }
    if($flagTag == 1){
      $string .= $textoXml[$i];
    }
    if($textoXml[$i] == "]"){
      $flagTag = 0;
    }
  }
 
  return($string);
}



function retornaContadores(){

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-counters.nddprint.com/CountersWS/CountersData.asmx?Host=api-counters.nddprint.com&Content-Type=text/xml;%20charset=utf-8&Content-Length=length&SOAPAction=nddprint.com/api/GetReferenceCountersData',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"
            xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
                <GetCountersData xmlns="nddprint.com/api/">
                    <dealerName>'.PROVEDOR.'</dealerName>
                    <dealerUserEmail>'.EMAIL.'</dealerUserEmail>
                    <dealerUserPassword>'.PASS.'</dealerUserPassword>
                    <dateTimeStart>2021-11-01 00:00:00</dateTimeStart>
                    <dateTimeEnd>2022-11-03 23:59:59</dateTimeEnd>
                    <maxLimitDaysEarlier>15</maxLimitDaysEarlier>
                    <enterpriseName>272_FMS_MACAE_MPS</enterpriseName>
                    <fieldsList>SerialNumber;CounterTypeName</fieldsList>
                </GetCountersData>
            </soap:Body>
        </soap:Envelope>',
        CURLOPT_HTTPHEADER => array(
        'Host: api-counters.nddprint.com',
        'Content-Type: text/xml; charset=utf-8',
        'soapAction: nddprint.com/api/GetCountersData'
        ),
        ));
    
        $response = curl_exec($curl);
        curl_close($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);
        return $body;
}
function retornaEmpresas(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-general.nddprint.com/GeneralWS/GeneralData.asmx',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
      <soap:Body>
        <GetEnterprises xmlns="nddprint.com/api/">
        <dealerName>'.PROVEDOR.'</dealerName>
        <dealerUserEmail>'.EMAIL.'</dealerUserEmail>
        <dealerUserPassword>'.PASS.'</dealerUserPassword>
          <fieldsList>EnterpriseID;EnterpriseName</fieldsList>
        </GetEnterprises>
      </soap:Body>
    </soap:Envelope>',
            CURLOPT_HTTPHEADER => array(
              'Host: api-general.nddprint.com',
              'Content-Type: text/xml; charset=utf-8',
              'SOAPAction: nddprint.com/api/GetEnterprises'
            ),
    ));
    
    $response = curl_exec($curl);
        curl_close($curl);
    //$xml=(substr($response, strpos($response, "\r\n\r\n")+4));
        //$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
       // $body = substr($response, $header_size);
       $response = str_replace('i8>', 'i4>', $response);
  
        $body = json_decode(separaTags($response));
        return $body;
}
function retornaImpressoras($empresa){
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-general.nddprint.com/GeneralWS/GeneralData.asmx',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
<soap:Body>
  <GetPrinters xmlns="nddprint.com/api/">
    <dealerName>'.PROVEDOR.'</dealerName>
    <dealerUserEmail>'.EMAIL.'</dealerUserEmail>
    <dealerUserPassword>'.PASS.'</dealerUserPassword>
    <enterpriseID>'.$empresa.'</enterpriseID>
    <fieldsList>PrinterDeviceID;PrinterName;SerialNumber</fieldsList>
  </GetPrinters>
</soap:Body>
</soap:Envelope>',
  CURLOPT_HTTPHEADER => array(
      'Host: api-general.nddprint.com',
      'Content-Type: text/xml;charset=UTF-8',
      'SOAPAction: nddprint.com/api/GetPrinters'
  ),
));

$response = curl_exec($curl);
$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
curl_close($curl);
$body = json_decode(separaTags($response));
return $body;

}
function alterarContatoDaImpressora($empresa, $impressora, $contato){
  $curl = curl_init();

curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api-general.nddprint.com/GeneralWS/GeneralData.asmx',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <SetPrinterContact xmlns="nddprint.com/api/">
    <dealerName>'.PROVEDOR.'</dealerName>
    <dealerUserEmail>'.EMAIL.'</dealerUserEmail>
    <dealerUserPassword>'.PASS.'</dealerUserPassword>
      <enterpriseID>'.$empresa.'</enterpriseID>
      <printerDeviceID>'.$impressora.'</printerDeviceID>
      <newContact>'.$contato.'</newContact>
    </SetPrinterContact>
  </soap:Body>
</soap:Envelope>',
		CURLOPT_HTTPHEADER => array(
				'Host: api-general.nddprint.com',
				'Content-Type: text/xml; charset=utf-8',
				'SOAPAction: nddprint.com/api/SetPrinterContact'
		),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}
function desabilitaMonitoracao($empresa,$impressora){
  $curl = curl_init();

curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api-general.nddprint.com/GeneralWS/GeneralData.asmx',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <SetPrinterEnableCounters xmlns="nddprint.com/api/">
    <dealerName>'.PROVEDOR.'</dealerName>
    <dealerUserEmail>'.EMAIL.'</dealerUserEmail>
    <dealerUserPassword>'.PASS.'</dealerUserPassword>
      <enterpriseID>'.$empresa.'</enterpriseID>
      <printerDeviceID>'.$impressora.'</printerDeviceID>
      <enabledCounters>false</enabledCounters>
    </SetPrinterEnableCounters>
  </soap:Body>
</soap:Envelope>',
		CURLOPT_HTTPHEADER => array(
				'Host: api-general.nddprint.com',
				'Content-Type: text/xml;charset=UTF-8'
		),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}
/* Chamadas da API */

function converteStringEmArray($string, $caracter){
    $array = explode($caracter, $string);
    return $array;
}
function removeCaracteresDeString($string, $caracteresIndesejados){
    return str_replace($caracteresIndesejados, "", $string);
}
function valorEhInteiro($variavel){
  if(preg_match('/^[1-9][0-9]*$/',$variavel)){
    return true;
  }
}
function converteStringEmArray2($string, $caracter){
  $array = explode($caracter, $string);
  return $array;
}
function removeCaracteresDeString2($string, $caracteresIndesejados){
  return str_replace($caracteresIndesejados, "", $string);
}