<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set('Europe/Budapest');
$_POST = json_decode(file_get_contents("php://input"), true);
$link = mysqli_connect('192.168.4.11', 'pancho', 'P6ncH0@W3bD3V', 'TMES');

//login

if ($_POST["type"] === 'login') {

    $query = 'SELECT * FROM cardUser WHERE number="' . $_POST["number"] . '" limit 1';
    $result = $link->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
    }

    if (isset($id)) {
        echo 'admin';
    } else {
        echo '';
    }
}

//view

if ($_POST["type"] === 'get') {

    $query = 'SELECT * FROM cardUser';
    $result = $link->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $dataCard[] = array(
            'id' => (int)$row['id'],
            'number' => (int)$row['number']
        );
    }

    $final = json_encode($dataCard);
    echo $final;
}

//modify
if ($_POST["type"] === 'put') {
    $query = 'SELECT * FROM cardUser WHERE number="' . $_POST["number"] . '" limit 1';
    $result = $link->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
    }
    if (isset($id)) {
        echo 'exist';
    } else {
        $numberUpdate = $_POST["number"];
        $idUpdate = $_POST["id"];
        $update = "UPDATE cardUser SET number='$numberUpdate' WHERE id='$idUpdate'";
        if ($link->query($update) === TRUE) {
            echo "change";
        } else {
            echo "Error_connection";
        }
    }
}
//ADD

if ($_POST["type"] === 'post') {
    $query = 'SELECT * FROM cardUser WHERE number="' . $_POST["number"] . '" limit 1';
    $result = $link->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
    }
    if (isset($id)) {
        echo 'exist';
    } else {
        $numberNew = (int) $_POST["number"];
        $sql = "INSERT INTO cardUser (number) VALUES ('$numberNew')";
        if (mysqli_query($link, $sql)) {
            echo 'new_number';
        } else {
            echo "Error_connection";
        }
    }
}

//DELETE
if ($_POST["type"] === 'delete') {
    $idDelete = (int)$_POST['id'];
    $queryDelete = "DELETE FROM cardUser where id = $idDelete ";
    $resultDelete = $link->query($queryDelete);
    if ($resultDelete === TRUE) {
        echo 'deleted';
    } else {
        echo "Error_connection";
    }
}
