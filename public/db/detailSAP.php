<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set('Europe/Budapest');
$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqcCIsIm5iZiI6MTU5ODM1Mjc4OSwiZXhwIjoxNjI5ODg4Nzg5LCJpYXQiOjE1OTgzNTI3ODksImlzcyI6IkpQVmF1bHRTZXJ2ZXIiLCJhdWQiOiJKUFZhdWx0In0.LWDLvTGtSUhF-AZM6TIW-aqNhsG4VO_sFvyh9MzJBUA";
$_POST = json_decode(file_get_contents("php://input"), true);
$id = $_POST["id"];
//$id = 10351810;

$ch = curl_init('http://192.168.4.79:20000/api/sap/Notification/' . $id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
));
$data = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

$decoded = json_decode($data, true);

if ($decoded["notification"]["properties"]["priority"] === 1) {
    $priok = "Nagyon Magas";
} else if ($decoded["notification"]["properties"]["priority"] === 2) {
    $priok = "Magas";
} else if ($decoded["notification"]["properties"]["priority"] === 3) {
    $priok = "Normál";
} else if ($decoded["notification"]["properties"]["priority"] === 4) {
    $priok = "Alacsony";
}

if ($decoded["notification"]["notificationNumber"] !== null and isset($decoded["notification"]["notificationNumber"])) {

    if (substr(str_replace('T', '   ', $decoded["notification"]["startOfMalfunction"]), 0, -3) === false) {
        $dateIH = '';
    } else {
        $dateIH = substr(str_replace('T', '   ', $decoded["notification"]["startOfMalfunction"]), 0, -3);
    }
    if (substr(str_replace('T', '   ', $decoded["notification"]["startDate"]), 0, -3) === false) {
        $dateSD = '';
    } else {
        $dateSD = substr(str_replace('T', '   ', $decoded["notification"]["startDate"]), 0, -3);
    }
    $item['sapNumber'] = array(
        array('name' => 'Jelentés Száma', 'value' => $decoded["notification"]["notificationNumber"]),

        array('name' => 'Jelentés Típusa', 'value' => $decoded["notification"]["notificationType"]),
        array('name' => 'Rövid Szöveg', 'value' => $decoded["notification"]["notificationText"]),
        array('name' => 'Felelős Munkahely', 'value' => $decoded["notification"]["workplace"]),
        array('name' => 'Gyár', 'value' => $decoded["notification"]["factory"]),

        array('name' => 'Jelentő Törzsszáma', 'value' => $decoded["notification"]["personnelNumber"]),
        array('name' => 'Jelentő', 'value' => $decoded["notification"]["lastName"] . ' ' . $decoded["notification"]["firstName"]),
        array('name' => 'Prioritás', 'value' => $priok),
        array('name' => 'PP gép', 'value' => $decoded["notification"]["workCenter"]),

        array('name' => 'Berendezés száma', 'value' => $decoded["notification"]["equipmentNumber"]),
        array('name' => 'Berendezés Megnevezés', 'value' => $decoded["notification"]["equipmentText"]),
        array('name' => 'Berendezés Típusa', 'value' => $decoded["notification"]["equipmentType"]),

        array('name' => 'Eszköz Szám', 'value' => (int)$decoded["notification"]["assetMainNumber"]),
        array('name' => 'Eszköz Megnevezése', 'value' => $decoded["notification"]["assetText"]),
        array('name' => 'Eszköz Alszám', 'value' => (int)$decoded["notification"]["assetSubNumber"]),
        array('name' => 'Vállalat Kódja', 'value' => $decoded["notification"]["companyCode"]),

        array('name' => 'Indításí Határidő', 'value' => $dateIH),
        array('name' => 'Várt Befejezési Határidő', 'value' => $dateSD),
        array('name' => 'Telepítési Gyár', 'value' => $decoded["notification"]["deployFactory"]),
        array('name' => 'Telepítési Hely', 'value' => $decoded["notification"]["deployPlace"]),

        array('name' => 'Műszaki Hely', 'value' => $decoded["notification"]["techArea"]),
        array('name' => 'Érintett Berendezés', 'value' => $decoded["notification"]["affectedEquipmentNumber"]),
        array('name' => 'Érintett Műszaki', 'value' => $decoded["notification"]["affectedTechArea"]),

        array('name' => 'Hosszú szöveg', 'value' => $decoded["notification"]['textLine']),
    );

    //priority Orders

    if ($decoded["notification"]["order"]["priority"] === 1) {
        $priok2 = "Nagyon Magas";
    } else if ($decoded["notification"]["order"]["priority"] === 2) {
        $priok2 = "Magas";
    } else if ($decoded["notification"]["order"]["priority"] === 3) {
        $priok2 = "Normál";
    } else if ($decoded["notification"]["order"]["priority"] === 4) {
        $priok2 = "Alacsony";
    } else {
        $priok2 = null;
    }

    if ($decoded["notification"]["order"]["orderId"] !== null and isset($decoded["notification"]["order"]["orderId"])) {
        $item['sapOrder'] = array(
            array('name' => 'SAP Rendelés', 'value' => $decoded["notification"]["order"]["orderId"]),

            array('name' => 'Rendelés Típusa', 'value' => $decoded["notification"]["order"]["orderType"]),
            array('name' => 'Rövid Szöveg', 'value' => $decoded["notification"]["order"]["shortText"]),
            array('name' => 'Munkahely', 'value' => $decoded["notification"]["order"]["mainWorkCenterForMaintenanceTasks"]),
            array('name' => 'Gyar Kod', 'value' => $decoded["notification"]["order"]["plant"]),

            array('name' => 'Prioritás', 'value' => $priok2),
            array('name' => 'Tervező Csoport', 'value' => $decoded["notification"]["order"]["plannerGroupName"]),
            array('name' => 'Forendeles Szam', 'value' => $decoded["notification"]["order"]['mainOrderNumber']),
            array('name' => 'Jelentes szam', 'value' => $decoded["notification"]["order"]['sapNotificationNumber']),

            array('name' => 'Berendezés', 'value' => $decoded["notification"]["order"]["equipmentNumber"]),
            array('name' => 'Berendezés Megnevezés', 'value' => $decoded["notification"]["order"]["equipmentText"]),
            array('name' => 'Berendezés Típusa', 'value' => $decoded["notification"]["order"]["equipmentType"]),

            array('name' => 'Eszköz Szám', 'value' => (int)$decoded["notification"]["order"]["assetMainNumber"]),
            array('name' => 'Eszköz Megnevezése', 'value' => $decoded["notification"]["order"]["assetText"]),
            array('name' => 'Eszköz Alszám', 'value' => (int)$decoded["notification"]["order"]["assetSubNumber"]),
            array('name' => 'Vállalat Kódja', 'value' => $decoded["notification"]["order"]["companyCode"]),

            array('name' => 'Létrehozás Dátuma', 'value' => substr(str_replace('T', '   ', $decoded["notification"]["order"]["enteredDate"]), 0, -3)),
            array('name' => 'Muszaki Hely', 'value' => $decoded["notification"]["order"]["functionalLocation"]),
            array('name' => 'Telepitesi Gyár', 'value' => $decoded["notification"]["order"]["maintenancePlant"]),
            array('name' => 'Telepítési Hely', 'value' => $decoded["notification"]["order"]["location"]),

            array('name' => 'Hosszú szöveg', 'value' => $decoded["notification"]["order"]['textLine']),
        );

        //detail
        $post = ['SearchConditions' => [
            'Conditions' => [
                0 => [
                    "PropTyp" => 0,
                    "PropDefId" => 93,
                    "SrchOper" => 3,
                    "SrchRule" => 0,
                    "SrchTxt" =>  $decoded["notification"]["order"]["orderId"]
                ],
            ],
            "SortConditions" => null,
            "FolderIds" => null,
            "RecurseFolders" => true,
            "LatestOnly" => true

        ]];
        $postf = json_encode($post);

        $chD = curl_init('http://192.168.4.79:20000/api/vault/core/File/Find/BySearchConditions');
        curl_setopt($chD, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chD, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($chD, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($chD, CURLOPT_POSTFIELDS, $postf);
        curl_setopt($chD, CURLOPT_FOLLOWLOCATION, 1);
        $dataDetail = curl_exec($chD);
        curl_close($chD);

        $detailId = json_decode($dataDetail, true);

        if (count($detailId['files']) > 0) {
            $numberID = $detailId['files'][0]['id'];
            $ch2 = curl_init('http://192.168.4.79:20000/api/vault/core/Property?EntityIds=' . $numberID . '&PropertyDefinitionIds=64&PropertyDefinitionIds=65&PropertyDefinitionIds=76&PropertyDefinitionIds=80&PropertyDefinitionIds=81&PropertyDefinitionIds=82&PropertyDefinitionIds=85&PropertyDefinitionIds=86&PropertyDefinitionIds=87&PropertyDefinitionIds=88&PropertyDefinitionIds=89&PropertyDefinitionIds=91');
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ));
            $data2 = curl_exec($ch2);
            curl_close($ch2);
            $allDetailId = json_decode($data2, true);
            $countDetail = count($allDetailId['properties']);
            if ($countDetail > 0) {

                for ($z = 0; $z < $countDetail; $z++) {

                    if ($allDetailId['properties'][$z]['propDefId'] == 64) {
                        $nameValueDetail = 'Anyag';
                        $valueDetail = $allDetailId['properties'][$z]['val'];
                        $order = 1;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 65) {
                        $nameValueDetail = 'Rajzszám';
                        $valueDetail = $allDetailId['properties'][$z]['val'];
                        $order = 2;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 76) {
                        $nameValueDetail = 'Projekt';
                        $valueDetail = $allDetailId['properties'][$z]['val'];
                        $order = 3;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 80) {
                        $nameValueDetail = 'CNC';
                        if ($allDetailId['properties'][$z]['val'] == true) {
                            $valueDetail = '✔';
                        } else {
                            $valueDetail = '✖';
                        }
                        $order = 9;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 81) {
                        $nameValueDetail = 'Darabszám';
                        $valueDetail = $allDetailId['properties'][$z]['val'];
                        $order = 4;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 82) {
                        $nameValueDetail = 'Dimenziók';
                        $valueDetail = $allDetailId['properties'][$z]['val'];
                        $order = 5;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 85) {
                        $nameValueDetail = 'Készméret';
                        $valueDetail = $allDetailId['properties'][$z]['val'];
                        $order = 6;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 86) {
                        $nameValueDetail = 'Lézervágás';
                        if ($allDetailId['properties'][$z]['val'] == true) {
                            $valueDetail = '✔';
                        } else {
                            $valueDetail = '✖';
                        }
                        $order = 10;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 87) {
                        $nameValueDetail = 'Főrendelés';
                        $valueDetail = $allDetailId['properties'][$z]['val'];
                        $order = 7;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 88) {
                        $nameValueDetail = 'Prioritás';
                        if ($allDetailId['properties'][$z]['val'] == 0) {
                            $valueDetail = "";
                        } else if ($allDetailId['properties'][$z]['val'] == 1) {
                            $valueDetail = "Nagyon Magas";
                        } else if ($allDetailId['properties'][$z]['val'] == 2) {
                            $valueDetail = "Magas";
                        } else if ($allDetailId['properties'][$z]['val'] == 3) {
                            $valueDetail = "Normál";
                        } else if ($allDetailId['properties'][$z]['val'] == 4) {
                            $valueDetail = "Alacsony";
                        }
                        $order = 8;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 89) {
                        $nameValueDetail = 'Forgácsolás';
                        if ($allDetailId['properties'][$z]['val'] == true) {
                            $valueDetail = '✔';
                        } else {
                            $valueDetail = '✖';
                        }
                        $order = 11;
                    } else if ($allDetailId['properties'][$z]['propDefId'] == 91) {
                        $nameValueDetail = 'Hegesztés';
                        if ($allDetailId['properties'][$z]['val'] == true) {
                            $valueDetail = '✔';
                        } else {
                            $valueDetail = '✖';
                        }
                        $order = 12;
                    }

                    $detail[] = array('order' => $order, 'name' => $nameValueDetail, 'value' => $valueDetail);
                }
                sort($detail);
                if ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'In Design') {
                    $FileLfCyc = 'Tervezés alatt';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'In Verification') {
                    $FileLfCyc = 'Jóváhagyva tervező által';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Sent To Manufacturing') {
                    $FileLfCyc = 'Megmunkálásra kiküldve JB Szerszám';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Sent To Cutting') {
                    $FileLfCyc = 'Vágásra kiküldve';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Under Cutting') {
                    $FileLfCyc = 'Vágás alatt';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Done By Cutting') {
                    $FileLfCyc = 'Levágva';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Under Manufacturing') {
                    $FileLfCyc = 'Megmunkálás alatt JB Szerszám';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Done By Manufacturing') {
                    $FileLfCyc = 'Megmunkálás kész JB Szerszám';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Sent To Nagyrede') {
                    $FileLfCyc = 'Megmunkálásra kiküldve Nagyréde';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Under Nagyrede') {
                    $FileLfCyc = 'Megmunkálás alatt Nagyréde';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Done By Nagyrede') {
                    $FileLfCyc = 'Megmunkálás kész Nagyréde';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Sent To JB Mech') {
                    $FileLfCyc = 'Megmunkálásra kiküldve JB Lakatos';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Under JB Mech') {
                    $FileLfCyc = 'Megmunkálás alatt JB Lakatos';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Done By JB Mech') {
                    $FileLfCyc = 'Megmunkálás kész JB Lakatos';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'In Building 31') {
                    $FileLfCyc = '31-es üzemben';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Assembled') {
                    $FileLfCyc = 'Összeszerelve';
                } elseif ($detailId['files'][0]['fileLfCyc']['lfCycStateName'] === 'Cancelled') {
                    $FileLfCyc = 'Törölt';
                } else {
                    $FileLfCyc = '';
                }
                if ($detailId['files'][0]['checkedOut'] === true) {
                    $checkedOut = '✔';
                } else {
                    $checkedOut = '✖';
                }

                $item['detail'] = array(
                    array('name' => 'Név', 'value' => $detailId['files'][0]['name']),
                    array('name' => 'FileLfCyc', 'value' => $FileLfCyc),
                    array('name' => 'Comm', 'value' => $detailId['files'][0]['comm']),
                    array('name' => 'CheckedOut', 'value' => $checkedOut),
                    array('name' => 'Datum', 'value' => substr(str_replace('T', '   ', $detailId['files'][0]['ckInDate']), 0, 18)),
                    array('name' => 'Detail', 'value' => $detail),
                    array(
                        'name' => 'image',
                        'value1' => $detailId['files'][0]['id'],
                        'value2' => $detailId['files'][1]['id'],
                    ),
                );
            } else {
                $item['detail'] = array(
                    array('name' => 'Név', 'value' => $detailId['files'][0]['name']),
                    array('name' => 'FileLfCyc', 'value' => $FileLfCyc),
                    array('name' => 'Comm', 'value' => $detailId['files'][0]['comm']),
                    array('name' => 'CheckedOut', 'value' => $checkedOut),
                    array('name' => 'Datum', 'value' => substr(str_replace('T', '   ', $detailId['files'][0]['ckInDate']), 0, -3)),
                    array(
                        'name' => 'image',
                        'value1' => $detailId['files'][0]['id'],
                        'value2' => $detailId['files'][1]['id'],
                    ),

                );
            }
        } else {
            $item['detail'] = null;
        }
    } else {
        $item['sapOrder'] = null;
        $item['detail'] = null;
    }
} else {
    $item = null;
}

$final = json_encode($item);
echo $final;
