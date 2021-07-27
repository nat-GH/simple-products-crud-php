<?php

include_once 'database.php';

function listAll()
{
    $con = open_database();

    $sql = "select * from produtos";

    if ($result = mysqli_query($con, $sql)) {
        $dataArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $dataArray;
    } else {
        return null;
    }

    close_database($con);
}
