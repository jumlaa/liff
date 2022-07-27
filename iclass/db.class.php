<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "wat");

class db{
	var $db_conn = "";
	var $sql = "";
	
	function __construct(){
		$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		$conn-> set_charset("utf8");
		
		$this->db_conn = $conn;
		
		if(mysqli_connect_errno()){
			echo "Failed to connnect to DB : ".mysqli_connect_error();
		}
		/*else{
			echo "Connect success";
		}*/
	}
	
	function query($sqlstr){
		$this->sql = $sqlstr;
		$result = mysqli_query($this->db_conn, $this->sql) or die("<br><span style='color:ff0000;'>SQL Error : ".mysqli_error($this->db_conn)."</span><br/><br/>");
		if($result){
			return $result;
		}else{
			return show_error(mysqli_error());
		}			
	}
	/**
	function query_result($sqlstr){
		$this->sql = $sqlstr;
		$result = mysqli_query($this->db_conn, $this->sql) or die ("<br><span style='color:ff0000;'>SQL Error : ".mysqli_error()."</span><br/><br/>");
		
		$data = mysqli_result($result,0,0);
		return $data;
	}**/
	# นับจำนวนแถวจาก Query
	# $res = $db->query('SELECT field FROM table WHERE where'); 
	# $rows = $db->rows($res); 
    function rows($sql="sql"){
      if ($res = mysqli_num_rows($sql)){ 
            return intval($res); 
        }else{ 
            $this->_error(); 
            return false; 
        } 
    }
	function close(){
		return $this->db_conn->close();
	} 
}
?>