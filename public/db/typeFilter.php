<?php
header('Access-Control-Allow-Origin: *');
$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA";
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
function searchName($data, $compare1, $comparetxt1, $compare2, $comparetxt2, $textvalue, $textvalue2)
{
  for ($i = 0; $i < count($data); $i++) {
    if (isset($compare1) and $compare1 != null) {
      for ($j = 0; $j < count($compare1); $j++) {
        if ($data[$i][$comparetxt1] === $compare1[$j]) {
          for ($k = 0; $k < count($compare2); $k++) {
            if ($data[$i][$comparetxt2] === $compare2[$k]) {
              if (strlen($data[$i][$textvalue]) > 0 and strlen($data[$i][$textvalue2]) > 0) {
                $valueFinal[] = $data[$i][$textvalue] . ' ' . $data[$i][$textvalue2];
              }
            }
          }
        }
      }
    } else {
      if (isset($compare2) and $compare2 != null) {
        for ($k = 0; $k < count($compare2); $k++) {
          if ($data[$i][$comparetxt2] === $compare2[$k]) {
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
//Generate List 
$ch = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=1&SapClient=PRD&IsActive=true');  //URL by repair
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $token
));
$data = curl_exec($ch);
curl_close($ch);
$decoded = json_decode($data, true);
$result = $decoded['notifications'];

//POST
$_POST = json_decode(file_get_contents("php://input"), true);
$type = $_POST["type"];
$valuefactory = $_POST["valuefactory"];
$valueplace = $_POST["valueplace"];

//default List
for ($i = 0; $i < count($decoded['notifications']); $i++) {
  if ($decoded['notifications'][$i]['deployFactory'] !== '') {
    $list_deployFactory[] = $decoded['notifications'][$i]['deployFactory'];
  }
  if ($decoded['notifications'][$i]['deployPlace'] !== '') {
    $list_deployPlace[] = $decoded['notifications'][$i]['deployPlace'];
  }
  if (strlen($decoded['notifications'][$i]['lastName']) > 0) {
    $list_deployName[]=$decoded['notifications'][$i]['lastName'] . ' ' . $decoded['notifications'][$i]['firstName'];
  }
}
$list_deployFactory = array_values(array_unique($list_deployFactory));
$list_deployPlace = array_values(array_unique($list_deployPlace));
$list_deployName = array_values(array_unique($list_deployName));


//List value

if ($type === 'default' or ($valuefactory === '' and $valueplace === '')) {

  $list = array('deployFactory' => $list_deployFactory, 'deployPlace' => $list_deployPlace,'lastName' => $list_deployName);
  echo json_encode($list);
} else {
  if ($valuefactory !== '' and $valueplace !== '') {

    $list_Search_deployFactory = searchList($valueplace, $result, 'deployPlace', 'deployFactory');
    $list_Search_deployFactory = array_values(array_unique($list_Search_deployFactory));
    $list_Search_deployPlace = searchList($valuefactory, $result, 'deployFactory', 'deployPlace');
    $list_Search_deployPlace = array_values(array_unique($list_Search_deployPlace));
    $list_Search_name = searchName($result, $list_Search_deployFactory, 'deployFactory', $list_Search_deployPlace, 'deployPlace','lastName', 'firstName');
    $list_Search_name = array_values(array_unique($list_Search_name));

    $list = array('deployFactory' => $list_Search_deployFactory, 'deployPlace' => $list_Search_deployPlace, 'lastName' => $list_Search_name);
    echo json_encode($list);
  } else if ($valuefactory === '' and $valueplace !== '') {

    $list_Search_deployFactory = searchList($valueplace, $result, 'deployPlace', 'deployFactory');
    $list_Search_deployFactory = array_values(array_unique($list_Search_deployFactory));

    $list_Search_name = searchName($result, $valueplace, 'deployPlace', $list_Search_deployFactory, 'deployFactory','lastName', 'firstName');
    $list_Search_name = array_values(array_unique($list_Search_name));

    $list = array('deployFactory' => $list_Search_deployFactory, 'deployPlace' => $list_deployPlace, 'lastName' => $list_Search_name);
    echo json_encode($list);
  } elseif ($valueplace === '' and $valuefactory !== '') {

    $list_Search_deployPlace = searchList($valuefactory, $result, 'deployFactory', 'deployPlace');
    $list_Search_deployPlace = array_values(array_unique($list_Search_deployPlace));

    $list_Search_name = searchName($result, $valuefactory, 'deployFactory', $list_Search_deployPlace, 'deployPlace','lastName', 'firstName');
    $list_Search_name = array_values(array_unique($list_Search_name));

    $list = array('deployFactory' => $list_deployFactory, 'deployPlace' => $list_Search_deployPlace,'lastName' => $list_Search_name);
    echo json_encode($list);
  }
}
