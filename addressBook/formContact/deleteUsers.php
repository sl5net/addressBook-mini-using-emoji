<?php
# default $isDebug false
require '../header/headerFormContact.php';
require 'formHelper.php';
echo "<h3>Delete !!ALL!! Matching contact's !! - 
1. be careful: its using sql % Wildcards 
2. needs to Press the submit button
3. sending empty form has no effect. does not delete all your contacts</h3>
it is a AND condition.
empty fields are not considered.

";

$dataIn = ($_POST) ? : $_GET;
foreach ($dataIn as $key => $val) {
    try {
        $cleanVal[$key] = secureFormValue($key, $dataIn[$key], false, $isDebug);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
//echo var_export($dataIn);
require '../formContact/formEmpty.php';

if(!$_POST)
    die('delete only by submit by post method');

require '../dbStuff.php';

$cleanVal['user_id'] = $_SESSION['user']['id'];

dbStuff::deleteContactsFromAddressBook($conn, $cleanVal, $ignoreDeletIfAllValsEmpty=true, $isDebug);


