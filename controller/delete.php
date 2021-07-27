<?php

include_once 'database.php';

if(!isset($_POST['produtoId'])) {
    echo json_encode('É necessário informar o ID do produto!');
    exit();
}

$con = open_database();
$produtoId = $_POST['produtoId'];

$sql = "delete from produtos where id = $produtoId";
mysqli_query($con, $sql);
if (mysqli_affected_rows($con) > 0) {
    echo json_encode(true);
} else {
    http_response_code(500);
    echo json_encode(null);
}

close_database($con);
