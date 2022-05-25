<?php
session_start();
require '../config/error_reporting.php';
if(isset($_SESSION['user'])) {
    $_SESSION['user'] ['visitedAt'] = '';
    require '../header/headerFormUser.php';
    echo '<a href="../index.php">index.php</a>';
    header("Location: ../index.php");
} else {
    error_reporting(E_ALL);
    require '../dbStuff.php';
    error_reporting(E_ALL);
    if($_POST){
        $idUser = dbStuff::getUserIdThatMatchNamPassword($_POST['name'], $_POST['password'], $conn, @$isDebug);
        if($idUser){
            $_SESSION['user']['id'] = $idUser;
            $_SESSION['user']['visitedAt'] = date('Y-m-d H:i:s');
            unset($_SESSION['guest']);
            echo "<a href='../index.php'>too index️</a><pre>";
        }
    }
    usleep(1000); # maybe helps a bit vs bruit force attack by noobs

    require '../header/headerTitleLocalhost.html';

    $dateNow = date('Y-m-d H:i:s');
    if (!isset($_SESSION['guest'])) {
        $_SESSION['guest'] ['visitedAt'] = '';
    }
    $timeDiffInSeconds = strtotime($dateNow) - strtotime($_SESSION['guest']['visitedAt']);
    $_SESSION['guest']['visitedAt'] = $dateNow;
    $minAllowedTimeForRevisitAsGuest = 2;

    echo "<br>last load of a AddressBook pages for " . $timeDiffInSeconds . ' seconds<br>';
    if ($timeDiffInSeconds < $minAllowedTimeForRevisitAsGuest) {
        ?>
        Could i ask you a question first? What you like most at this page?
        <form method="post">
        <input name="password" type="hidden">
        <input name="question" required>
        <input value="question" type="submit">
        </form>
            <?php
        die('');
    }
    ?>
    <pre>
    <?php
    if (!isset($_SESSION['user'])) {
        ?>
        <form method="post">
          name        : <input name="name"  value="Alph" required> only unique names. only text no numbers or so
          password    : <input name="password" value="9duff_" required> use only numbers, word or underscore (\d\w_)
          <input type="submit" name="login" value="login"> <input type="reset" value="reset to Crazy Defaults">
        </form>
        <?php
    }
}