<?php
/*
 * Author : yamamoto
 * create date : 2013/01/22
 * update date :
 */
 require("loginTable.php");
 $a = new loginTbl();
 $a->set_item($a->_name, "yyyy");
 echo "<br>-". $a->get_item($a->_name);
 echo "<br>-". date("yyyy/mm/dd hh", $a->get_item($a->_pass));
?>
