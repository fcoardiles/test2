<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set('Europe/Budapest');
$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA";
$_POST = json_decode(file_get_contents("php://input"), true);
$image = $_POST["image"];
$number = $_POST["number"];

//type of file

$ch3 = curl_init('http://192.168.4.79:20000/api/vault/core/File/' . $number);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
));
$data3 = curl_exec($ch3);
curl_close($ch3);
$decoded3 = json_decode($data3, true);

//echo substr($decoded3["file"]["name"],-3);

if(substr($decoded3["file"]["name"],-3) === 'ipt'){
    for ($i = 0; $i < count($image); $i++) {

        $ch = curl_init('http://192.168.4.79:20000/api/vault/core/File/' . $image[$i]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        $data = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($data, true);
    
        $ch2 = curl_init('http://192.168.4.79:20000/api/vault/core/File/Download/ByMasterId/' . $decoded['file']['masterId']);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        $data2 = curl_exec($ch2);
        curl_close($ch2);
        $decoded2 = json_decode($data2, true);
        if (substr($decoded2['fileDownload']['file']['name'], -3) === 'idw') {
            $order = 0;
        } else {
            $order = 1;
        }
        $final[] = array('order' => $order, 'name' => $decoded2['fileDownload']['file']['name'], 'url' => $decoded2['fileDownload']['base64Content']);
    }
    sort($final);

}else{
    for ($i = 0; $i < count($image); $i++) {

        $ch = curl_init('http://192.168.4.79:20000/api/vault/core/File/' . $image[$i]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        $data = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($data, true);
    
        $ch2 = curl_init('http://192.168.4.79:20000/api/vault/core/File/Download/ByMasterId/' . $decoded['file']['masterId']);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        $data2 = curl_exec($ch2);
        curl_close($ch2);
        $decoded2 = json_decode($data2, true);
        if (substr($decoded2['fileDownload']['file']['name'], -3) === 'idw') {
            $order = 1;
        } else {
            $order = 0;
        }
        $final[] = array('order' => $order, 'name' => $decoded2['fileDownload']['file']['name'], 'url' => $decoded2['fileDownload']['base64Content']);
    }
    sort($final);
}
echo json_encode($final);
