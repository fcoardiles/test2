<?php
header('Access-Control-Allow-Origin: *');

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA";

// childs assigned
$ch = curl_init('http://192.168.4.79:20000/api/management/Terminal');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $token
));
$data = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

$decoded = json_decode($data, true);

$n_machine = count($decoded["terminals"]);

for ($i = 0; $i <= $n_machine - 1; $i++) {

  if ($decoded["terminals"][$i]["terminalType"]["id"] === 1) {
    $ch2 = curl_init('http://192.168.4.79:20000/api/management/Terminal/' . $decoded["terminals"][$i]["id"] . '/Children');
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $token
    ));
    $data2 = curl_exec($ch2);
    curl_close($ch2);
    $decoded2 = json_decode($data2, true);

    for ($j = 0; $j <= count($decoded2["terminals"]) - 1; $j++) {
      //JOB
      $ch3 = curl_init('http://192.168.4.79:20000/api/management/Job/ByTerminal/' . $decoded2["terminals"][$j]["id"]);
      curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
      ));
      $data3 = curl_exec($ch3);
      curl_close($ch3);
      $decoded3 = json_decode($data3, true);
      if (isset($decoded3)) {
        for ($k = 0; $k <= count($decoded3["terminalJobs"]) - 1; $k++) {
          $item0[] = $decoded3["terminalJobs"][$k]["notificationNumber"];
        }
      }
    }
  }
}
if (isset($item0)) {
  $item = $item0;
} else {
  $item = [];
}

//Generate List 
//$ch4 = curl_init('http://192.168.4.79:20000/api/sap/GetNotifications/2/DEV/true');  //URL by repair
//$ch4 = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=2&SapClient=PRD&IsActive=true');  

$ch4 = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=2&SapClient=prd&IsActive=true&workplace=SZERSZAM&IsActive=true');

curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch4, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $token
));
$data4 = curl_exec($ch4);
curl_close($ch4);
$decoded4 = json_decode($data4, true);

for ($i = 0; $i < count($decoded4["notifications"]); $i++) {

  if (
    empty(array_search($decoded4["notifications"][$i]['notificationNumber'], $item)) &&
    array_search($decoded4["notifications"][$i]['notificationNumber'], $item) !== 0
  ) {

    $notifType = $decoded4["notifications"][$i]['notificationType'];
    $equipmentType = $decoded4["notifications"][$i]['equipmentType'];
    if($notifType == 'M2' && $equipmentType != 'A' && $equipmentType != 'P' && $equipmentType != 'S' && $equipmentType != 'T')
      continue;

    $notifType = $decoded4["notifications"][$i]['notificationType'];
    $equipmentType = $decoded4["notifications"][$i]['equipmentType'];

    $number = $decoded4["notifications"][$i]['notificationNumber'];
    //notificationType  

    $type = $decoded4["notifications"][$i]['notificationType'];
    if ($type === 'M2') {
      $name = $decoded4["notifications"][$i]['equipmentText'];
    } else {
      $name = $decoded4["notifications"][$i]['notificationText'];
    }
    //$name = $decoded4["notifications"][$i]['notificationText'];
    $equipment = $decoded4["notifications"][$i]['equipmentNumber'];
    $equipmentText = $decoded4["notifications"][$i]['equipmentText'];

    if ($decoded4["notifications"][$i]['priority'] == 1) {
      $priority = '#FF00FF';
      $orderDesc = 5;
    } else  if ($decoded4["notifications"][$i]['priority'] == 2) {
      $priority = '#FF0000';
      $orderDesc = 4;
    } else  if ($decoded4["notifications"][$i]['priority'] == 3) {
      $priority = '#FFA500';
      $orderDesc = 3;
    } else  if ($decoded4["notifications"][$i]['priority'] == 4) {
      $priority = '#9ACD32';
      $orderDesc = 2;
    } else {
      $priority = '#263238';
      $orderDesc = 1;
    }
    if ($decoded4["notifications"][$i]['priority'] == null) {
      $order = 9;
    } else {
      $order = $decoded4["notifications"][$i]['priority'];
    }

    $deployFactory = $decoded4["notifications"][$i]['deployFactory'];
    $deployPlace = $decoded4["notifications"][$i]['deployPlace'];
    $lastName = $decoded4["notifications"][$i]['lastName'] . ' ' . $decoded4["notifications"][$i]['firstName'];
    $date = substr(str_replace('T', '   ', $decoded4["notifications"][$i]['startDate']), 0, 10);
    $endDate = $decoded4["notifications"][$i]['endDate'];

    //if exist saporder

    if (isset($decoded4["notifications"][$i]['order']['orderId'])) {
      $orderid =  $decoded4["notifications"][$i]['order']['orderId'];
    } else {
      $orderid = $number;
    }
    if (isset($decoded4["notifications"][$i]['order']['orderStatus'])) {
      $orderStatus =  $decoded4["notifications"][$i]['order']['orderStatus'];
    } else {
      $orderStatus = 'null';
    }
    //List detail

    if ($orderStatus !== 2) {
      $response[]   =  array(
        'date' => $date,
        'orderDesc' => $orderDesc,
        'order' => $order,
        'name' => $name,
        'id' => $number,
        'priority' =>  $priority,
        'sapOrder' => $orderid,
        'equipment' => $equipment,
        'equipmentText' => $equipmentText,
        'type' => $type,
        'endDate' => $endDate,
        'deployFactory' => $deployFactory,
        'deployPlace' => $deployPlace,
        'lastName' => $lastName,
        'orderStatus' => $orderStatus
      );
    }
  }
}
rsort($response);



