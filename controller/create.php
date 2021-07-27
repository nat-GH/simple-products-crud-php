<?php

include_once 'database.php';

if(!isset($_POST['produto']) || strlen($_POST['produto']) == 0 || !isset($_POST['valor'])) {
    http_response_code(422);
    echo json_encode('É necessário informar todos os campos do produto!');
    exit();
}

$con = open_database();
$produto = $_POST['produto'];
$valor = $_POST['valor'];

$sql = "INSERT INTO produtos (`produto`, `valor`) VALUES ('$produto', '$valor')";

mysqli_query($con, $sql);
if (mysqli_affected_rows($con) > 0) {
    $productId = mysqli_insert_id($con);
    echo json_encode($productId);
} else {
    http_response_code(500);
    echo json_encode(null);
}

close_database($con);
