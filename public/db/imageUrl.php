<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set('Europe/Budapest');
$_POST = json_decode(file_get_contents("php://input"), true);
$image = $_POST["image"];
//first Url image
$ch = curl_init('http://192.168.4.79:20000/api/vault/core/Property?EntityIds=' . $image[0] . '&PropertyDefinitionIds=22');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
));
$data = curl_exec($ch);
curl_close($ch);

$decoded = json_decode($data, true);
if (isset($decoded)) {
    $imageValue1 = $decoded['properties'][0]['val'];
    $imageNum1= $image[0];
} else {
    $imageValue1 = null;
    $imageNum1= null;
}
//Second Url image
$ch1 = curl_init('http://192.168.4.79:20000/api/vault/core/Property?EntityIds=' . $image[1] . '&PropertyDefinitionIds=22');
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
));
$data1 = curl_exec($ch1);
curl_close($ch1);

$decoded1 = json_decode($data1, true);
if (isset($decoded1)) {
    $imageValue2 = $decoded1['properties'][0]['val'];
    $imageNum2= $image[1];
} else {
    $imageValue2 = null;
    $imageNum2= null;
}

$imageUrl = array(
    array('url' => $imageValue1,'value' => $imageNum1),
    array('url' => $imageValue2,'value' => $imageNum2)
);

echo json_encode($imageUrl);
