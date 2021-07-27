<?php
header('Access-Control-Allow-Origin: *');

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA";
//Color

$colorList = array('#880E4F', '#0277BD', '#2E7D32', '#0D47A1', '#D84315', '#004D40', '#4A148C', '#827717', '#64DD17', '#682404');
$colorBkList = array('#F48FB1', '#B3E5FC', '#A5D6A7', '#BBDEFB', '#FFAB91', '#80CBC4', '#CE93D8', '#DCE775', '#CCFF90', '#BCAAA4');

//workgroup
$cha = curl_init('http://192.168.4.79:20000/api/management/WorkGroup');
curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cha, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $token
));
$dataWork = curl_exec($cha);
curl_close($cha);
$decodedWork = json_decode($dataWork, true);
$workgroup = [];
if ($decodedWork !== null and $decodedWork !== "" and $decodedWork !== []) {
  for ($i = 0; $i < count($decodedWork["workGroups"]); $i++) {
    //colors
    if ($i > 9 and $i < 100) {
      $numberColor = substr($i, 1);
    } elseif ($i > 99 and $i < 1000) {
      $numberColor = substr($i, 2);
    } else {
      $numberColor = $i;
    }
    $colorGroup = $colorList[$numberColor];
    $bkGroup = $colorBkList[$numberColor];
    //echo $i . ' - ' . $colorGroup . ' - ' . $bkGroup . '<br>';

    if (count($decodedWork["workGroups"][$i]["terminals"]) > 0) {
      for ($j = 0; $j < count($decodedWork["workGroups"][$i]["terminals"]); $j++) {
        $workgroupChild = array(
          'nameGroup' => $decodedWork["workGroups"][$i]["name"],
          'id' => $decodedWork["workGroups"][$i]["terminals"][$j]["id"],
          'colorGroup' => $colorGroup,
          'bkGroup' => $bkGroup,
        );
        array_push($workgroup, $workgroupChild);
      }
    }
  }
}

//childWork
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

