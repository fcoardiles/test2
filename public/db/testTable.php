<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set('Europe/Budapest');
$_POST = json_decode(file_get_contents("php://input"), true);
$equipmentNumber = $_POST["equipmentNumber"];
$link = mysqli_connect('192.168.4.79', 'pancho', 'pw123', 'safe');

$query = 'SELECT * FROM saporders WHERE EquipmentNumber="' . $equipmentNumber['value'] . '"';
$result = $link->query($query);
while ($row = mysqli_fetch_assoc($result)) {
    $list[] = $row['OrderId'];
}


/*$file_opened = fopen('./error.log', 'a');

if($file_opened){
    fwrite($file_opened, pack("CCC",0xef,0xbb,0xbf)); // UTF8
    fwrite($file_opened, "SQL: " . $query . PHP_EOL);
    fclose($file_opened);
}*/

//echo count($list);

if (count($list) > 0) {
    for ($i = 0; $i < count($list); $i++) {
        $curl = curl_init();
        $credentials = base64_encode('tjpms:jpms00');
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8010",
            CURLOPT_URL => "http://192.168.4.118:8010/sap/bc/srt/rfc/sap/z_jpms_get_pm_order_conf_list/100/z_jpms_get_pm_order_conf_list/prd100",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => '
                                            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:sap-com:document:sap:rfc:functions">
                                                <soapenv:Header/>
                                                <soapenv:Body>
                                                <urn:Z_JPMS_GET_PM_ORDER_CONF_LIST>
                                                <IT_ORDERS>
                                                <item>
                                                    <AUFNR>' . $list[$i] . '</AUFNR>
                                                    </item>
                                                    </IT_ORDERS>
                                                 </urn:Z_JPMS_GET_PM_ORDER_CONF_LIST>
                                                </soapenv:Body>
                                            </soapenv:Envelope>',
            CURLOPT_HTTPHEADER => array(
                'Authorization' => 'Basic ' . $credentials,
                "Content-Type: text/xml;"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = convert_soap_xml_to_array($response);
        $dataF[$i] = $response["n0Z_JPMS_GET_PM_ORDER_CONF_LISTResponse"]["ET_CONFIRMATIONS"];
    }
    
    

    foreach($dataF as $d){

        if(isset($d["item"]["CONF_NO"])){
            $time = intval($d["item"]["ACT_WORK"]);

            if($d["item"]["UN_WORK"] == "MIN")
                $time = $time / 60;
    
            $formattedArray[] = array(
                "name" => $d["item"]["NAME"],
                "text" => $d["item"]["CONF_TEXT"],
                "time" => $time,
                "date" => $d["item"]["CREATED_DATE"]
            );
        }
        else {
            foreach($d["item"] as $item){
                $time = intval($item["ACT_WORK"]);

                if($item["UN_WORK"] == "MIN")
                    $time = $time / 60;
    
                $formattedArray[] = array(
                    "name" => $item["NAME"],
                    "text" => $item["CONF_TEXT"],
                    "time" => $time,
                    "date" => $item["CREATED_DATE"]
                );
            }
        }
        
    }

    echo json_encode($formattedArray);
}




// ===== HELPERS ===== //
function convert_soap_xml_to_array($response){
    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
    $xml = new SimpleXMLElement($response);
    $body = $xml->xpath('//soap-env:Body')[0];
    $array = json_decode(json_encode((array)$body), TRUE); 
    return $array;
}
