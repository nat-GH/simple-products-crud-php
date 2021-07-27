<?php

include_once 'database.php';

if(!isset($_POST['produto']) || !isset($_POST['produtoId']) || !isset($_POST['valor'])) {
    http_response_code(422);
    echo json_encode('É necessário informar todos os campos do produto!');
    exit();
}

$con = open_database();
$produtoId = $_POST['produtoId'];
$produto = $_POST['produto'];
$valor = $_POST['valor'];

$sql = "UPDATE produtos SET produto = '$produto', valor = '$valor' WHERE (id = $produtoId)";

$result = mysqli_query($con, $sql);

if ($result) {
    echo json_encode(true);
} else {
    http_response_code(500);
    echo json_encode(null);
}

close_database($con);
