<?php
/*
 * Author : yamamoto
 * create date : 2013/01/22
 * update date :
*/

function __autoload($class_name) {
   	include $class_name . '.php';
}

//DataBase
//User
define("_pdo_readUser", "reader");
define("_pdo_readUserPass", "reader");
define("_pdo_writeUser", "writer");
define("_pdo_writeUserPass", "writer");

//DNS
define("_pdo_dbtype", "mysql");
define("_pdo_host" , "localhost");
define("_pdo_dbname", "test");
define("_pdo_charset", "utf8");

//login table
define("_login_name", "name");
define("_login_pass" , "pass");



//

?>