<?php
header('Access-Control-Allow-Origin: *');

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA";

//Generate List 
//$ch = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=2&SapClient=PRD&IsActive=true');  //URL by repair
$ch = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=2&SapClient=prd&IsActive=true&workplace=SZERSZAM&IsActive=true');  //URL by repair

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $token
));
$data = curl_exec($ch);
curl_close($ch);
$decoded = json_decode($data, true);
$result = $decoded['notifications'];

//function

function searchList($value, $data, $nameValue, $nameValue2)
{
  if (isset($value) and $value != null) {

    for ($j = 0; $j < count($value); $j++) {
      for ($i = 0; $i < count($data); $i++) {
        if ($data[$i][$nameValue] === $value[$j]) {
          if ($data[$i][$nameValue] !== null and $data[$i][$nameValue] !== "") {
            if (strlen($data[$i][$nameValue2]) > 0) {
              $valueFinal[] = $data[$i][$nameValue2];
            }
          }
        }
      }
    }
    if (isset($valueFinal)) {
      $valueFinal = array_values(array_unique($valueFinal));
      return $valueFinal;
    } else {
      return [];
    }
  } else {
    for ($i = 0; $i < count($data); $i++) {

      if (strlen($data[$i][$nameValue2]) > 0) {
        $valueFinal[] = $data[$i][$nameValue2];
      }
    }
    if (isset($valueFinal)) {
      $valueFinal = array_values(array_unique($valueFinal));
      return $valueFinal;
    } else {
      return [];
    }
  }
}

function searchName($data, $compare1, $comparetxt1, $compare2, $comparetxt2, $compare3, $comparetxt3, $textvalue, $textvalue2)
{
  for ($i = 0; $i < count($data); $i++) {
    if (isset($compare1) and $compare1 != null) {
      for ($j = 0; $j < count($compare1); $j++) {
        if ($data[$i][$comparetxt1] === $compare1[$j]) {
          for ($k = 0; $k < count($compare2); $k++) {
            if ($data[$i][$comparetxt2] === $compare2[$k]) {
              for ($l = 0; $l < count($compare3); $l++) {
                if ($data[$i][$comparetxt3] === $compare3[$l]) {
                  if (strlen($data[$i][$textvalue]) > 0 and strlen($data[$i][$textvalue2]) > 0) {
                    $valueFinal[] = $data[$i][$textvalue] . ' ' . $data[$i][$textvalue2];
                  }
                }
              }
            }
          }
        }
      }
    } else {
      if (isset($compare2) and $compare2 != null) {
        for ($k = 0; $k < count($compare2); $k++) {
          if ($data[$i][$comparetxt2] === $compare2[$k]) {
            for ($l = 0; $l < count($compare3); $l++) {
              if ($data[$i][$comparetxt3] === $compare3[$l]) {
                if (strlen($data[$i][$textvalue]) > 0 and strlen($data[$i][$textvalue2]) > 0) {
                  $valueFinal[] = $data[$i][$textvalue] . ' ' . $data[$i][$textvalue2];
                }
              }
            }
          }
        }
      } else {
        for ($l = 0; $l < count($compare3); $l++) {
          if ($data[$i][$comparetxt3] === $compare3[$l]) {
            if (strlen($data[$i][$textvalue]) > 0 and strlen($data[$i][$textvalue2]) > 0) {
              $valueFinal[] = $data[$i][$textvalue] . ' ' . $data[$i][$textvalue2];
            }
          }
        }
      }
    }
  }
  if (isset($valueFinal)) {
    $valueFinal = array_values(array_unique($valueFinal));
    return $valueFinal;
  } else {
    return [];
  }
}

function searchCompareList($valuePost, $valueData)
{
  if (isset($valuePost) and $valuePost != null) {
    for ($i = 0; $i < count($valuePost); $i++) {
      for ($j = 0; $j < count($valueData); $j++) {
        if ($valuePost[$i] === $valueData[$j]) {
          $valueFinal[] = $valueData[$j];
        }
      }
    }

    if (isset($valueFinal)) {
      $valueFinal = array_values(array_unique($valueFinal));
      return $valueFinal;
    } else {
      return $valueData;
    }
  } else {
    for ($i = 0; $i < count($valueData); $i++) {
      $valueFinal[] = $valueData[$i];
    }
    if (isset($valueFinal)) {
      $valueFinal = array_values(array_unique($valueFinal));
      return $valueFinal;
    } else {
      return $valueData;
    }
  }
}

function compareList($valueList1, $valueList2)
{
  if (count($valueList1) > 0 and count($valueList2) > 0) {
    for ($i = 0; $i < count($valueList1); $i++) {
      for ($j = 0; $j < count($valueList2); $j++) {
        if ($valueList1[$i] === $valueList2[$j]) {
          $valueFinal[] = $valueList1[$i];
        }
      }
    }
    if (isset($valueFinal)) {
      $valueFinal = array_values(array_unique($valueFinal));
      return $valueFinal;
    } else {
      return [];
    }
  } else {
    return [];
  }
}

