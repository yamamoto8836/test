<?php
/*
 * Author : yamamoto
 * create date : 2013/01/21
 * update date :
*/

class pdo {
	private $conn  = null;
	private $count = 0;
	private $exception = null;

	function __constract($dns, $user, $pass) {
		$dnsstring = "$dns['dbtype']:host=$dns['host'];dbname=$dns['dbname']";
		try {
			$this->conn = new PDO($dnsstring, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$this->conn->exec("SET NAMES $dns['charset']");
			$this->conn->setAttribute(PDO :: ATTR_CASE, PDO :: CASE_LOWER);
		} catch (Exception $e) {
			$this->conn = null;
			$this->exception = $e;
		}
	}

	function getConn(){
		return $this->conn;
	}

	function getCount(){
		return $this->count;
	}

	function getError(){
		return $this->exception;
	}

	function query($sql) {
		$this->exception = null;
		try{
			$result = $this->conn->query($sql);
			$this->count = count($result);
			return $result;
		}catch(Exception $e){
			$this->exception = $e;
			$this->count = -1;
			return false;
		}

		return $result;
	}

	function prepare($sql){
		// 成功したらPDOStatementオブジェクト、失敗したらFALSEを返す
		$this->exception = null;

		try{
			return  $this->prepare($sql);
		}catch(Exception $e){
			$this->exception = $e;
			$this->count = -1;
			return false;
		}
	}

	function execute($prepare, $param){
		// 成功したら結果セットまたはPDOStatementオブジェクト、失敗したらFALSEを返す
		$this->exception = null;

		try{
			$prepare->execute($param);
			if (is_array($prepare)){
				$this->count = count($prepare);
			}else{
				$this->count = $prepare;
			}
			return $prepare;
		}catch(Exception $e){
			$this->exception = $e;
			$this->count = -1;
			return false;
		}
	}

}
?>
