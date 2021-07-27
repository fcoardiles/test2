<?php
header('Access-Control-Allow-Origin: *');

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA";

//Generate List 
//$ch = curl_init('http://192.168.4.79:20000/api/sap/GetNotifications/1/DEV/true');  //URL by parts
//$ch = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=1&SapClient=DEV&IsActive=true');  //URL by parts
$ch = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=1&SapClient=prd&IsActive=true&workplace=SZERSZAM&IsActive=true');  //URL by parts

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $token
));
$data = curl_exec($ch);
curl_close($ch);
$decoded = json_decode($data, true);

$type = [];
$deployFactory = [];
$deployPlace = [];
$plannerGroupTitle = [];
$priority = [];
$propPriority = [];
for ($i = 0; $i < count($decoded['notifications']); $i++) {
  array_push($type, $decoded['notifications'][$i]['notificationType']);
  if (strlen($decoded['notifications'][$i]['deployFactory']) > 0) {
    $deployFactory0 = $decoded['notifications'][$i]['deployFactory'];
  } else if ($decoded['notifications'][$i]['deployFactory'] !== null) {
    $deployFactory0 = '-';
  }
  array_push($deployFactory, $deployFactory0);

  if (strlen($decoded['notifications'][$i]['deployPlace']) > 0) {
    $deployPlace0 = $decoded['notifications'][$i]['deployPlace'];
  } else if ($decoded['notifications'][$i]['deployPlace'] !== null) {
    $deployPlace0 = '-';
  }
  array_push($deployPlace, $deployPlace0);

  if ($decoded['notifications'][$i]['priority'] !== null) {
    array_push($priority, $decoded['notifications'][$i]['priority']);
  }

  if (isset($decoded['notifications'][$i]['orders'][0]['plannerGroup'])) {
    $plannerGroup = $decoded['notifications'][$i]['orders'][0]['plannerGroup'];
  } else {
    $plannerGroup = "";
  }

  if (isset($decoded['notifications'][$i]['orders'][0]['plannerGroupName'])) {
    $plannerGroupName = $decoded['notifications'][$i]['orders'][0]['plannerGroupName'];
  } else {
    $plannerGroupName = "";
  }
  array_push($plannerGroupTitle, $plannerGroup . '-' . $plannerGroupName);
  if (isset($decoded['notifications'][$i]['orders'][0]['priority'])) {
    array_push($propPriority, $decoded['notifications'][$i]['orders'][0]['priority']);
  }
}

//$ch2 = curl_init('http://192.168.4.79:20000/api/sap/GetNotifications/2/DEV/true');  //URL by repair
//$ch2 = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=2&SapClient=DEV&IsActive=true');  //URL by repair
$ch2 = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=2&SapClient=prd&IsActive=true&workplace=SZERSZAM&IsActive=true');  //URL by repair

curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $token
));
$data = curl_exec($ch2);
curl_close($ch2);
$decoded2 = json_decode($data, true);

for ($i = 0; $i < count($decoded2['notifications']); $i++) {
  array_push($type, $decoded2['notifications'][$i]['notificationType']);

  if (strlen($decoded2['notifications'][$i]['deployFactory']) > 0) {
    $deployFactory0 = $decoded2['notifications'][$i]['deployFactory'];
  } else if ($decoded2['notifications'][$i]['deployFactory'] !== null) {
    $deployFactory0 = '-';
  }
  array_push($deployFactory, $deployFactory0);

  if (strlen($decoded2['notifications'][$i]['deployPlace']) > 0) {
    $deployPlace0 = $decoded2['notifications'][$i]['deployPlace'];
  } else if ($decoded2['notifications'][$i]['deployPlace'] !== null) {
    $deployPlace0 = '-';
  }
  array_push($deployPlace, $deployPlace0);

  if (isset($decoded2['notifications'][$i]['priority'])) {
    $priority0 = $decoded2['notifications'][$i]['priority'];
  } else {
    $priority0 = '-';
  }
  array_push($priority, $priority0);

  if (isset($decoded2['notifications'][$i]['orders'][0]['plannerGroup'])) {
    $plannerGroup = $decoded2['notifications'][$i]['orders'][0]['plannerGroup'];
  } else {
    $plannerGroup = "";
  }

  if (isset($decoded2['notifications'][$i]['orders'][0]['plannerGroupName'])) {
    $plannerGroupName = $decoded2['notifications'][$i]['orders'][0]['plannerGroupName'];
  } else {
    $plannerGroupName = "";
  }
  array_push($plannerGroupTitle, $plannerGroup . '-' . $plannerGroupName);

  if (isset($decoded2['notifications'][$i]['orders'][0]['priority'])) {
    $propPriority0 = $decoded2['notifications'][$i]['orders'][0]['priority'];
  } else {
    $propPriority0 = '-';
  }
  array_push($propPriority, $propPriority0);
}
//List

$type = array_values(array_unique($type));

$deployFactory = array_values(array_unique($deployFactory));
$deployPlace = array_values(array_unique($deployPlace));
$plannerGroupTitle = array_values(array_unique($plannerGroupTitle));
$priority = array_values(array_unique($priority));
$propPriority = array_values(array_unique($propPriority));

//Machine
$ch1 = curl_init('http://192.168.4.79:20000/api/management/Terminal');
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $token
));
$data1 = curl_exec($ch1);
curl_close($ch1);

$decoded1 = json_decode($data1, true);

if ($decoded1 !== null and $decoded1 !== "" and $decoded1 !== []) {

  $n_machine = count($decoded1["terminals"]);
  $machine = ['nem kijelölt'];
  for ($i = 0; $i <= $n_machine - 1; $i++) {

    if ($decoded1["terminals"][$i]["id"] === 109) { //Change ID with MAIN
      $ch3 = curl_init('http://192.168.4.79:20000/api/management/Terminal/' . $decoded1["terminals"][$i]["id"] . '/Children');
      curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
      ));
      $data3 = curl_exec($ch3);
      curl_close($ch3);
      $decoded3 = json_decode($data3, true);

      for ($j = 0; $j < count($decoded3["terminals"]); $j++) {

        //Exist JOB


        $ch4 = curl_init('http://192.168.4.79:20000/api/management/Job/ByTerminal/' . $decoded3["terminals"][$j]["id"]);
        curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch4, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Authorization: Bearer ' . $token
        ));
        $data4 = curl_exec($ch4);
        curl_close($ch4);
        $decoded4 = json_decode($data4, true);

        if (count($decoded4["terminalJobs"]) > 0) {
          array_push($machine, $decoded3["terminals"][$j]["name"]);
        }
      }
    }
  }
}
$machine = array_values(array_unique($machine));

$list = array(
  'type' => $type,
  'machine' => $machine,
  'deployFactory' => $deployFactory,
  'deployPlace' => $deployPlace,
  'plannerGroupTitle' => $plannerGroupTitle,
  'priority' => $priority,
  'propPriority' => $propPriority
);
echo json_encode($list);
exit;
