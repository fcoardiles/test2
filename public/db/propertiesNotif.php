<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set('Europe/Budapest');
$_POST = json_decode(file_get_contents("php://input"), true);
$notificationNumber = $_POST["notificationNumber"];
$priorityText = $_POST["priority"];
$endDate = $_POST["endDate"];
$plannedWorkTimeMin = $_POST["workTimeH"]*60;
//$workTimeH = $_POST["workTimeH"];
//$workTimeM = $_POST["workTimeM"];
/*
if ((int)$workTimeH > 0) {
  $workTimeHinM = $workTimeH * 60;
} else {
  $workTimeHinM = 0;
}*/
//$plannedWorkTimeMin = $workTimeHinM + $workTimeM;
if ($priorityText === "Nagyon Magas") {
  $priority = 1;
} else if ($priorityText === "Magas") {
  $priority = 2;
} else if ($priorityText === "Normál") {
  $priority = 3;
} else if ($priorityText === "Alacsony") {
  $priority = 4;
}


$put = [
  'notificationNumber' => $notificationNumber,
  'priority' => $priority,
  'endDate' => $endDate,
  'plannedWorkTimeMin' => $plannedWorkTimeMin
];
$putf = json_encode($put);

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA";

$ch = curl_init('http://192.168.4.79:20000/api/sap/Notification/' . $notificationNumber . '/Properties');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $token
));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $putf);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$data = curl_exec($ch);
curl_close($ch);

echo json_encode($data);
