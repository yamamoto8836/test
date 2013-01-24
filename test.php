<!DOCTYPE html>
<meta charset="UTF-8">
<?php
/*
 * Author : yamamoto
 * create date : 2013/01/22
 * update date :
*/

	require_once("define.php");

	$login = new LoginTable();
	$db = new DB(_pdo_dbtype, _pdo_host, _pdo_dbname, _pdo_charset, _pdo_writeUser, _pdo_writeUserPass);
	if ($db->get_conn() === null){
		echo "open error";
		return;
	}


	$login->set_item(_login_name, "a1234567");

	$login->set_item(_login_pass, "abcde");

	if ($login->insert($db, array(_login_name, _login_pass))){
		echo "追加しました";
	}else{
		if ($db->get_count() == -2){
			echo "登録済みです";
		}else{
			echo "追加に失敗しました";
			var_dump($db->get_exception());
		}

	}

?>
