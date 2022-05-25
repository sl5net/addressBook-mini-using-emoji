<?php
session_start();
require '../config/error_reporting.php';
if (isset($_SESSION['user'])) {
    require '../header/headerFormUser.php';
} else {
    include '../header/headerTitleLocalhost.html';
}

if ($_SESSION['guest']) {
    $dateNow = date('Y-m-d H:i:s');
    $timeDiffInSeconds = strtotime($dateNow) - strtotime($_SESSION['guest']['visitedAt']);
    $_SESSION['guest']['visitedAt'] = $dateNow;
    $minAllowedTimeForRevisitAsGuest = 10;

    #echo "<br>last load as Guest " . $timeDiffInSeconds . ' seconds<br>';
    if ($timeDiffInSeconds < $minAllowedTimeForRevisitAsGuest) {
        # unset($_SESSION['guest']);
    }
}

if (isset($_POST['product']) && $_POST['product'] > 0 && $_POST['product'] == $_SESSION['guest']['product'])
    $_SESSION['guest']['isHuman'] = true;

if (!isset($_SESSION['guest']['isHuman'])) {
    echo '<pre><h3>a little task first please</h3>';

    $matrix = array(0 => [rand(1, 4), rand(1, 4), rand(1, 4)], 1 => [rand(1, 4), rand(1, 4), rand(1, 4)]);
    echo implode($matrix[0]) . "\n";
    echo implode($matrix[1]) . "\n";
    $m1 = rand(1, 3);
    $m2 = rand(1, 3);
    echo "\nwhats\n";
    $firsMulitTextNr = rand(0, 1);
    $secondMulitTextNr = ($firsMulitTextNr == 1) ? 0 : 1;
    $multiText[0] = "the multiplication of the $m1'th number in the first row";
    $multiText[1] = "the multiplication of the $m2'th number in the second row";
    echo $multiText[$firsMulitTextNr] . "\n";
    echo "and the\n";
    echo $multiText[$secondMulitTextNr] . "\n";
    echo "?\n\n\n";
    $product = $matrix[0][$m1 - 1] * $matrix[1][$m2 - 1];
    $_SESSION['guest']['product'] = $product;
    ?>
    <form method="post">
        <input type="text" name="product" required>
        <input type="submit" value="submit product">
    </form>
    <?php
    die();
}
echo "<pre>\n";
echo "
";
require 'formHelper.php';
echo "<h3>➕register as User</h3>";

require 'formFullWithCrazyDefaults.html';

foreach ($_POST as $key => $val) {
    try {
        $cleanVal[$key] = secureFormValue($key, $_POST[$key], false, $isDebug);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
require '../dbStuff.php';

if (!$_POST)
    die('noting Submitted');

# unset($_SESSION['guest']);

$dataIn = $_POST;
foreach ($dataIn as $key => $val) {
    try {
        $cleanVal[$key] = secureFormValue($key, $dataIn[$key], false, $isDebug);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

//var_export($cleanVal);

dbStuff::addUser2DB($cleanVal, $conn, true); # $isDebug);
$mysqli_error = mysqli_error($conn);
$mysqli_affected_rows = mysqli_affected_rows($conn);
echo "\nmysqli_affected_rows=" . $mysqli_affected_rows ."\n";
if($mysqli_affected_rows==1){
    # now its a new user
    unset($_SESSION['guest']);
//    header("Location: ../index.php");
    echo '<a href="login.php">login.php</a>';
    header("Location: ./login.php");
    die();
}


//echo "mysqli_affected_rows=" . mysqli_affected_rows($conn);
if ($mysqli_error) {
    echo 'mysqli_error= ' . $mysqli_error;
}


