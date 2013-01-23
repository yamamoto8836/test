<?php
/*
 * Author : yamamoto
 * create date : 2013/01/22
 * update date :
*/

	require_once("define.php");

	function __autoload($class_name) {
    	include $class_name . '.php';
	}

	$login = new LoginTable();
	$db = new Pdo($_dns, _writeUser, _writeUserPass);
	if ($db->get_conn() === null){
		echo "open error";
		return;
	}

	$login->set_item($_login_name, "x1234567");
	$login->set_item($_login_pass, "abcdef");
	if ($login->insert($db, array($_login_name, $_login_pass))){
		print_r($db->get_exception());
	}else{
		print_r($db->get_errorInfo());
	}
?>
