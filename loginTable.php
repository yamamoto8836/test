<?php
/*
 * Author : yamamoto
 * create date : 2013/01/22
 * update date :
*/
class LoginTbl{

	public $_table_name = "login";

	public $_name = "name";
	public $_pass = "pass";

	private $item_init = array();
//public $name = null;
//public $pass = null;

	function __construct(){
		$this->item_init[$this->_name] = null;
		$this->item_init[$this->_pass] = null;

		$this->init_item();
	}

	function init_item(){
		foreach($this->item_init as $key => $val){
			global $$key;

			$$key = $val;
		}
	}

	function zz(){
		global $z;
		//echo "zz";
		return $z;
	}

	function get_item($item){
		return  $this->$item;
	}

	function set_item($item, $value){
		$this->$item = $value;
	}

	function set_record($row){
		foreach($row as $key=>$val){
			set_item($key, $val);
		}
	}


/*function set_item($item){
	$w = "this";
	$this->name = $name;
}
function insert($db, $item){
	$sql = "";
	$sql2 = "";
	forEach($item as $key=>$val){
		$sql .= $key;
		$sql2 .= $db->conn->dbquote
	$sql = "INSERT INTO $this->_table_name($this->_login_name, $this->_login_pass) values
}*/

}

?>
