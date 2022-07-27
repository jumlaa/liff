<?php
require_once("../../iclass/db.class.php");
$db = new db;

$flag = "true";
$data = array();
$user_type_id = "";

if(isset($_REQUEST['cmdSubmit'])){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        //รายการที่ submit มาถ้าไม่มีจะต้องนำไปทำการ insert ลงใน member
		$member_name = trim($_POST['txtName']);
		$member_lastname = trim($_POST['txtLastname']);
		$member_email = trim($_POST['txtEmail']);
		$org_id = trim($_POST['cboOrg']);
		$org_sub_id = trim($_POST['cboOrg_Sub']);
		
		$sql = "insert into member (
					member_name, member_lastname,
					member_email, org_sub_id,
					member_is_show, member_is_delete
				)values(
					'$member_name', '$member_lastname',
					'$member_email', '$org_sub_id',
					'1', '0'
				)";
		$result = $db->query($sql);
		if($result){
			echo $flag = "success";
		}else{
			echo $flag = "fail";
		}
    }
}
?>
<script language="JavaScript"> 
//alert("0000 = "+'< ?=$flag?>');
window.parent.LoginOK('<?=$flag?>');
</script>