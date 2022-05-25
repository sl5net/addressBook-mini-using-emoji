<?php
# default $isDebug false
require '../header/headerFormUser.php';
require 'formHelper.php';
echo "<h3>❌ delete me (and all my contact entries)</h3> 
";

$dataIn = $_POST;
foreach ($dataIn as $key => $val) {
    try {
        $cleanVal[$key] = secureFormValue($key, $dataIn[$key], false, $isDebug);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
//echo var_export($dataIn);
//require '../formContact/formEmpty.php';

if ($_GET)
    die('update not with get data');

require '../dbStuff.php';

if(!empty($_POST['passwordOld'])) {
    if ($_POST['passwordOld'] == $_POST['password'])
        echo ' you typed the same password again. nothing changed.';
    else {
        $echoUpdated = "not updated";
        if (dbStuff::isPasswordCorrect($_SESSION['user']['id'], $_POST['passwordOld'], $conn, $isDebug)) {

//        if (dbStuff::updateUserPassword($_POST['password'], $_SESSION['user']['id'], $isDebug, $conn)) {
            if (dbStuff::deleteUser($_SESSION['user']['id'], $isDebug, $conn)) {
                $echoUpdated = "is updated";
                unset($_SESSION['user']);
                header("Location: ../index.php");
            }
        }
    }
}
//dbStuff::setPasswordCorrect($_SESSION['user']['id'],$_GET['password'],$conn,$isDebug);

?>
<form method="post">
    password : <input type="password" name="passwordOld" value="9duff_" required> please type password again for
    security reasons.
    <input type="submit" name="login" value="update"> <input type="reset">
</form>
