<?php
$conn = dbStuff::getConnect();
class dbStuff
{

    /**
     * @return false|mysqli
     */
    public static function getConnect()
    {
        $c = mysqli_connect(
            'localhost',
            'root',
            '',
            'db_a_book',
            3306);
        if (!$c) {
            die("Connection Failed:" . mysqli_connect_error());
        }
        return $c;
    }

    /**
     * @param $cleanVal
     * @param $cleanValNotEmpty
     * @param $sortBy
     * @param mysqli $conn
     * @return array
     */
    public static function selectFromAddressBook($cleanVal, $cleanValNotEmpty, $sortBy, mysqli $conn, $isDebug)
    {
        if (!isset($cleanVal) || count($cleanValNotEmpty) == 0)
            $sqlQuery = 'select * from address_book';
        else {
            $selectFromAddressBook1 = 'select * from address_book ';
            $selectFromAddressBook1 .= ' where user_id = ' . $cleanVal['user_id'];
            unset($cleanVal['user_id']);
            $sqlQuery = $selectFromAddressBook1;
            if (count($cleanVal)) {
                $selectFromAddressBook1 .= ' AND ';
                $cleanVal = array_filter($cleanVal, function ($value) {
                    return !is_null($value) && $value !== '';
                });

                $sqlQueryKeyLikeVal = '';
                foreach ($cleanVal as $key => $val) {
                    $sqlQueryKeyLikeVal .= $key . " like '%$val%' or ";
                }
                $sqlQueryKeyLikeVal = substr($sqlQueryKeyLikeVal, 0, -strlen('or '));
                $sqlQuery .= ' AND ( ' . $sqlQueryKeyLikeVal . ' ) '; # $sqlQueryValues;
            }
        }
        if ($sortBy)
            $sqlQuery .= " order by " . $sortBy . ((isset($_GET['orderDesc'])) ? ' DESC ' : '');
        $sqlResult = $conn->query($sqlQuery);
        if ($sqlResult) {
//    echo "<hr>successfully !";
        } elseif ($isDebug)
            echo "<hr>NOT successfully !";

        if ($isDebug) {
            echo "<hr>$sqlQuery \n";
        }

        return $sqlResult;
    }

    /**
     * @param $cleanVal
     * @param mysqli $conn
     * @param $isDebug
     * @return void
     */
    public static function addContact2DB($cleanVal, mysqli $conn, $isDebug)
    {
        $sqlQueryKeys = 'INSERT INTO address_book (name,phone,city,comment,user_id) ';
        $sqlQueryValues = sprintf("VALUES('%s','%s','%s','%s',%s)"
            , $cleanVal['name']
            , $cleanVal['phone']
            , $cleanVal['city']
            , $cleanVal['comment']
            , $cleanVal['user_id']
        );
        $sqlQuery = $sqlQueryKeys . $sqlQueryValues;
        if (mysqli_query($conn, $sqlQuery)) {
            echo "<hr>inserted successfully !";
        } elseif ($isDebug)
            echo "<hr>NOT inserted successfully !";
        if ($isDebug) {
            echo "<hr>$sqlQuery \n";
            $mysqli_error = mysqli_error($conn);
            if ($mysqli_error) {
                echo 'mysqli_error= </pre>' . $mysqli_error;
            }
        }
    }

    public static function addUser2DB($cleanVal, mysqli $conn, $isDebug)
    {
        $sqlQueryKeys = 'INSERT INTO user (name,password) ';
        $sqlQueryValues = sprintf("VALUES('%s','%s')"
            , $cleanVal['name']
            , hash('sha512', $cleanVal['password']));
        $sqlQuery = $sqlQueryKeys . $sqlQueryValues;
        if (mysqli_query($conn, $sqlQuery)) {
            echo "<hr>inserted successfully !";
        } elseif ($isDebug)
            echo "<hr>NOT inserted successfully !";
        if ($isDebug) {
            $mysqli_error = mysqli_error($conn);
            if ($mysqli_error) {
                echo 'mysqli_error= ' . $mysqli_error;
            }
        }
    }

