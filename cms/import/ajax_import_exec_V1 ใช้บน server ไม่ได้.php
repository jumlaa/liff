<?php 
require("../../explicite.php");
require("../../iclass/format_code.class.php");
require("../../iclass/picture.class.php");
$fpic = new picture;
require_once("../../iclass/db.class.php");
$db = new db;

$flag = "true";
$error_msg = "";
/*-----------------------------*/
$_path = "../../upload/import/";
if(!@opendir($_path)) {
	@mkdir($_path, 0777);
}
/*-----------------------------*/ 
/*-------------File------------*/
	if($_FILES['QPic']['name'] != "" && $flag=="true"){
		//ทำการตรวจสอบนามสกุลของไฟล์ว่าเป็น excel ไฟล์หรือไม่
		$QPic_type	= $fpic->GetFile_Lastname($_FILES['QPic']['name']); 
		//echo "<BR><BR>Picture type = ".$QPic_type;
		if($QPic_type!=".xls" && $QPic_type!=".xlsx"){
			echo "<br>flag = ".$flag = "file_type_invalid";
			echo "<br>error_msg = ".$error_msg = "<span class='txt_red'>คุณเลือกไฟล์ไม่ถูกต้อง !!!</span>";
		}else{
			//file นามสกุลถูกต้อง
			echo $filename = $fpic->GenFile_Name(@$_FILES['QPic'], $_path, $_FILES['QPic']['name']);
			copy($_FILES['QPic']['tmp_name'],$filename); @unlink($_FILES['QPic']['tmp_name']);
			
			echo "<br>flag 1 = ".$flag = ReadFile_Import($filename, $error_msg);
			
		}
	}else{
		$flag = "fail";
	}
	exit;
/*-------------File------------*/


?>
<script language="javascript"> 
	//alert('<-?=$flag?>');
	window.parent.editDataOK("<?=$flag?>", "<?=$error_msg?>");
</script>

