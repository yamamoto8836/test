<?php
/*
 * Author : yamamoto
 * create date : 2013/01/22
 * update date :
*/
class LoginTable{

	private $table_name = "login";

//	public $_name = "name";
//	public $_pass = "pass";

	private $item_list = array();
    private $name = null;
    private $pass = null;

	function __construct(){
		$this->item_list = compact($this->name, $this->pass);

		$this->init_items();
	}

	function init_items(){
		foreach($this->item_list as $var => $value){
			if (is_array($value)){
				$this->$var = $value[0]($value[1]);
			}else{
				$this->$var = $value;
			}
		}
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

	function insert($db, $items){
		$values = array();
		foreach($items as $val){
			$values[":".$val] = $this->$val;
		}

		$sql = "INSERT INTO" . $this->table_name . " (" . implode($items, ",") . ") value (" . implode(array_keys($values), ",") . ")";

		return $db->insert($sql, $values);
	}
}

?>
