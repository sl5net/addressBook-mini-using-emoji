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
    $len1 = strlen($val);

    switch ($key) {

        case in_array($key, ['name', 'city']):
            $val = preg_replace('/[\d\W]+/', '', $val);
            break;
        case in_array($key, ['phone','id']): // BTW phone will also be proved later in the SQL. Doppelt hält besser :) Auch mal so als Beispiel halt.
            $val = preg_replace('/[\D]+/', '', $val);
            break;
        case 'comment':
            $val = preg_replace('/[^\w\.\!?\s]+/', '', $val);
            break;
        default:

            if ($isWithNoDBNames) {
                switch ($key) {
                    case in_array($key, ['orderDesc']):
                        $val = ''; # ok as urlPara and dont need a value
                        break;
                    default:
                        if ($isDebug)
                            echo "$key=$val";
                        throw new \Exception('1: Unexpected value');
                }
            }
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