<?php
function ReadFile_Import($filename, &$error_msg){
	//set_time_limit(12048);
	//require_once("../../iclass/db.class.php");
	$db = new db;
	
	include '../../Classes/PHPExcel/IOFactory.php';
	
	// Let IOFactory determine the spreadsheet format
	$document = PHPExcel_IOFactory::load($filename);
	$startFrom = 0; //default value is 1
	// Get the active sheet as an array
	$activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);
	//$activeSheetData = $document->setActiveSheetIndex(1);
	
	$n=1;
	$i = $j = $k = 1;
	/*---------------explicite-----------------*/
	$member_code = $member_name = $department_name = $position_name = $member_start_work = "";
	$error_msg_department = $error_msg_position = $error_msg_member = "";
	/*---------------explicite-----------------*/
	///require_once("cms/department/department.class.php");
	//$dept = new department; 
	//echo '1111111126 : dept 5'; exit;
	//require_once("cms/position/position.class.php");
	//$pos = new position;
	foreach($activeSheetData as $val){
		if($n>1){
			$member_code = trim($val[0]); 
			$member_name = trim($val[1]); 
			$position_name = trim($val[2]); 
			$department_name = trim($val[3]); 
			$member_email = trim($val[4]);
			$member_start_work = trim($val[5]); 
			
			if(strpos($member_start_work, "/")){ //   30/10/2549
				$dd = substr($member_start_work, 0, 2);
				$mm = substr($member_start_work, 3, 2);
				$yy = substr($member_start_work, 6);
				
				echo '<br>member_start_work=='.$member_start_work = $yy."-".$mm."-".$dd;
			} 
			
			echo "<br>flag_department $n = ".$flag_department = Import_Department($department_name, $error_msg_department);
			if($flag_department=="success"){
				echo "<br>flag_position = ".$flag_position = Import_Position($position_name, $error_msg_position);
				if($flag_position=="success"){
				
					
					$department_id = $dept->GetDepartment_ID($department_name);
					/*$position_id = $pos->GetPosition_ID($position_name);
					echo "<br>flag_employee = ".$flag_member = Import_Member($member_code, $member_name, $member_start_work, $department_id, $position_id, $member_email, $error_msg_member);
					if($flag_member=="success"){
						$flag = "success";
					}else{
						$flag = "fail";
					}*/
				}
			}
			
			
		}
		$n++;	
		echo "<br><hr><br>".$error_msg .= $error_msg_member.$error_msg_department.$error_msg_position;
	}//end foreach
	
	unlink($filename);
	return $flag;
}
function Import_Member($member_code, $member_name, $member_start_work, $department_id, $position_id, $member_email, &$error_msg){
	require("../../explicite.php");
	
	$gen = new format_code;
	$db = new db;
	$flag_member = "success";
	$str_member = "";
	//member member member member member member member member member member member member member member member member member member member member
	//member member member member member member member member member member member member member member member member member member member member
	//member member member member member member member member member member member member member member member member member member member member
	if($member_code!=""){
			$sqlCheck_Member = "select member_id, member_code from member where member_code = '$member_code' ";
			$resutlCheck_Member = $db->query($sqlCheck_Member);
			if(mysql_num_rows($resutlCheck_Member)==0){
				$sqlMember = "insert into member (
								member_code, member_order, member_display, 
								member_username, member_password, member_prename_id, 
								member_name, member_nickname, member_id_card, 
								member_description, member_picture, member_remark, 
								member_status, member_type_id, member_status_block, 
								member_type, member_is_show, member_is_delete, 
								member_date_add, member_id_add, member_address, member_province_id,
								member_start_work, member_department_id, member_position_id, member_email,
								member_class_id
							 )values(
							 	'$member_code', '0', '', 
								'', '', '-999', 
								'$member_name', '', '', 
								'', 'images/no_picture.gif', '', 
								'0', '3', '0', 
								'0', '1', '0', 
								'$today', '$_SESSION[valid_id]', '', '-999',
								'$member_start_work', '$department_id', '$position_id', '$member_email',
								'-999'
							 )";
				$resultMember = $db->query($sqlMember);
				if($resultMember){
					//department 
					
					$flag_member = "success";
					$str_member .= "พนักงาน -> รายการใหม่ : ".$member_name." [".$member_code."] <span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span><br>";
				}else{
					$flag_member = "fail";
					$str_member .= "<span class='txt_red'>พนักงาน -> เพิ่ม - เกิดความผิดพลาด : ".$member_name." [".$member_code."]</span><br>";
				}					 
			}else{
				$mem = mysql_fetch_array($resutlCheck_Member);
				$member_id = $mem['member_id'];
				
				$sqlMember = "update member set 
							 	member_code = '$member_code',
								member_name = '$member_name',
								member_department_id = '$department_id',
								member_position_id = '$position_id',
								member_email = '$member_email',
								member_start_work = '$member_start_work',
								member_last_update = '$today',
								member_id_update = '$_SESSION[valid_id]'
							  where member_id = '$member_id'
							 ";
				$resultMember = $db->query($sqlMember);			 
				if($resultMember){
					$flag_member = "success";
					$str_member .= "<span class='txt_silver'>พนักงาน -> รายการแก้ไข : ".$member_name." [".$member_code."] <span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span></span><br>";
				}else{
					$flag_member = "fail";
					$str_member .= "<span class='txt_red'>พนักงาน -> แก้ไข - เกิดความผิดพลาด : ".$member_name." [".$member_code."]</span><br>";
				}
			}
	}
	echo '<br>พนักงาน : '.$member_name.'----------'.$flag_member."<br><br>";
	$error_msg = $str_member;
	$db->sql_close();
	return $flag_member;
	//member member member member member member member member member member member member member member member member member member member member
	//member member member member member member member member member member member member member member member member member member member member
	//member member member member member member member member member member member member member member member member member member member member
}
function Import_Department($department_name, &$error_msg){
	require("../../explicite.php");
	
	$gen = new format_code;
	$db = new db;
	$flag_department = "success";
	$str_department = ""; 
		//department department department department department department department department department department department department 
		//department department department department department department department department department department department department  
		//department department department department department department department department department department department department 
		if($department_name!=""){
			$sqlCheck_Department = "select department_id, department_name from tb_department where department_name = '$department_name' ";
			$resutlCheck_Department = $db->query($sqlCheck_Department);
			if(mysql_num_rows($resutlCheck_Department)==0){
				$sqlDepartment = "insert into tb_department (
									department_code, department_order, department_name,
									department_description, department_picture, department_remark,
									department_status, department_type, department_is_show, 
									department_is_delete, 
									department_date_add, department_member_id, department_member_ip, 
									department_last_update, department_member_update, department_ip_update,
									department_str 
								 )values(
								 	'', '0', '$department_name',
									'', 'images/no_picture.gif', '',
									'0', '0', '1',
									'0', 
									'$today', '$_SESSION[valid_id]', '',
									'$today', '$_SESSION[valid_id]', '',
									''
								 )";
				$resultDepartment = $db->query($sqlDepartment);
				if($resultDepartment){
					$auto_generate = $gen->CheckAuto_Generate("auto_department_id");
					if($auto_generate!=""){
						@require_once("../../iclass/format_code.class.php");
						$gen = new format_code;
						$max_id = $gen->GetMax_ID("tb_department", "department_id");
						$format_code = $gen->GetFormat_Code("format_department_id", "initial_department_id", "auto_department_id");
						$code = $format_code.$max_id; 
						$db->query("update tb_department set department_code = '$code' where department_id = '$max_id' ");
						$flag_department = "success";
						$str_department .= "แผนก -> รายการใหม่ : ".$department_name." <span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span><br>";
					}
				}else{
					$flag_department = "fail";
					$str_department .= "<span class='txt_red'>แผนก -> เพิ่ม - เกิดความผิดพลาด : ".$department_name."</span><br>";
				}			 
			}else{
				$dept = mysql_fetch_array($resutlCheck_Department);
				$department_id = $dept['department_id'];
				
				$sqlDepartment = "update tb_department set 
									department_name = '$department_name'
								  where department_id = '$department_id'
								 ";
				$resultDepartment = $db->query($sqlDepartment);			 
				if($resultDepartment){
					$flag_department = "success";
					$str_department .= "<span class='txt_silver'>แผนก -> รายการแก้ไข : ".$department_name."<span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span></span><br>";
				}else{
					$flag_department = "fail";
					$str_department .= "<span class='txt_red'>แผนก -> แก้ไข - เกิดความผิดพลาด : ".$department_name."</span><br>";
				}
			}
			echo '<br>แผนก : '.$department_name.'----------'.$flag_department;
			$error_msg = $str_department;
			$db->sql_close();
			return $flag_department;
		}
		$db->sql_close();
		//department department department department department department department department department department department department 
		//department department department department department department department department department department department department  
		//department department department department department department department department department department department department
}
function Import_Position($position_name, &$error_msg){ //echo '<br>cwd = '. getcwd();
	require("../../explicite.php");
	
	$gen = new format_code;
	$db = new db;
	$flag_position = "success";   
	$str_position = ""; 
		//position position position position position position position position position position position position position position 
		//position position position position position position position position position position position position position position 
		//position position position position position position position position position position position position position position 
		if($position_name!=""){ echo $position_name;
			$sqlCheck_Position = "select position_id, position_name from tb_position where position_name = '$position_name' ";
			$resutlCheck_Position = $db->query($sqlCheck_Position);
			if(mysql_num_rows($resutlCheck_Position)==0){
				$sqlPosition = "insert into tb_position (
									position_code, position_order, position_name,
									position_description, position_picture, position_remark,
									position_status, position_type, position_is_show, 
									position_is_delete, position_manager,
									position_date_add, position_member_id, position_member_ip, 
									position_last_update, position_member_update, position_ip_update,
									position_str 
								 )values(
								 	'', '0', '$position_name',
									'', 'images/no_picture.gif', '',
									'0', '0', '1',
									'0', '-999',
									'$today', '$_SESSION[valid_id]', '',
									'$today', '$_SESSION[valid_id]', '',
									''
								 )"; echo "<br>". $sqlPosition;
				$resultPosition = $db->query($sqlPosition);
				if($resultPosition){
					$auto_generate = $gen->CheckAuto_Generate("auto_position_id");
					if($auto_generate!=""){
						@require_once("../../iclass/format_code.class.php");
						$gen = new format_code;
						$max_id = $gen->GetMax_ID("tb_position", "position_id");
						$format_code = $gen->GetFormat_Code("format_position_id", "initial_position_id", "auto_position_id");
						$code = $format_code.$max_id; 
						$db->query("update tb_position set position_code = '$code' where position_id = '$max_id' ");
						$flag_position = "success";
						$str_position .= "ตำแหน่ง -> รายการใหม่ : ".$position_name." <span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span><br>";
					}
				}else{
					$flag_position = "fail";
					$str_position .= "<span class='txt_red'>ตำแหน่ง -> เกิดความผิดพลาด : ".$position_name."</span><br>";
				}			 
			}else{
				$pos = mysql_fetch_array($resutlCheck_Position);
				$position_id = $pos['position_id'];
				
				$sqlPosition = "update tb_position set 
									position_name = '$position_name'
								  where position_id = '$position_id'
								 ";
				$resultPosition = $db->query($sqlPosition);			 
				if($resultPosition){
					$flag_position = "success";
					$str_position .= "<span class='txt_silver'>ตำแหน่ง -> รายการแก้ไข : ".$position_name."<span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span></span><br>";
				}else{
					$flag_position = "fail";
					$str_position .= "<span class='txt_red'>ตำแหน่ง -> แก้ไข - เกิดความผิดพลาด : ".$position_name."</span><br>";
				}
			}
		}
		echo '<br>ตำแหน่ง : '.$position_name.'----------'.$flag_position; 
		$error_msg = $str_position;
		$db->sql_close();
		return $flag_position;
		//position position position position position position position position position position position position position position 
		//position position position position position position position position position position position position position position 
		//position position position position position position position position position position position position position position
}
?>