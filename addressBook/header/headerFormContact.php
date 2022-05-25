<pre>
<?php
session_start();
require '../config/error_reporting.php';
//var_export($_SESSION);
if (isset($_SESSION['user'])) {
    echo 'SESSION EXIST';
    $dateNow = date('Y-m-d H:i:s');
    if (isset($_SESSION['user']['visitedAt'])) {
        $timeDiffInSeconds = strtotime($dateNow) - strtotime($_SESSION['user']['visitedAt']);
        echo "<br>last load of a AddressBook pages for " . $timeDiffInSeconds . ' seconds';
        $maxAllowedTimeForRevisitWithoutLoginAgain = 5 * 60;
//        $maxAllowedTimeForRevisitWithoutLoginAgain = 1;
        echo "\n maxAllowedTimeForRevisitWithoutLoginAgain = $maxAllowedTimeForRevisitWithoutLoginAgain seconds";
        if ($timeDiffInSeconds > $maxAllowedTimeForRevisitWithoutLoginAgain) {
            unset($_SESSION['user']);
            echo "\n you need login first.";
            echoSessionNotExist();
        }
    }
    $_SESSION['user']['visitedAt'] = $dateNow;

    // urldecode dont woks as expected. so i disable it for the moment (22-0518_1151-14).
    foreach ($_GET as $key => $val)
        $_GET[$key] = base64_decode(urldecode($val));
//        $_GET[$key] = urldecode($val);

} else {
    echoSessionNotExist();
}

function echoSessionNotExist()
{
    echo 'SESSION not EXIST';
    if (weAreInReadmeFile()) {
        ?>
        <a href="formUser/login.php">login🔑</a>
        <?php
    } else {
        {
            ?>
            <a href="../formUser/login.php">login🔑</a>
            <?php
        }
    }
    die();
}

require 'headerTitleLocalhost.html';
$isDebug = false;
if ($_SERVER["HTTP_HOST"] == "localhost") {
    $isDebug = true;
    echo 'debug: ';
    echo $_SERVER["SCRIPT_NAME"];
    echo '<br>';
}
/**
 * @return false|int
 */
function weAreInReadmeFile()
{
    return preg_match('/\breadme\.php\b/', $_SERVER["SCRIPT_NAME"]);
}

if (weAreInReadmeFile())
{
    echo '<a href="../formContact">index</a>';
}else{
?>
    <a href="../formContact/addContact.php">➕add Contact</a>
    <a href="../formContact/deleteUsers.php">❌delete some Contact's</a>
    <a href="../formContact/searchUser.php">🔍search User</a>
    <a href="../formContact/searchUser.php?name=<?php echo urlencode(base64_encode('Alph'));?>">🔍search User Alph</a>
    <a href="../formContact/logout.php">🔐logout</a>
    <a href="../">index</a>
    <a href="../readme.php">readme</a>
<?php
}