<?php
header('Access-Control-Allow-Origin: *');

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA";

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

    for ($i = 0; $i <= $n_machine - 1; $i++) {

        if ($decoded1["terminals"][$i]["id"] === 109) { //Change ID with MAIN
            $ch2 = curl_init('http://192.168.4.79:20000/api/management/Terminal/' . $decoded1["terminals"][$i]["id"] . '/Children');
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ));
            $data2 = curl_exec($ch2);
            curl_close($ch2);
            $decoded2 = json_decode($data2, true);

            for ($j = 0; $j <= count($decoded2["terminals"]) - 1; $j++) {

                $nameMachine = $decoded2["terminals"][$j]['name'];
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

                if (count($decoded3["terminalJobs"]) > 0) {
                    for ($a = 0; $a < count($decoded3["terminalJobs"]); $a++) {
                        $joblist[] = array(
                            'id' => $decoded3["terminalJobs"][$a]['id'],
                            'number' => $decoded3["terminalJobs"][$a]['notificationNumber'],
                            'nameMachine' => $nameMachine,
                            'jobstatus' => $decoded3["terminalJobs"][$a]["jobStatus"]["id"],
                        );
                    }
                } else {
                    $joblist = null;
                }
                $jobDetail[] = $joblist;
            }
        }
    }
}

//Generate List 
//$ch4 = curl_init('http://192.168.4.79:20000/api/sap/GetNotifications/2/DEV/true');  //URL by parts
//$ch4 = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=2&SapClient=DEV&IsActive=true');  //URL by parts
$ch4 = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=2&SapClient=prd&IsActive=true&workplace=SZERSZAM');  //URL by parts


curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch4, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
));
$data4 = curl_exec($ch4);
curl_close($ch4);
$decoded4 = json_decode($data4, true);

//$ch = curl_init('http://192.168.4.79:20000/api/sap/GetNotifications/1/DEV/true');  //URL by parts
//$ch = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=1&SapClient=DEV&IsActive=true');  //URL by parts
$ch = curl_init('http://192.168.4.79:20000/api/sap/Notification?LocationId=1&SapClient=prd&IsActive=true&workplace=SZERSZAM');  //URL by parts

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
));
$data = curl_exec($ch);
curl_close($ch);
$decoded = json_decode($data, true);

$notifications = [];
array_push($notifications, $decoded["notifications"]);
array_push($notifications, $decoded4["notifications"]);

