<?php
session_start();
require "header/headerTitleLocalhost.html";
?>
<ol>
    <li><a href="formUser/addUser.php">➕register as User</a>
    </li>
    <li><a href="header/headerFormUser.php">go to User Menu</a>
    </li>
    <li><a href="header/headerFormContact.php">go to Manage Contacts</a>
    </li>
</ol>
</li>
<?php
$fileName = 'sql4installation.sql.php';
require $fileName;
usleep(100);
$fileStr = "<?php \ndie();?>";
$fileStr .= file_get_contents($fileName);
file_put_contents($fileName, $fileStr);
echo "<h1>recommended:</h1>
<ol>
    <li>backup $fileName</li>
    <li>delete $fileName</li>
</ol>
";
?>


