<?php
/*
 * Author : yamamoto
 * CreateDate : 2013/01/21
 * UpdateDate :
 */
 	require_once("define.inc");

 	$errmsg = array();
	$name = "";
	$post = false;

	if ($_SERVER["REQUEST_METHOD"] == "GET"){
		screen(array(), "");
		return;
	}

	$name = $_POST[$_login_name];
	$pass = $_POST[$_login_pass];
	$pass2 = $_POST["pass2"];
	
	if (preg_match("/^\w{4,16}$/", $name)){
		$errmsg[] = "ログインIDに使えない文字があるか桁数が範囲外です";
	}elseif	(preg_match("/^\w{6,16}$/", $pass)){
		$errmsg[] = "パスワードに使えない文字があるか桁数が範囲外です";
	}elseif ($pass !== $pass2){
		$errmsg[] = "２つのパスワードが一致しません";
	}
		
	$db = new pdo($_dns, $_readUser, $_readUserPass);
	if ($db->getConn() === null){}
		$errmsg[] = "database open error";
		screen($errmsg, $name);
		return;
	}
	$sql = "insrtselect * from login where name = :name" . $db->quote($name);
	$result = $db->query($sql);
	if ($result === false){
		$errmsg[] = "DB error";
		screen($errmsg, $name);
		return;
	}elseif ($db->getCount() > 0){
		$errmsg[] = "すでに使われている名前です";
		screen($errmsg, $name);
		return;
		break;
	}
	(preg_match("/^\w{6,16}$/", $pass)){
		$errmsg[] = "パスワードに使えない文字があるか桁数が範囲外です";
	}else{}
	


	$sql = "select * from login where name = " . $db->quote($name);
	$result = $db->query($sql);
	if ($result === false){
		$errmsg[] = "DB error";
		screen($errmsg, $name);
		return;
	}elseif ($db->getCount() > 0){
		$errmsg[] = "すでに使われている名前です";
		screen($errmsg, $name);
		return;
		break;
	}

		if ($pass !== $pass2){
			$errmsg[] = "パスワードが一致しません";
			break;
		}
		$db = null;

		$user = "writer";
		$password = "writer";

		try{
			$db = new PDO($dsn, $user, $password);
			$db->exec("SET NAMES utf8");
			$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		}catch(Exception $e){
			$errmsg[] = "database open error";
			break;
		}

		$post = true;
	}

	$db = null;
?>

<?php
function screen($errmsg, $name){
?>

	<!DOCTYPE html>

	<meta charset="utf-8">
	<title>ユーザ登録</title>
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
		<p>ログインID(半角英数4～16文字)<input type="text" name="<?= $_login_name ?>" value="<?= htmlspcialchars($name, ENT_QUOTES ?>" size=20></p>
		<p>パスワード(半角英数6～16文字)<input type="password" name="<?= $_login_pass ?>" value="" size=10></p>
		<p>パスワード再入力<input type="password" name="pass2" value="" size=10></p>
		<p><input type="submit" value="登録"></p>
	</form>
<?php
}
?>

