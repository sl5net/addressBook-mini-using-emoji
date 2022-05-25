<?php
# default $isDebug false
require '../header/headerFormContact.php';
require 'formHelper.php';
$key = 'id';
$idSecure = secureFormValue($key, $_GET[$key], true, $isDebug);
echo "<h3>Update only one User with ID</h3>
";
if(!$idSecure)
    die('missing id');

require '../dbStuff.php';


if($_POST) {
    foreach ($_POST as $key => $val) {
        try {
            $cleanVal[$key] = secureFormValue($key, $_POST[$key], false, $isDebug);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    $idSecure = dbStuff::updateAddressBookInDB($cleanVal, $idSecure, $isDebug, $conn);
}

$dataIn = dbStuff::get1userFromDbById($idSecure, $conn, $isDebug);
require ('formEmpty.php');