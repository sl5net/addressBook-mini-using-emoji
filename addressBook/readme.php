<?php
session_start();
include 'header/headerTitleLocalhost.html'
?>
<a href="index.php">index.php</a>;
<hr><pre>
# literal task description from 17.05.2022
(PHP) Task:
    Build a simple AddressBook where
    a user can
        add/edit/delete addressBook entries,
        sort them by name, phone number, city, etc.
Its NOT allowed to
    use ANY framework or
    other peoples code.
A good frontend design is not needed. Security is a topic.
<hr>

# my answers
1. I did the addressBook as simple as possible.
2. frontend design not important. I used
	1. less html-tags as possible.
		1. for Design i use mainly the PRE-Tag.
	2. no CSS
	3. no images, but emojis

at many places i tried to the security aspect as good as possible.

# howTo use it:
    0. delete line addressBook/sql4installation.sql.php:2 if its "die();?>..." for reactivate this PHP-File
    1. config MariaDb-dataBase (user,pas,dbName,port) access at:
    addressBook/dbStuff.php:14
        means pls create a db if you dont have (default in config is: db_a_book )
    2. visit addressBook via Web-Browser
    3. visit addressBook via Web-Browser
    4. register as User or use the default-User (for demonstration already inserted and set as default nearly everywhere)

Todo:
- encrypt more values into db (not only the password).
- super-admin that could delete some User's
- maximum page size (limit sql select).
- pages to turn
- discuss how to prevent the hard disk space from running out.


```html
    <!--    <a href="../formUser/deleteUsers.php">delete some User's</a>-->
    <!--    <a href="../formUser/searchUser.php">search User</a>-->
    <!--    <a href="../formUser/searchUser.php?name=--><?php //echo urlencode(base64_encode('Alph'));?><!--">search User Alph</a>-->
```

- [ ] AddressBook
	- [ ] user can entries
		- [x] add
		- [x] edit
		- [x] delete
		- [ ] sort them by
			- [x] name
			- [x] phone number
			- [x] city
			- [x] etc.
must
- [x] NOT use framework
- [x] design not needed
- [ ] Security is a topic. [[php secure]]
	- [ ] ????
	- [ ] timout ?? logout??

