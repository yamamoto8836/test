<?php
// author yamamoto
	$errmsg = array();
	$name = "";
	$pass = "";
	$post = false;

	while(!$post){
		if ($_SERVER["REQUEST_METHOD"] == "GET")
			break;

		$name = $_POST["name"];
		$pass = $_POST["pass"];

		$user = "reader";
		$password = "reader";
		$dsn = "mysql:host=localhost;dbname=test";

		try{
			$db = new PDO($dsn, $user, $password);
			$db->exec("SET NAMES utf8");
			$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		}catch(Exception $e){
			$errmsg[] = "database open error";
			break;
		}

		$sql = "select * from login where name = '$name' and pass = '$pass'";
		$result = $db->query($sql);

		$errmsg[] = $sql;
		if ($result === false || $result->columnCount() == 0){
			$errmsg[] = "登録されていないログイン名またはパスワードです";
			break;
		}
		$db = null;
		require_once("success.php");
		return;
	}
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