//POST
$_POST = json_decode(file_get_contents("php://input"), true);
$typeForm = $_POST["typeForm"];
//$typeForm = '';
$list_notification = [];
$list_deployFactory = [];
$list_deployPlace = [];
$list_lastName = [];
for ($i = 0; $i < count($decoded['notifications']); $i++) {

  if (strlen($decoded['notifications'][$i]['notificationType']) > 0) {
    array_push($list_notification, $decoded['notifications'][$i]['notificationType']);
  }
  if (strlen($decoded['notifications'][$i]['deployFactory']) > 0) {
    array_push($list_deployFactory, $decoded['notifications'][$i]['deployFactory']);
  }
  if (strlen($decoded['notifications'][$i]['deployPlace']) > 0) {
    array_push($list_deployPlace, $decoded['notifications'][$i]['deployPlace']);
  }
  if (strlen($decoded['notifications'][$i]['lastName']) > 0) {
    array_push($list_lastName, $decoded['notifications'][$i]['lastName'] . ' ' . $decoded['notifications'][$i]['firstName']);
  }
}
$list_notification = array_values(array_unique($list_notification));
$list_deployFactory = array_values(array_unique($list_deployFactory));
$list_deployPlace = array_values(array_unique($list_deployPlace));
$list_lastName = array_values(array_unique($list_lastName));

if ($typeForm === 'default') {
  $list[] = array('notification' => $list_notification, 'deployFactory' => $list_deployFactory, 'deployPlace' => $list_deployPlace, 'lastName' => $list_lastName);
  echo json_encode($list);
} else {
  if (isset($_POST["notificationPost"])) {
    $list_notificationPost = $_POST["notificationPost"];
  } else {
    $list_notificationPost = [];
  }
  if (isset($_POST["deployFactoryPost"])) {
    $list_deployFactoryPost = $_POST["deployFactoryPost"];
  } else {
    $list_deployFactoryPost = [];
  }
  if (isset($_POST["deployPlacePost"])) {
    $list_deployPlacePost = $_POST["deployPlacePost"];
  } else {
    $list_deployPlacePost = [];
  }
  /*
  $list_notificationPost = ["JG"];
  $list_deployFactoryPost = ["1700"];
  $list_deployPlacePost = [];*/

  //notificationType
  $finalData0 = searchList($list_deployFactoryPost, $result, 'deployFactory', 'notificationType');
  $finalData0_1 = searchCompareList($list_notificationPost, $finalData0);
  $finalData0_2 = searchList($list_deployPlacePost, $result, 'deployPlace', 'notificationType');
  $finalDataSelect0 = searchCompareList($list_notificationPost, $finalData0_2);
  //deployFactory  
  $finalData1 = searchList($finalDataSelect0, $result, 'notificationType', 'deployFactory');
  $finalData1_1 = searchCompareList($list_deployFactoryPost, $finalData1);
  $finalData1_2 = searchList($list_deployPlacePost, $result, 'deployPlace', 'deployFactory');
  $finalDataSelect1 = searchCompareList($list_deployFactoryPost, $finalData1_2);
  //deployPlace
  $finalData2_1 = searchList($finalDataSelect0, $result, 'notificationType', 'deployPlace');
  $finalData2_2 = searchList($finalDataSelect1, $result, 'deployFactory', 'deployPlace');
  $finalData2 = compareList($finalData2_1, $finalData2_2);
  $finalDataSelect2 = searchCompareList($list_deployPlacePost, $finalData2);

  //name
  $finalDataLname = searchName($result, $finalDataSelect0, 'notificationType', $finalDataSelect1, 'deployFactory', $finalDataSelect2, 'deployPlace', 'lastName', 'firstName');

  if ($list_notificationPost === [] or $list_notificationPost === '') {
    if ($list_deployFactoryPost === [] or $list_deployFactoryPost === '') {
      if ($list_deployPlacePost === [] or $list_deployPlacePost === '') {
        $notification = $list_notification;
        $deployFactory = $list_deployFactory;
        $deployPlace = $list_deployPlace;
        $name = $list_lastName;
        $test = 'todo nothing';//
      }else{
        $notification = $finalData0_2;
        $deployFactory = $finalDataSelect1;
        $deployPlace = $finalData1_2;
        $name = $finalDataLname;
        $test = 'Notific nothing + factory nothing';//
      }
    }else{
      if ($list_deployPlacePost === [] or $list_deployPlacePost === '') {
        $notification = $finalData0;
        $deployFactory = $list_deployFactory;
        $deployPlace = $finalData2_2;
        $name = $finalDataLname;
        $test = 'notific nothing + place nothing';//
      }else{
        $notification = $finalData0;
        $deployFactory = $finalData1;
        $deployPlace = $finalDataSelect2;
        $name = $finalDataLname;
        $test = 'place nothing';//
      }
    }
  } else {
    if ($list_deployFactoryPost === [] or $list_deployFactoryPost === '') {
      if ($list_deployPlacePost === [] or $list_deployPlacePost === '') {
        $notification = $list_notification;
        $deployFactory = $finalData1;
        $deployPlace = $finalData2_1;
        $name = $finalDataLname;
        $test = 'place nothing + factory nothing';//
      }else{
        $notification = $finalData0_2;
        $deployFactory = $finalDataSelect1;
        $deployPlace = $finalData2_1;
        $name = $finalDataLname;
        $test = 'factory nothing';//
      }   
    }else{
      $notification = $finalDataSelect0;
      $deployFactory = $finalDataSelect1;
      $deployPlace = $finalDataSelect2;
      $name = $finalDataLname;
      $test = 'all';//
    }
  }
  $list = array(
    'notification' => $notification,
    'deployFactory' => $deployFactory,
    'deployPlace' => $deployPlace,
    'lastName' => $name,
    'state' => $test
  );
  echo json_encode($list);

}
