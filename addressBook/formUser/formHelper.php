<?php

/**
 * @param $key
 * @param $val
 * @param $isWithNoDBNames for example some fancy get parameters
 * @param $isDebug
 * @return array|string|string[]|null
 * @throws Exception
 */
function secureFormValue($key, $val, $isWithNoDBNames = false, $isDebug = false)
{
    if ($isWithNoDBNames) {
        echo $key;
        throw new \Exception('1: not allowed');
    }
    $len1 = strlen($val);
    switch ($key) {
        case 'name':
            $val = preg_replace('/[\d\W]+/', '', $val);
            break;
        case 'password':
        case 'passwordOld':
            $val = preg_replace('/[^\d\w_]+/', '', $val);
            break;
        case 'login':
            $val = ''; # value of this not needed to be stored
            break;
        default:
            if ($isDebug)
                echo "$key=$val";
            throw new \Exception('2: Unexpected value');
    }
    $lenClean = strlen($val);
    if ($lenClean != $len1) {
        echo "cool funny input style. ";
        if ($key == 'comment')
            echo 'please simplify you comment a bit.';
    }
    return $val;
}
