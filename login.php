<?php
// author yamamoto

 	require_once("define.php");

 	$errmsg = array();
	$name = "";

//GET呼び出しなら、入力画面表示
	if ($_SERVER["REQUEST_METHOD"] == "GET"){
		screen($errmsg, "");
		return;
	}

//POST呼び出し
//入力値の取り出しとチェック
	$name = $_POST[_login_name];
	$pass = $_POST[_login_pass];
/*
	if (!isset($name) || !strlen($name)){
		$errmsg[] = "ユーザ名が入力されていません";
	}
	if (!isset($pass) || !strlen($pass)){
		$errmsg[] = "パスワードが入力されていません";
	}
//入力値にエラーがあれば入力画面再表示
*/	if (count($errmsg) > 0){
		screen($errmsg, $name);
		return;
	}

//DB open
	$db = new DB(_pdo_dbtype, _pdo_host, _pdo_dbname, _pdo_charset, _pdo_readUser, _pdo_readUserPass);
	if ($db->get_conn() === null){
		$errmsg[] = "エラーが発生し、ログインできませんでした";
var_dump($db->get_exception());
		$db = null;
		screen($errmsg, $name);
		return;
	}

//loginテーブル読み込み
	$login = new LoginTable();

/*	$sql = "SELECT * FROM ". $login->get_item("table_name") . " WHERE ". _login_name. " = :"._login_name." AND "._login_pass." = :"._login_pass;
	$value = array(":". _login_name => $name, ":". _login_pass => $pass);
$errmsg[] = $sql;
	if (($prepare = $db->prepare($sql)) === false){
		$errmsg[] = "ユーザ名またはパスワードが誤っています";
		$db = null;
		screen($errmsg, $name);
		return;
	};
	$result = $db->execute($prepare, $value);
*/
	$sql = "select * from login where name = '$name' and pass = '$pass'";
	$result = $db->query($sql);
	$errmsg[] = $sql;

	if ($result === false){
		$errmsg[] = "ユーザ名またはパスワードが誤っています";
		$db = null;
		screen($errmsg, $name);
		return;
	}

	$row = $result->fetchall();
	if (count($row) != 1){
		$errmsg[] = "ユーザ名またはパスワードが誤っています";
		$db = null;
		screen($errmsg, $name);
		return;
	}

//正常終了
	$db = null;
	require_once("success.php");
?>

<?php
function screen($errmsg, $name){
	$name = htmlspecialchars($name, ENT_QUOTES);
?>

	<!DOCTYPE html>
	<meta charset="utf-8">
	<title>ログイン入力</title>
	<style>
		.err {color:red;}
	</style>

	<h1>ログイン</h1>

	<div class="err">
		<?php
			foreach($errmsg as $val){
				echo $val, "<br>";
			}
		?>
	</div>
	<form action ='<?= $_SERVER["SCRIPT_NAME"] ?>' method="POST">
		<div>
			<p>ユーザ名：<input type="text" name="name" value='<?= $name ?>' size=10></p>
			<p>パスワード：<input type="password" name="pass" value='' size=10></p>
			<p><input type="submit" value="ログイン"></p>
		</div>
	</form>
	<p>ユーザ登録がまだの方はこちら <a href="newuser.php"><button> 会員登録 </button></a></p>

<?php
}
?>