for ($z = 0; $z < count($notifications); $z++) {

    for ($i = 0; $i < count($notifications[$z]); $i++) {

        $number = $notifications[$z][$i]['notificationNumber'];
        $name = $notifications[$z][$i]['notificationText'];
        $equipment = $notifications[$z][$i]['equipmentNumber'];
        $startOfMalfunction = substr($notifications[$z][$i]['startOfMalfunction'], 0, 10);

        if (strlen($notifications[$z][$i]['deployFactory']) > 0) {
            $deployFactory0 = $notifications[$z][$i]['deployFactory'];
        } else if ($notifications[$z][$i]['deployFactory'] !== null) {
            $deployFactory0 = '-';
        }
        $deployFactory = $deployFactory0;

        if (strlen($notifications[$z][$i]['deployPlace']) > 0) {
            $deployPlace0 = $notifications[$z][$i]['deployPlace'];
        } else {
            $deployPlace0 = '-';
        }
        $deployPlace = $deployPlace0;

        if (isset($notifications[$z][$i]['properties'])) {

            if (isset($notifications[$z][$i]['properties']['priority'])) {
                $propPriority = $notifications[$z][$i]['properties']['priority'];
            } else if ($notifications[$z][$i]['properties']['priority'] !== null) {
                $propPriority = '-';
            }

            $endDate = substr($notifications[$z][$i]['properties']['endDate'],  0, 10);
            if (isset($notifications[$z][$i]['properties']['plannedWorkTimeMin'])) {
                if ($notifications[$z][$i]['properties']['plannedWorkTimeMin'] > 0) {
                    $plannedWorkTimeMin = round(((int)$notifications[$z][$i]['properties']['plannedWorkTimeMin']) / 60, 2);
                } else {
                    $plannedWorkTimeMin = 0;
                }
            }
        } else {
            $propPriority = '-';
            $plannedWorkTimeMin = null;
            $endDate = null;
        }

        if (isset($notifications[$z][$i]['orders'][0]['plannerGroup'])) {
            $plannerGroup = $notifications[$z][$i]['orders'][0]['plannerGroup'];
        } else {
            $plannerGroup = "";
        }
        if (isset($notifications[$z][$i]['orders'][0]['plannerGroupName'])) {
            $plannerGroupName = $notifications[$z][$i]['orders'][0]['plannerGroupName'];
        } else {
            $plannerGroupName = "";
        }
        $plannerGroupTitle = $plannerGroup . '-' . $plannerGroupName;



        if (isset($notifications[$z][$i]['orders'][0]['mainOrderNumber'])) {
            if ((int)$notifications[$z][$i]['orders'][0]['mainOrderNumber'] == 0) {
                $mainOrderNumber = "";
            } else {
                $mainOrderNumber = (int)$notifications[$z][$i]['orders'][0]['mainOrderNumber'];
            }
        } else {
            $mainOrderNumber = "";
        }


        if (isset($notifications[$z][$i]['orders'][0]['orderStatus'])) {
            $orderStatusH =  $notifications[$z][$i]['orders'][0]['orderStatus'];
        } else {
            $orderStatusH = 'null';
        }
        //JOB ID AND MACHINE

        for ($a = 0; $a < count($jobDetail); $a++) {
            if ($jobDetail[$a] !== null) {

                for ($b = 0; $b < count($jobDetail[$a]); $b++) {

                    if ($number == $jobDetail[$a][$b]["number"]) {
                        $jobId0[$z][$i] = $jobDetail[$a][$b]["id"];
                        $machine0[$z][$i]  = $jobDetail[$a][$b]["nameMachine"];
                        $jobstatus0[$z][$i] = $jobDetail[$a][$b]["jobstatus"];
                    }
                }
            }
        }

        if (isset($jobId0[$z][$i]) and isset($machine0[$z][$i])) {
            $jobId = $jobId0[$z][$i];
            $machine = $machine0[$z][$i];
            $jobstatus = $jobstatus0[$z][$i];
        } else {
            $jobId = null;
            $machine = 'nem kijelölt';
            $jobstatus = null;
        }
        $type = $notifications[$z][$i]['notificationType'];
        $date = substr($notifications[$z][$i]['startDate'], 0, 10);

        if (isset($notifications[$z][$i]['priority'])) {
            $priority = $notifications[$z][$i]['priority'];
        } else {
            $priority = '-';
        }

        if ($notifications[$z][$i]['priority'] == null) {
            $order = 9;
        } else {
            $order = $notifications[$z][$i]['priority'];
        }

        //if exist saporder

        if (isset($notifications[$z][$i]['orders'][0]['orderId'])) {
            $orderid =  $notifications[$z][$i]['orders'][0]['orderId'];
        } else {
            $orderid = "";
        }

        //List detail

        $response[]   =  array(
            'part' => $name,
            'machine' => $machine,
            'job' => $jobId,
            'number' => $number,
            'priority' =>  $priority,
            'numberSap' => $orderid,
            'txtpart' => $equipment,
            'type' => $type,
            'date' => $date,
            'mainOrderNumber' => $mainOrderNumber,
            'startOfMalfunction' => $startOfMalfunction,
            'propPriority' => $propPriority,
            'plannedWorkTimeMin' => $plannedWorkTimeMin,
            'endDate' => $endDate,
            'plannerGroupTitle' => $plannerGroupTitle,
            'jobstatus' => $jobstatus,
            'deployFactory' => $deployFactory,
            'deployPlace' => $deployPlace,
            'orderStatus' => $orderStatusH
        );
    }
}
sort($response);

//separate childs from others
$child = [];
$others = [];
for ($i = 0; $i < count($response); $i++) {

    if (isset($response[$i]["mainOrderNumber"]) and $response[$i]["mainOrderNumber"] !== "") {
        array_push($child, $response[$i]);
    } else {
        array_push($others, $response[$i]);
    }
}
//put child with yours parents

for ($i = 0; $i < count($others); $i++) {

    //compare with number of Childs

    for ($j = 0; $j < count($child); $j++) {
        if ($child[$j]["mainOrderNumber"] == $others[$i]["numberSap"]) {
            $othersChild[$i][] = $child[$j];
        }
    }
    if (isset($othersChild[$i])) {
        $othersChildF = $othersChild[$i];
    } else {
        $othersChildF = "";
    }
    //add To array


    if ($others[$i]['orderStatus'] !== 2) {
        $resp[]   =  array(
            'part' => $others[$i]["part"],
            'machine' => $others[$i]["machine"],
            'job' => $others[$i]["job"],
            'number' => $others[$i]["number"],
            'priority' =>  $others[$i]["priority"],
            'numberSap' => $others[$i]["numberSap"],
            'txtpart' => $others[$i]["txtpart"],
            'type' => $others[$i]["type"],
            'date' => $others[$i]["date"],
            'mainOrderNumber' => $others[$i]["mainOrderNumber"],
            'childs' => $othersChildF,
            'startOfMalfunction' => $others[$i]['startOfMalfunction'],
            'propPriority' => $others[$i]['propPriority'],
            'plannedWorkTimeMin' => $others[$i]['plannedWorkTimeMin'],
            'endDate' => $others[$i]['endDate'],
            'plannerGroupTitle' => $others[$i]['plannerGroupTitle'],
            'jobstatus' => $others[$i]['jobstatus'],
            'deployFactory' => $others[$i]['deployFactory'],
            'deployPlace' => $others[$i]['deployPlace'],
            'orderStatus' => $others[$i]['orderStatus'],
        );
    }
}

$total = json_encode($resp);
echo $total;

exit;
