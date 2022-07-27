<?php 
$_SESSION["lang"] = "th";  
require_once("../../constant.php");
require_once("../../iclass/db.class.php");
$db = new db;
//$new_password = password_hash($password, PASSWORD_DEFAULT);
//strip_tags($_POST['']); //ใช้สำหรับตรวจสอบอักขระพิเศษ
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.oxhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title><?=PROJECT_NAME;?></title>
    <link rel="shortcut icon" href="#" />
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo filemtime("css/style.css");?>" />
	<link rel="stylesheet" type="text/css" href="module/login/login_style.css?v=<?php echo filemtime("login_style.css");?>" />
    
	
	<script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
	
	
    <?php include("_js_login.php");?>
</head>

<body>
    <center>
        <form name="myform" id="myform_login" action="login_action.php" method="post" role="login" target="logintarget">
            
			<div class="header_text_container txt_white">เข้าสู่ระบบ</div>
			<div class="main_container">
				<div class="control_box">
					<label class="lab">ชื่อ</label>
					<input name="txtName" id="txtName" type="text" class="text_box" value="สมชาย">
					<span class="msg txt_red" id="msg_name"></span>
					<input name="hidMember_ID" id="hidMember_ID" type="hidden" value="" />
				</div>
				<div class="control_box">
					<label class="lab">นามสกุล</label>
					<input name="txtLastname" id="txtLastname" type="text" class="text_box" value="แซ่เล่า">
					<span class="msg txt_red" id="msg_lastname"></span>
				</div>
				<div class="control_box">
					<label class="lab">อีเมลล์</label>
					<input name="txtEmail" id="txtEmail" type="text" class="text_box" value="mail@thailog.org">
					<span class="msg txt_red" id="msg_email"></span>
				</div>
				<div class="control_box">
					<label class="lab">หน่วยงานหลัก</label>
						<?PHP 
						$org_id = "-999";//$row['org_id'];
						
						$sqlOrg = "select * from tb_org where org_id<>'-999' order by org_id*1 asc";
						$resultOrg = $db->query($sqlOrg) or die ("Error : cboOrg -> ".mysqli_error());
						$prow = mysqli_num_rows($resultOrg);
						if($prow>0){ 
								echo "<select name='cboOrg' id='cboOrg' onchange='Load_Org_Sub();' class='select_box' >";
								echo "<option value='-999'> --- เลือกหน่วยงาน --- </option>";
								while($prov = mysqli_fetch_array($resultOrg)){ 
									echo "<option value='" .$prov['org_id']. "'";
									if($org_id==trim($prov['org_id'])){ echo " selected "; }
										echo ">".$prov['org_name']." [".$prov['org_id']."]"."</option>";
								}//end while
								echo "</select>";
						}//end if
						else{
							echo "<select name='cboOrg' size='1' id='cboOrg' class='select_box' >";
							echo "<option value='-999'> --- เลือกหน่วยงาน --- </option>";
							echo "</select>"; 
						}
						?>
						<span class="msg txt_red" id="msg_org"></span>
				</div>
				<div class="control_box">
					<label class="lab">หน่วยงานย่อยภายใต้การกำกับดูแล</label>
					<?PHP 
						$org_sub_id = "-999";//$row['org_sub_id'];
						
						$sqlOrg_Sub = "select * from tb_org_sub where org_sub_id<>'-999' and org_id = '$org_id' order by org_sub_id*1 asc";
						$resultOrg_Sub = $db->query($sqlOrg_Sub) or die ("Error : cboOrg_Sub -> ".mysqli_error());
						$prow = mysqli_num_rows($resultOrg_Sub);
						if($prow>0){ 
								echo "<select name='cboOrg_Sub' id='cboOrg_Sub' class='select_box' >";
								echo "<option value='-999'> --- เลือกหน่วยงานย่อย --- </option>";
								while($osub = mysqli_fetch_array($resultOrg_Sub)){ 
									echo "<option value='" .$osub['org_sub_id']. "'";
									if($org_sub_id==trim($osub['org_sub_id'])){ echo " selected "; }
										echo ">".$osub['org_sub_name']."</option>";
								}//end while
								echo "</select>";
						}//end if
						else{
							echo "<select name='cboOrg_Sub' size='1' id='cboOrg_Sub' class='select_box' >";
							echo "<option value='-999'> --- เลือกหน่วยงานย่อย --- </option>";
							echo "</select>"; 
						}
						?>
						<span class="msg txt_red" id="msg_org_sub"></span>
				</div>
				<div class="control_box">
					<label class="lab">&nbsp;</label>
					<input name="cmdSubmit" id="cmdSubmit" type="submit" value="บันทึกข้อมูลเข้าสู่ระบบ" class="button_box" onclick="return CheckFill()"/>
				</div>
				<div class="control_box">
					<label class="lab">&nbsp;</label>
					<span class="msg" id="msg"></span>
					<iframe id="logintarget" name="logintarget" src="" style="width:0px; height:0px; border:0;"></iframe>
					<p>&nbsp;</p>
				</div>
			</div>
            
        </form>
    </center>

	<script language="javascript">
async function main(){
	alert("Line call !!!");
	await liff.init({ liffid: ""});
}

	</script>
</body>

</html>