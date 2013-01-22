<?php
/*
 * Author : yamamoto
 * create date : 2013/01/22
 * update date :
 */
 require("loginTable.php");
 echo "xx";
 $a = new loginTbl();
 $a->set_item($a->_name, "yyyy");
 echo $a->name;
?>