    /**
     * @param mysqli $conn
     * @param $sqlQuery
     * @param $isDebug
     * @return void
     */
    public static function deleteContactsFromAddressBook(mysqli $conn, $cleanVal, $ignoreDeletIfAllValsEmpty, $isDebug)
    {
        if (!isset($cleanVal) )
            return null;

        $sqlDeleteRowFromAddressBook1 = 'delete from address_book ';
        $sqlDeleteRowFromAddressBook1 .= ' where user_id = ' . $cleanVal['user_id'];
        unset($cleanVal['user_id']);

        $cleanVal=array_filter($cleanVal, function($value) { return !is_null($value) && $value !== ''; });
        if($ignoreDeletIfAllValsEmpty && !count($cleanVal))
            return null;
        $sqlQueryKeyLikeVal = '';
        foreach ($cleanVal as $key => $val) {
            $sqlQueryKeyLikeVal .= $key . " like '%$val%' OR ";
        }
        $sqlQueryKeyLikeVal = substr($sqlQueryKeyLikeVal,0, -strlen('or '));
        $sqlQuery = $sqlDeleteRowFromAddressBook1;
        if(count($cleanVal))
            $sqlQuery .= ' and ( ' . $sqlQueryKeyLikeVal . ' ) ';


        if (mysqli_query($conn, $sqlQuery)) {
//            echo "<hr>successfully !";
        } elseif ($isDebug)
            echo "<hr>NOT successfully !";

        if ($isDebug) {
            echo "<hr>$sqlQuery \n";
            $mysqli_error = mysqli_error($conn);
            if ($mysqli_error) {
                echo 'mysqli_error= ' . $mysqli_error;
            }
        }
    }

    /**
     * @param $idSecure
     * @param mysqli $conn
     * @param $isDebug
     * @return bool|mysqli_result
     */
    public static function get1userFromDbById($idSecure, mysqli $conn, $isDebug)
    {
        $sqlQuery = 'select * from address_book where id=' . $idSecure;
        $sqlResult = $conn->query($sqlQuery);
        if ($isDebug) {
            echo "<hr>$sqlQuery \n";
        }
        $dataIn = null;
        while ($row = $sqlResult->fetch_assoc()) {
            $dataIn = $row;
            break;
        }
        return $dataIn;
    }

    public static function getUserIdThatMatchNamPassword($nameSecure, $passwordSecure, mysqli $conn, $isDebug)
    {
        $shaPass = hash('sha512', $passwordSecure);

        $sqlQuery = "select id from user where name like '$nameSecure' and password like '$shaPass'";
        $sqlResult = $conn->query($sqlQuery);
        $row = $sqlResult->fetch_assoc();
        return $row['id'];
    }

    public static function isPasswordCorrect($id, $password, mysqli $conn, $isDebug)
    {
        $shaPass = hash('sha512', $password);
        $sqlQuery = "select id from user 
          where id = $id
          and password like '$shaPass'";
        $sqlResult = $conn->query($sqlQuery);
        $row = $sqlResult->fetch_assoc();
        echo $row;
        return $row['id'];
    }

    /**
     * @param $cleanVal
     * @param array $idSecure
     * @param $isDebug
     * @param mysqli $conn
     * @return mixed
     */
    public static function updateAddressBookInDB($cleanVal, $idSecure, $isDebug, mysqli $conn)
    {
        $sqlQueryUpdate = 'update address_book set ';
        foreach ($cleanVal as $key => $val) {
            if ($key == 'id')
                continue;
            $sqlQueryUpdate .= " $key = '$val',";
        }
        $sqlQueryUpdate = substr($sqlQueryUpdate, 0, -1);
        $sqlQueryUpdate .= ' where id = ' . $idSecure;
        if ($isDebug)
            echo '<br>' . $sqlQueryUpdate;
        $conn->query($sqlQueryUpdate);
        return $conn->query($sqlQueryUpdate);
    }

    public static function updateUserPassword($password, $id, $isDebug, mysqli $conn)
    {
        $sqlQueryUpdate = 'update user set ';
        $sqlQueryUpdate .= " password = '$password' ";
        $sqlQueryUpdate .= ' where id = ' . $id;
        if ($isDebug)
            echo '<br>' . $sqlQueryUpdate;
        return $conn->query($sqlQueryUpdate);
    }

    public static function deleteUser($id, $isDebug, mysqli $conn)
    {
        $sql = "delete from user where id = $id;";
        if ($isDebug)
            echo '<br>' . $sql;
        return $conn->query($sql);
    }
}

