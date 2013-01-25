<?php


/*
 * Author : yamamoto
 * create date : 2013/01/21
 * update date :
*/

class DB {
	private $conn = null;
	private $count = -1;
	private $exception = null;
	private $errorInfo = null;

//コンストラクタ
//		PDOオブジェクト作成し$connに代入
//		引数はすべてdefine.phpで宣言された値を渡すこと
//		DBアクセスのエラーはすべて例外を発生させる
	function __construct($dbtype, $host, $dbname, $charset, $user, $pass) {
		$this->clear_error();
		$dnsstring = $dbtype . ":host=" . $host . ";dbname=" . $dbname;
		try {
			$this->conn = new PDO($dnsstring, $user, $pass, array (
				PDO :: ATTR_ERRMODE => PDO :: ERRMODE_EXCEPTION
			));
			$this->conn->exec("SET NAMES $charset");
			$this->conn->setAttribute(PDO :: ATTR_CASE, PDO :: CASE_LOWER);
		} catch (Exception $e) {
			$this->conn = null;
			$this->set_error($e);
			throw $e;
		}
	}

//デストラクタ
	function __destruct() {
       $this->conn = null;
    }

//ゲッター
	function get_conn(){
		return $this->conn;
	}

	function get_count() {
		return $this->count;
	}

	function get_exception() {
		return $this->exception;
	}

	function get_errorInfo() {
		return $this->errorInfo;
	}

//query
//		基本SQL文中に入力値等可変な値がない場合
//		ある場合は、プレイスフォルダを利用してprepare,exceuteすること
	function query($sql) {
		$this->clear_error();
		try {
			$result = $this->conn->query($sql);
			$this->count = count($result);
			return $result;
		} catch (Exception $e) {
			$this->set_error($e);
			return false;
		}

		return $result;
	}

//prepare
//		基本は :name形式。? でも可
// 		成功したらPDOStatementオブジェクト、失敗したらFALSEを返す
	function prepare($sql) {
		$this->clear_error();

		try {
			return $this->conn->prepare($sql);
		} catch (Exception $e) {
			$this->set_error($e);
			return false;
		}
	}

//execute
//		$prepareはプリペアされたPDOStatementオブジェクト、$valuesは$prepareに渡す値の配列
//		成功したらselect文ならPDOStatementオブジェクト、以外は対象行数
//		失敗したらFALSEを返す
	function execute($prepare, $values) {
		$this->clear_error();

		try {
			$prepare->execute($values);
			if (is_array($prepare)) {
				$this->count = count($prepare);
			} else {
				$this->count = $prepare;
			}
			return $prepare;
		} catch (Exception $e) {
			$this->set_error($e);
			return false;
		}
	}

//insert
//		inserはduplicateを認識しないといけないので分けた
//		重複していたらcountに-2を設定
//		$sqlはプリペア前のプレイスフォルダ利用のinsert文
//		$valuesはそれに合わせた値の配列
	function insert($sql, $values) {
		if (($prepare = $this->prepare($sql)) === false) {
			return false;
		}
		if (($result = $this->execute($prepare, $values)) === false) {
			if ($this->exception->errorInfo[1] == 1062) {	//重複発生
				$this->count = -2;
			}
		}

		return $result;
	}

//内部関数
	private function clear_error() {
		$this->exception = null;
		$this->errorInfo = null;
		$this->count = -1;
	}

	private function set_error($e) {
		$this->exception = $e;
		if ($this->conn !== null) {
			$this->errorInfo = $this->exception->errorInfo;
		}
		$this->count = -1;
	}
}
?>
