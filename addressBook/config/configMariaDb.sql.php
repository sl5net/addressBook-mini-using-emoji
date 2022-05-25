<?php
function getConnectMariaDb()
{
    $c = mysqli_connect(
        'localhost',
        'root',
        '',
        'address_book5',
        3306);
    return $c;
}
