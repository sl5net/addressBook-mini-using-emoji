<?php
require '../header/headerFormUser.php';
require 'formHelper.php';
echo "<h3>Search User</h3>
it is a OR condition.
empty fields are not considered.<br>";

if(isset($_GET['sortBy'])) {
    $sortBy = $_GET['sortBy'];
    unset($_GET['sortBy']);
}else $sortBy = '';

$cleanVal = null;
$dataIn = ($_POST) ? : $_GET;
foreach ($dataIn as $key => $val) {
    try {
        $cleanVal[$key] = secureFormValue($key, $dataIn[$key], true, $isDebug);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
$dataIn = $cleanVal;
require '../formContact/formEmpty.php';
require '../dbStuff.php';

if($cleanVal)
    $cleanValNotEmpty=array_filter($cleanVal, function($value) { return !is_null($value) && $value !== ''; });

$sqlResult = dbStuff::selectFromAddressBook($cleanVal, $cleanValNotEmpty, $sortBy, $conn, $isDebug);

$link = '';
foreach (['id','name','phone','city','comment'] as $val) {
    $encodeVal = urlencode(base64_encode($val));
    $link .= "|   sort by <a href='?sortBy=$encodeVal'>$val 🔽</a>";
    $link .= "<a href='?sortBy=$encodeVal&orderDesc'>🔼</a>";
}
echo $link . '<br>';

while ($row = $sqlResult->fetch_assoc()){
    echo "| ";
    $encodeValID = urlencode(base64_encode($row['id']));
    foreach ($row as $key=> $val) {
        $encodeVal = urlencode(base64_encode($val));
        echo "$key =  $val";
        echo "<a href='searchUser.php?$key=$encodeVal'>🔍</a>";
        echo "<a href='deleteUsers.php?$key=$encodeVal'>❌</a>";
        echo "<a href='update1User.php?id=" . $encodeValID . "'>✏️</a>";
        echo "|";
    }
    echo '<hr>';
}