<?php 
die();?><?php 
require 'header/headerTitleLocalhost.html';
echo 3;
error_reporting(E_ALL);
$isDebug = true;

require 'dbStuff.php';
echo 4;
//$sqls[] = <<<'EOF'
//create database address_book5;
//EOF;
//$sqls[] = <<<'EOF'
//use `address_book5`;
//EOF;
$sqls[] = <<<'EOF'
CREATE TABLE if not exists `user`
(
    `id`    int(11) primary key NOT NULL AUTO_INCREMENT,
    `name`  varchar(255)        NOT NULL UNIQUE CHECK (user.name <> ''),
    `password`  varchar(255)        NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;
EOF;
$sqls[] = <<<'EOF'
CREATE TABLE if not exists `address_book`
(
    `id`    int(11) primary key NOT NULL AUTO_INCREMENT,
    `name`  varchar(255)        NOT NULL  CHECK (address_book.name <> ''),
    `phone` varchar(255)        default '' CHECK ( address_book.phone  REGEXP '^[0-9]+$' ),
    `city`  varchar(255)        default '',
    `comment`   text            default '',
    `user_id` int(11),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
        ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;
EOF;

$sqls[] = <<<'EOF'
insert into user (name, password) values ('Alph','9duff_') -- first user
EOF;

echo 7;
foreach ($sqls as $sql) {
    if (mysqli_query($conn, $sql)) {
        if ($isDebug)
            echo "<hr>successfully !";
    } elseif ($isDebug)
        echo "<hr>NOT successfully !";
}

<<<'EOF'
use test
drop table address_book
# select * from address_book where id=4 order by name
# update address_book set ()
# update address_book set name = '',phone = '4924',city = 'Berlin',comment = 'hiHo Du Nase.' where id = 7
# delete from address_book where comment like 'hiHo Du Nase.'
EOF;
echo 9;
?>
