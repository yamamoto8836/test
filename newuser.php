<?php
/*
 * Author : yamamoto
 * CreateDate : 2013/01/21
 * UpdateDate :
 */
 	require_once("define.php");

 	$errmsg = array();
	$name = "";
	$post = false;

//GET呼び出しなら、入力画面表示
	if ($_SERVER["REQUEST_METHOD"] == "GET"){
		screen($errmsg, "");
		return;
	}

//POST呼び出し
//入力値の取り出しとチェック
	$name = $_POST[_login_name];
	$pass = $_POST[_login_pass];
	$pass2 = $_POST["pass2"];

	if (!(preg_match("/^\w{4,16}$/", $name))){
		$errmsg[] = "ユーザ名に使えない文字があるか桁数が範囲外です";
	}
	if (!(preg_match("/^\w{6,16}$/", $pass))){
		$errmsg[] = "パスワードに使えない文字があるか桁数が範囲外です";
	}
	if ($pass !== $pass2){
		$errmsg[] = "２つのパスワードが一致しません";
	}
//入力値にエラーがあれば入力画面再表示
	if (count($errmsg) > 0){
		screen($errmsg, $name);
		return;
	}

//DB open
	$db = new DB(_pdo_dbtype, _pdo_host, _pdo_dbname, _pdo_charset, _pdo_writeUser, _pdo_writeUserPass);
	if ($db->get_conn() === null){
		$errmsg[] = "エラーが発生し、登録できませんでした";
		screen($errmsg, $name);
var_dump($db->get_exception());
		$db = null;
		return;
	}

//loginテーブルに書き込み
	$login = new LoginTable();
	$login->set_item(_login_name, $name);
	$login->set_item(_login_pass, $pass);

	if ($login->insert($db, array(_login_name, _login_pass)) === false){
		if ($db->get_count() == -2){
			$errmsg[] = "このユーザ名は他で使われています";
		}else{
			$errmag[] = "エラーが発生し、登録できませんでした";
var_dump($db->get_exception());
		}
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
	<title>ユーザ登録</title>
	<style>
		.err {color:red;}
	</style>

	<h1>ユーザ登録</h1>

	<div class="err">
	<?php
		foreach($errmsg as $val){
			echo $val, "<br>";
		}
	?>
	</div>

	<form action ='<?= $_SERVER["SCRIPT_NAME"] ?>' method="POST">
		<p>ユーザ名(半角英数4～16文字)：<input type="text" name="<?= _login_name ?>" value="<?= $name ?>" size=20></p>
		<p>パスワード(半角英数6～16文字)：<input type="password" name="<?= _login_pass ?>" value="" size=10></p>
		<p>パスワード再入力：<input type="password" name="pass2" value="" size=10></p>
		<p><input type="submit" value="登録"></p>
	</form>
<?php
}