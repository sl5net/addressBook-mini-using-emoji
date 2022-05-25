<?php
# default $isDebug false
require '../header/headerFormContact.php';
require 'formHelper.php';
require 'formFullWithCrazyDefaults.html';

foreach ($_POST as $key => $val) {
    try {
        $cleanVal[$key] = secureFormValue($key, $_POST[$key], false, $isDebug);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
require '../dbStuff.php';

if(!$_POST)
    die('noting Submitted');


$cleanVal['user_id'] = $_SESSION['user']['id'];
dbStuff::addContact2DB($cleanVal, $conn, $isDebug );
