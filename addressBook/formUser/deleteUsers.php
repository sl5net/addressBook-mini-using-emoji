<?php
# default $isDebug false
require '../header/headerFormUser.php';
require 'formHelper.php';
echo "<h3>❌ Delete !!ALL!! Matching User's !! - 
1. NO sql % Wildcards => will be ignored. 
2. needs to Press the submit button</h3>
it is a OR condition.
empty fields are not considered.
";

$dataIn = ($_POST) ? : $_GET;
foreach ($dataIn as $key => $val) {
    try {
        $cleanVal[$key] = secureFormValue($key, $dataIn[$key], true, $isDebug);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
//echo var_export($dataIn);
require '../formContact/formEmpty.php';

if(!$_POST)
    die('delete only by submit by post method');

require '../dbStuff.php';


dbStuff::deleteContactsFromAddressBook($conn, $sqlQuery, $isDebug);


