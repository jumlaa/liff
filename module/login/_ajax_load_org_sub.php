<?php
require_once("../../iclass/db.class.php");
$db = new db;

$flag = "true";
$data = array();
$str = "";

$org_id = $_POST['org_id'];
$org_sub_id = "";
$sqlOrg_Sub = "";

if($org_id!="" && $org_id!="-999"){
	$sqlOrg_Sub = "select * from tb_org_sub where org_sub_id<>'-999' and org_id = '$org_id' order by org_sub_id*1 asc";
	$resultOrg_Sub = $db->query($sqlOrg_Sub) or die ("Error : cboOrg_Sub -> ".mysqli_error());
	$prow = mysqli_num_rows($resultOrg_Sub);
	if($prow>0){ 
		$str.= "<select name='cboOrg_Sub' id='cboOrg_Sub' class='select_box' >";
		$str.= "<option value='-999'> --- เลือกหน่วยงานย่อย --- </option>";
		while($osub = mysqli_fetch_array($resultOrg_Sub)){ 
			$str.= "<option value='" .$osub['org_sub_id']. "'";
			if($org_sub_id==trim($osub['org_sub_id'])){ $str.= " selected "; }
				$str.= ">".$osub['org_sub_name']." [".$osub['org_sub_id']."]"."</option>";
		}//end while
		$str.= "</select>";
		$flag = "success";
	}//end if
	else{
		$str.= "<select name='cboOrg_Sub' size='1' id='cboOrg_Sub' class='select_box' >";
		$str.= "<option value='-999'> --- เลือกหน่วยงานย่อย --- </option>";
		$str.= "</select>"; 
		$flag = "success";
	}
}else{
	$flag = "fail";
}
$data['str'] = $str;
$data['flag'] = $flag;
$data['sql'] = $sqlOrg_Sub;

echo json_encode($data);
?>