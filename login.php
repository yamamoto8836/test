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
		if ($result === false || count($result) == 0){
			$errmsg[] = "登録されていない名前またはパスワードです";
			break;
		}
		$post = true;
	}

	$db = null;
?>

<meta charset="utf-8">
<?php
	if ($post){
		echo "<p>" , $name , "さん、いらっしゃい</p>", $errmsg[0];
		echo "<p><a href='", $_SERVER["SCRIPT_NAME"] , "'>ログアウト</a></p>";
	}else{
?>
		<title>ログイン入力</title>
		<style>
			.err {color:red;}
		</style>

		<div class="err">
			<?php
				foreach($errmsg as $val){
					echo $val, "<br>";
				}
			?>
		</div>

		<form action ='<?= $_SERVER["SCRIPT_NAME"] ?>' method="POST">
			<div>
				<p>ログインID<input type="text" name="name" value='<?= $name ?>' size=10></p>
				<p>パスワード<input type="password" name="pass" value='' size=10></p>
				<p><input type="submit" value="ログイン"></p>
			</div>
		</form>
<?php
	}
?>