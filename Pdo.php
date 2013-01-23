<?php
/*
 * Author : yamamoto
 * create date : 2013/01/21
 * update date :
*/

class Pdo {
	private $conn  = null;
	private $count = -1;
	private $exception = null;
	private $errorInfo = null;

	function __constract($dns, $user, $pass) {
		$this->clear_error();
		$dnsstring = "$dns['dbtype']:host=$dns['host'];dbname=$dns['dbname']";
		try {
			$this->conn = new PDO($dnsstring, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$this->conn->exec("SET NAMES $dns['charset']");
			$this->conn->setAttribute(PDO :: ATTR_CASE, PDO :: CASE_LOWER);
			echo "okoko";
		} catch (Exception $e) {
			$this->conn = null;
			$this->set_error($e);
			echo "error";
		}
	}

	function get_conn(){
		return $this->conn;
	}

	function get_count(){
		return $this->count;
	}

	function get_exception(){
		return $this->exception;
	}

	function get_errorInfo(){
		return $this->errorInfo;
	}

	function query($sql) {
		$this->clear_error();
		try{
			$result = $this->conn->query($sql);
			$this->count = count($result);
			return $result;
		}catch(Exception $e){
			$this->set_error($e);
			return false;
		}

		return $result;
	}

	function prepare($sql){
		// 成功したらPDOStatementオブジェクト、失敗したらFALSEを返す
		$this->clear_error();

		try{
			return  $this->prepare($sql);
		}catch(Exception $e){
			$this->set_error($e);
			return false;
		}
	}

	function execute($prepare, $values){
		// 成功したら結果セットまたはPDOStatementオブジェクト、失敗したらFALSEを返す
		$this->clear_error();

		try{
			$prepare->execute($values);
			if (is_array($prepare)){
				$this->count = count($prepare);
			}else{
				$this->count = $prepare;
			}
			return $prepare;
		}catch(Exception $e){
			$this->set_error($e);
			return false;
		}
	}

	function insert($sql, $values){
		//$sqlはプレイスフォルダ利用のinsert文　$valuesはプレイスフォルダに合う値の集合
		if (($prepare = $this->prepare($sql)) === false){
			return false;
		}
		if (($result = $this->execute($prepare, $values)) === false){
			if ($this->errInfo[1] == 1062){
				$this->count = -2;
			}
		}

		return $result;
	}

	private function clear_error(){
		$this->exception = null;
		$this->errorInfo = null;
		$this->count = -1;
	}

	private function set_error($e){
		$this->exception = $e;
		if ($this->conn !== null){
			$this->errorInfo = $this->conn->errorInfo();
		}
		$this->count = -1;
	}
}
?>
