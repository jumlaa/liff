<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
</head>
<style type="text/css">
.txt_red{ color:#FF0000;}
</style>
<?php 
//require("explicite.php"); 
//require("iclass/format_code.class.php");
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
		//echo "<BR><BR>Picture type = ".$QPic_type; exit;
		if($QPic_type!=".xls" && $QPic_type!=".xlsx"){
			echo "<br>flag = ".$flag = "file_type_invalid";
			echo "<br>error_msg = ".$error_msg = "<span class='txt_red'>คุณเลือกไฟล์ไม่ถูกต้อง !!!</span>";
		}else{
			//file นามสกุลถูกต้อง
			echo $filename = $fpic->GenFile_Name(@$_FILES['QPic'], $_path, $_FILES['QPic']['name']);
			$fileName = $filename;
			echo '<br>copy result = '. copy(@$_FILES['QPic']['tmp_name'],$fileName); 
			
			echo "<br>flag 1 = ".$flag = ReadFile_Import($filename, $error_msg);
			
		}
	}else{
		$flag = "fail";
	}
	//exit;
/*-------------File------------*/


?>
<script language="javascript"> 
	window.parent.editDataOK("<?=$flag?>", "<?=$error_msg?>");
</script>

<?php
function ReadFile_Import($filename, &$error_msg){
	//set_time_limit(12048);
	//require_once("iclass/db.class.php");
	$flag = "true";
	$db = new db;
	
	include '../../Classes/PHPExcel/IOFactory.php';
	
	// Let IOFactory determine the spreadsheet format
	$document = PHPExcel_IOFactory::load($filename);
	$startFrom = 0; //default value is 1
	// Get the active sheet as an array
	$activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);
	//$activeSheetData = $document->setActiveSheetIndex(0);
	
	$n=1;
	$i = $j = $k = 1;
	/*---------------explicite-----------------*/
	$member_name = $member_lastname = $member_email = $org_sub_id = "";
	$error_msg_org = $error_msg_org_sub = $error_msg_member = "";
	/*---------------explicite-----------------*/
	foreach($activeSheetData as $val){ //echo 'val = '.trim($val[0]);
		if($n>=1){
			$org_name = trim($val[0]); echo "<br>org_name :: ".$org_name;
			$org_sub_name = trim($val[1]);  //echo "<br>NAME = ".iconv('UTF-8','TIS-620',trim($val[0]));  
			$member_name = trim($val[2]);
			$member_email = trim($val[3]);
			//$org_name = iconv('UTF-8','TIS-620',trim($val[0]));  
			//$org_sub_name = iconv('UTF-8','TIS-620',trim($val[1]));  
			//$member_name = iconv('UTF-8','TIS-620',trim($val[2]));  
			
			$o_name = explode(".", str_replace(" ", "", $org_name));
			$org_name = str_replace(" ", "", trim($o_name[1]));
			
			if($org_sub_name=="#"){ $org_sub_name = $org_name; }
			
			$org_id = "";
			$org_sub_id = "";
			echo "<br>flag_org $n = ".$flag_org = Import_Org($org_id, $org_name, $error_msg_org);
			
			if($flag_org=="success"){
				echo "<br>flag_org_sub $n = ".$flag_org_sub = Import_Org_Sub($org_sub_id, $org_sub_name, $org_id, $error_msg_org_sub);
				
				if($flag_org_sub=="success"){
				
									
					echo "<br>flag_member $n = ".$flag_member = Import_Member($member_name, $member_email, $org_id, $org_sub_id, $error_msg_member);
					
					
					if($flag_member=="success"){
						$flag = "success";
					}else{
						$flag = "fail";
					}
				}
			}
			
			
		}
		$n++;	
		$error_msg .= $error_msg_member.$error_msg_org.$error_msg_org_sub;
	}//end foreach
	
	//unlink($filename);
	return $flag;
}
function Import_Member($member_name, $member_email, $org_id, $org_sub_id, &$error_msg){
	$db = new db;
	$flag_member = "success";
	$str_member = "";
	
	if($member_name!="" && $member_name!="ไม่มีข้อมูล"){
		$ename = explode(" ", $member_name);
		$m_name = $ename[0];
		$m_lastname = $ename[1];
	}else{
		$m_name = "";
		$m_lastname = "";
	}	
	//member member member member member member member member member member member member member member member member member member member member
	//member member member member member member member member member member member member member member member member member member member member
	//member member member member member member member member member member member member member member member member member member member member
	if($member_email!=""){
	
			
			$sqlCheck_Member = "select member_id from member where member_email = '$member_email' ";
			$resutlCheck_Member = $db->query($sqlCheck_Member);
			if(mysqli_num_rows($resutlCheck_Member)==0){
				
			
				$sqlMember = "insert into member (
								member_name, member_lastname, member_email, 
								org_sub_id, member_is_show, member_is_delete
							 )values(
							 	'$m_name', '$m_lastname', '$member_email', 
								'$org_sub_id', '1', '0'
							 )";
				$resultMember = $db->query($sqlMember);
				if($resultMember){
					//org 
					
					$flag_member = "success";
					$str_member .= "ผู้ประสานงาน -> รายการใหม่ : ".$member_name." [".$member_email."] <span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span><br>";
				}else{
					$flag_member = "fail";
					$str_member .= "<span class='txt_red'>ผู้ประสานงาน -> เพิ่ม - เกิดความผิดพลาด : ".$member_name." [".$member_email."]</span><br>";
				}					 
			}else{
				$mem = mysqli_fetch_array($resutlCheck_Member);
				$member_id = $mem['member_id'];
				
				$sqlMember = "update member set 
							 	member_name = '$m_name',
								member_lastname = '$m_lastname',
								member_email = '$member_email',
								org_sub_id = '$org_sub_id'
							  where member_id = '$member_id'
							 ";
				$resultMember = $db->query($sqlMember);			 
				if($resultMember){
					$flag_member = "success";
					$str_member .= "<span class='txt_silver'>ผู้ประสานงาน -> รายการแก้ไข : ".$member_name." [".$member_email."] <span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span></span>--".$member_start_work."<br>";
				}else{
					$flag_member = "fail";
					$str_member .= "<span class='txt_red'>ผู้ประสานงาน -> แก้ไข - เกิดความผิดพลาด : ".$member_name." [".$member_email."]</span><br>";
				}
			}
	}
	echo '<br>ผู้ประสานงาน : '.$member_name.'----------'.$flag_member."<br><br>";
	$error_msg = $str_member;
	$db->close();
	return $flag_member;
	//member member member member member member member member member member member member member member member member member member member member
	//member member member member member member member member member member member member member member member member member member member member
	//member member member member member member member member member member member member member member member member member member member member
}
function Import_Org(&$org_id, $org_name, &$error_msg){
	//echo '<br>view = '.$org_name;
	$db = new db;
	$flag_org = "success";
	$str_org = ""; 
		//org org org org org org org org org org org org 
		//org org org org org org org org org org org org  
		//org org org org org org org org org org org org 
		if($org_name!=""){
			$sqlCheck_Org = "select org_id, org_name from tb_org where org_name = '$org_name' ";
			$resutlCheck_Org = $db->query($sqlCheck_Org); //echo 'num = '.mysqli_num_rows($resutlCheck_Org);
			if(mysqli_num_rows($resutlCheck_Org)==0){
				$sqlOrg = "insert into tb_org (
									org_name, org_is_show, org_is_delete
								 )values(
								 	'$org_name', '1', '0'
								 )";
				$resultOrg = $db->query($sqlOrg);
				if($resultOrg){
					$sqlMax = "select org_id from tb_org order by org_id desc limit 1";
					$resultMax = $db->query($sqlMax);
					if(mysqli_num_rows($resultMax)>0){
						$max = mysqli_fetch_array($resultMax);
						$org_id = $max['org_id'];
					}
					
					$flag_org = "success";
					$str_org .= "หน่วยงาน -> รายการใหม่ : ".$org_name." <span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span><br>";
				}else{
					$flag_org = "fail";
					$str_org .= "<span class='txt_red'>หน่วยงาน -> เพิ่ม - เกิดความผิดพลาด : ".$org_name."</span><br>";
				}			 
			}else{
				$org = mysqli_fetch_array($resutlCheck_Org);
				$org_id = $org['org_id'];
				
				$sqlOrg = "update tb_org set 
									org_name = '$org_name'
								  where org_id = '$org_id'
								 ";
				$resultOrg = $db->query($sqlOrg);			 
				if($resultOrg){
					$flag_org = "success";
					$str_org .= "<span class='txt_silver'>หน่วยงาน -> รายการแก้ไข : ".$org_name."<span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span></span><br>";
				}else{
					$flag_org = "fail";
					$str_org .= "<span class='txt_red'>หน่วยงาน -> แก้ไข - เกิดความผิดพลาด : ".$org_name."</span><br>";
				}
			}
			echo '<br>หน่วยงาน : '.$org_name.'----------'.$flag_org;
			$error_msg = $str_org;
			$db->close();
			return $flag_org;
		}
		$db->close();
		//org org org org org org org org org org org org 
		//org org org org org org org org org org org org  
		//org org org org org org org org org org org org
}
function Import_Org_Sub(&$org_sub_id, $org_sub_name, $org_id, &$error_msg){ //echo '<br>cwd = '. getcwd();
	$db = new db;
	$flag_org_sub = "success";   
	$str_org_sub = ""; 
		//org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub 
		//org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub 
		//org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub 
		
		if($org_sub_name!=""){
			$sqlCheck_Org_Sub = "select org_sub_id, org_sub_name from tb_org_sub where org_sub_name = '$org_sub_name' ";
			$resutlCheck_Org_Sub = $db->query($sqlCheck_Org_Sub); echo 'num = '.mysqli_num_rows($resutlCheck_Org_Sub);
			if(mysqli_num_rows($resutlCheck_Org_Sub)==0){
				$sqlOrg = "insert into tb_org_sub (
									org_sub_name, org_sub_is_show, org_sub_is_delete, org_id
								 )values(
								 	'$org_sub_name', '1', '0', '$org_id'
								 )";
				$resultOrg = $db->query($sqlOrg);
				if($resultOrg){
					$sqlMax = "select org_sub_id from tb_org_sub order by org_sub_id desc limit 1";
					$resultMax = $db->query($sqlMax);
					if(mysqli_num_rows($resultMax)>0){
						$max = mysqli_fetch_array($resultMax);
						$org_sub_id = $max['org_sub_id'];
					}
					
					$flag_org_sub = "success";
					$str_org_sub .= "หน่วยงานย่อย -> รายการใหม่ : ".$org_sub_name." <span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span><br>";
				}else{
					$flag_org_sub = "fail";
					$str_org_sub .= "<span class='txt_red'>หน่วยงานย่อย -> เพิ่ม - เกิดความผิดพลาด : ".$org_sub_name."</span><br>";
				}			 
			}else{
				$org = mysqli_fetch_array($resutlCheck_Org_Sub);
				$org_sub_id = $org['org_sub_id'];
				
				$sqlOrg_Sub = "update tb_org_sub set 
									org_sub_name = '$org_sub_name',
									org_id = '$org_id'
								  where org_sub_id = '$org_sub_id'
								 ";
				$resultOrg_Sub = $db->query($sqlOrg_Sub);			 
				if($resultOrg_Sub){
					$flag_org_sub = "success";
					$str_org_sub .= "<span class='txt_silver'>หน่วยงานย่อย -> รายการแก้ไข : ".$org_sub_name."<span class='pad_left50'>บันทึกข้อมูลเรียบร้อย.</span></span><br>";
				}else{
					$flag_org_sub = "fail";
					$str_org_sub .= "<span class='txt_red'>หน่วยงานย่อย -> แก้ไข - เกิดความผิดพลาด : ".$org_sub_name."</span><br>";
				}
			}
			echo '<br>หน่วยงานย่อย : '.$org_sub_name.'----------'.$flag_org_sub;
			$error_msg = $str_org_sub;
			$db->close();
			return $flag_org_sub;
		}
		$db->close();

		//org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub 
		//org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub 
		//org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub org_sub
}
?>