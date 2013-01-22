<?php
/*
 * Author : yamamoto
 * create date : 2013/01/22
 * update date :
*/
//DataBase
//User
define("_readUser", "reader");
define("_readUserPass", "reader");
define("_writeUser", "writer");
define("_writeUserPass", "writer");

//DNS
$_dns = array();
$_dns["dbtype"] = "mysql";
$_dns["host"] = "localhost";
$_dns["dbname"] = "test";
$_dns["user"] = _readUser;
$_dns["password"] = _readUserPass;
$_dns["charset"] = "utf8";
//login table
$_login_name = "name";
$_login_pass = "pass";


?>