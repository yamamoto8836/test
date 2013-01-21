<?php
/*
 * Author : yamamoto 
 * CreateDate : 2013/01/21
 * UpdateDate :
 */
 
 	$errmsg = array();
	$name = "";
	$post = false;

	while(!$post){
		if ($_SERVER["REQUEST_METHOD"] == "GET")
			break;

		$name = $_POST["name"];
		$pass = $_POST["pass"];
		$pass2 = $_POST["pass2"];
		
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

		$sql = "select * from login where name = " . $db->quote($name);
		$result = $db->query($sql);
		if ($result === false){
			$errmsg[] = "DB error";
			break;
		}elseif count($result) > 0){
			$errmsg[] = "すでに使われている名前です";
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
?>