if ($decoded !== null and $decoded !== "" and $decoded !== []) {

  $n_machine = count($decoded["terminals"]);

  for ($i = 0; $i <= $n_machine - 1; $i++) {


    if ($decoded["terminals"][$i]["id"] === 109) { //Change ID with MAIN
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

        if ($decoded2["terminals"][$j]["location"]["id"] == 1) { /// this change repair or part
          //Workgroup

          for ($t = 0; $t < count($workgroup); $t++) {
            if ($workgroup[$t]["id"] === $decoded2["terminals"][$j]["id"]) {
              $workgroupName[$j] = $workgroup[$t]["nameGroup"];
              $workgroupColor[$j] = $workgroup[$t]["colorGroup"];
              $workgroupBk[$j] = $workgroup[$t]["bkGroup"];
            }
          }
          if (isset($workgroupName[$j])) {
            $workgroupNameF[$j] = $workgroupName[$j];
            $workgroupColorF[$j] = $workgroupColor[$j];
            $workgroupBkF[$j] = $workgroupBk[$j];
          } else {
            $workgroupNameF[$j] = '_no_group_';
            $workgroupColorF[$j] = "#1A237E";
            $workgroupBkF[$j] = '';
          }

          //USER
          $ch4 = curl_init('http://192.168.4.79:20000/api/management/Session/ByTerminal/' . $decoded2["terminals"][$j]["id"] . '?isActive=true');
          curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch4, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
          ));
          $data4 = curl_exec($ch4);
          curl_close($ch4);
          $decoded4 = json_decode($data4, true);

          if ($decoded4["workGroupSessions"] !== null and $decoded4["workGroupSessions"] !== []) {
            // echo $decoded2["terminals"][$j]["id"] . '<br>';
            // echo json_encode($decoded4["workGroupSessions"]); //[0]["employee"]
            $useronline = $decoded4["workGroupSessions"][0]["employee"]["fullName"];
          } else {
            $useronline = null;
          }
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
          //generate List
          $list[$j] = [];
          if (isset($decoded3)) {
            for ($k = 0; $k < count($decoded3['terminalJobs']); $k++) {

              $idJob = $decoded3["terminalJobs"][$k]["id"];
              $id = $decoded3["terminalJobs"][$k]["notificationNumber"];
              //JobStatus
              $jobStatus = $decoded3["terminalJobs"][$k]["jobStatus"]["id"];

              $ch4 = curl_init('http://192.168.4.79:20000/api/sap/Notification/' . $decoded3["terminalJobs"][$k]["notificationNumber"]);
              curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch4, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
              ));
              $data4 = curl_exec($ch4);
              curl_close($ch4);
              $decoded4 = json_decode($data4, true);

              if ($decoded4['notification']['priority'] == 1) {
                $priority = '#FF00FF';
              } else  if ($decoded4['notification']['priority'] ==  2) {
                $priority = '#FF0000';
              } else  if ($decoded4['notification']['priority'] ==  3) {
                $priority = '#FFA500';
              } else  if ($decoded4['notification']['priority'] ==  4) {
                $priority = '#9ACD32';
              } else {
                $priority = '#263238';
              }

              if (isset($decoded4['notification']['properties']) and $decoded4['notification']['properties'] !== null) {
                if ($decoded4['notification']['properties']['priority'] == 1) {
                  $priorityProp = '#FF00FF';
                } else  if ($decoded4['notification']['properties']['priority'] == 2) {
                  $priorityProp = '#FF0000';
                } else  if ($decoded4['notification']['properties']['priority'] == 3) {
                  $priorityProp = '#FFA500';
                } else  if ($decoded4['notification']['properties']['priority'] == 4) {
                  $priorityProp = '#9ACD32';
                } else {
                  $priorityProp = '#263238';
                }
              } else {
                $priorityProp = '#263238';
              }

              if ($decoded4['notification']['properties']  == null) {
                $order = 9;
              } else {
                $order = $decoded4['notification']['properties']['priority'];
              }
              $name = $decoded4["notification"]['notificationText'];
              $equipment = $decoded4["notification"]['equipmentNumber'];
              $equipmentText = $decoded4["notification"]['equipmentText'];

              if (isset($decoded4["notification"]["orders"][0]['orderId'])) {
                $orderid = $decoded4["notification"]["orders"][0]['orderId'];
              } else {
                $orderid = $id;
              }

              $item[$k] = array(
                'order' => (int)$order,
                'idJob' => $idJob,
                'id' => $id,
                'name' => $name,
                'color' =>  $priority,
                'idchild' => $decoded2["terminals"][$j]["id"],
                'equipment' => $equipment,
                'equipmentText' => $equipmentText,
                'orderid' => $orderid,
                //'date' => substr(str_replace('T', '   ', $decoded4["notification"]['startDate']), 0, -3),   
                'date' => substr($decoded4["notification"]['startDate'], 0, -9),
                'type' => $decoded4["notification"]['notificationType'],
                'deployFactory' => $decoded4["notification"]['deployFactory'],
                'deployPlace' => $decoded4["notification"]['deployPlace'],
                'lastName' => $decoded4["notification"]['lastName'].' '.$decoded4["notification"]['firstName'],
                'jobStatus' => $jobStatus,
                'priorityProp' => $priorityProp
              );
              array_push($list[$j], $item[$k]);
            }
            //order by priority
            sort($list[$j]);
          }

          $childJob[] = array(
            'workgroup' => $workgroupNameF[$j],
            'idParent' => $decoded["terminals"][$i]["id"],
            'id' => $decoded2["terminals"][$j]["id"],
            'name' => $decoded2["terminals"][$j]["name"],
            'color' => $workgroupColorF[$j],
            'bk' => $workgroupBkF[$j],
            'list' => $list[$j],
            'user' => $useronline
          );
        }
      }
    }
  }
  sort($childJob);
  $final = json_encode($childJob);
  echo $final;
}
