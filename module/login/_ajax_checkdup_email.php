<?php
require_once("../../iclass/db.class.php");
$db = new db;

$flag = "true";
$data = array();
$str = "";

$email = $_POST['email'];
$org_sub_id = "";
$sqlOrg_Sub = "";

if($email!=""){
	$sql = "select * from member where member_email = '".$email."' ";
	$result = $db->query($sql);
	if(mysqli_num_rows($result)>0){
		$flag = "duplicate_email";
	}else{
		$flag = "success";
	}
}
$data['str'] = $str;
$data['flag'] = $flag;
$data['sql'] = $sql;

echo json_encode($data);
?>