//Function

function searchData($value, $data, $nameValue)
{
  if (isset($value) and $value != null) {

    for ($i = 0; $i < count($data); $i++) {
      for ($j = 0; $j < count($value); $j++) {
        if ($data[$i][$nameValue] === $value[$j]) {
          $valueFinal[] = $data[$i];
        }
      }
    }
    if (isset($valueFinal)) {
      return $valueFinal;
    } else {
      return [];
    }
  } else {
    return $data;
  }
}

function searchDate($value, $response, $nameValue)
{
  if (isset($value) and $value != null) {
    if ($value[0] > $value[1]) {
      $dateMin = $value[1];
      $dateMax = $value[0];
    } else if ($value[0] === $value[1]) {
      $dateMin = $value[1];
      $dateMax = $value[0];
    } else if ($value[0] < $value[1]) {
      $dateMin = $value[0];
      $dateMax = $value[1];
    }

    if ($dateMin === $dateMax) {
      for ($i = 0; $i < count($response); $i++) {
        $dateResponse = substr($response[$i][$nameValue], 0, 10);
        if ($dateResponse ===  $dateMax) {
          $valueFinal[] = $response[$i];
        }
      }
      if (isset($valueFinal)) {
        return $valueFinal;
      } else {
        return [];
      }
    } else {
      for ($i = 0; $i < count($response); $i++) {
        $dateResponse = substr($response[$i][$nameValue], 0, 10);
        if ($dateResponse <=  $dateMax and $dateResponse >=  $dateMin) {
          $valueFinal[] = $response[$i];
        }
      }
      if (isset($valueFinal)) {
        return $valueFinal;
      } else {
        return [];
      }
    }
  } else {
    return $response;
  }
}


//POST

$_POST = json_decode(file_get_contents("php://input"), true);
$typeForm = $_POST["typeForm"];
if ($typeForm === 'default') {
  $total = json_encode($response);
  echo $total;
  exit;
} else {
  if (isset($_POST["typePost"])) {
    $typePost = $_POST["typePost"];
  } else {
    $typePost = [];
  }
  if (isset($_POST["deployFactoryPost"])) {
    $deployFactoryPost = $_POST["deployFactoryPost"];
  } else {
    $deployFactoryPost = [];
  }
  if (isset($_POST["deployPlacePost"])) {
    $deployPlacePost = $_POST["deployPlacePost"];
  } else {
    $deployPlacePost = [];
  }
  if (isset($_POST["lastNamePost"])) {
    $lastNamePost = $_POST["lastNamePost"];
  } else {
    $lastNamePost = [];
  }
  if (isset($_POST["priorityPost"])) {
    $priorityPost = $_POST["priorityPost"];
  } else {
    $priorityPost = [];
  }
  //date

  if (isset($_POST["dateStartPost"])) {
    $datePost = $_POST["dateStartPost"];
  } else {
    $datePost = [];
  }
  if (isset($_POST["dateEndPost"])) {
    $endDatePost = $_POST["dateEndPost"];
  } else {
    $endDatePost = [];
  }

  //$datePost=['2021-06-09','2021-06-19'];

  $finalData1 = searchData($typePost, $response, 'type');
  $finalData2 = searchData($deployFactoryPost, $finalData1, 'deployFactory');
  $finalData3 = searchData($deployPlacePost, $finalData2, 'deployPlace');
  $finalData4 = searchData($lastNamePost, $finalData3, 'lastName');
  $finalData5 = searchData($priorityPost, $finalData4, 'priority');
  $finalData6 = searchDate($datePost, $finalData5, 'date');
  $finalData7 = searchDate($endDatePost, $finalData6, 'endDate');
  $total = json_encode($finalData7);
  echo $total;
  exit;
}
