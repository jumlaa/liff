<style>
div .bd{-moz-box-shadow:0px 0px 3px #aaa;
    -webkit-box-shadow:0px 0px 3px #aaa;
    box-shadow:0px 0px 3px #aaa;
	width:800px;
	min-height:275px;
	margin-top:15px;
	}
div.ex1 {
  background-color: #ccc;
  position:relative; top:10px; left:10px; right:10px; bottom:10px;
  width: 760px;
  height: 235px;
  overflow: auto;
  padding:10px;
}	
</style>
<?php 

include("_js_import.php");?>
<form action="ajax_import_exec.php" method="post" name="frmEdit" onsubmit="return sendData();" enctype="multipart/form-data" target="uploadtarget555"><!--target="uploadtarget"-->
<table width="98%" border="0" cellspacing="5" cellpadding="0" class="txt" align="center">
  <tr>
    <td class="txt22 txt_left pad_left20 txt_white" height="55" valign="middle">Import ข้อมูลพนักงาน</td>
  </tr>
  <tr>
    <td align="center">
		<table width="100%" border="0" cellspacing="10" cellpadding="0" bgcolor="#FFFFFF">
		  <tr>
			<td bgcolor="#FFFFFF" height="400" valign="top">
				<table width="100%" border="0" cellspacing="10" cellpadding="0">
				  <tr>
					<td class="txt14">ระบบสร้างความสอดคล้องกันของข้อมูล ทำการเลือกไฟล์ข้อมูล(นามสกุล .xls, .xlsx) </td>
				  </tr>
				  <tr>
					<td>&nbsp;&nbsp;รูปแบบของคอลัมน์ที่จะนำข้อมูลเข้า จะต้องเรียงตามลำดับ ดังนี้</td>
				  </tr>
				  <tr>
					<td>
					<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#eaeaea">
					  <tr class="txt_center" bgcolor="#FFFFFF">
						<td width="30%" align="center" height="30" class="bd_solid_bottom txt_green_project">รายชื่อหน่วยงานหลัก</td>
						<td width="30%" align="center" class="bd_solid_bottom txt_green_project">รายชื่อหน่วยงานย่อยภายใต้การกำกับดูแล</td>
						<td width="30%" align="center" class="bd_solid_bottom txt_green_project">Email</td>
					  </tr>
					</table>

					</td>
				  </tr>
				  
				  <tr>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td><input name="QPic" id="QPic" type="file" onchange="Already()" />&nbsp;
					<input name="cmdWork" type="submit" value="ประมวลผล" class="btn_upload" onclick="return CheckFill()" />
					</td>
				  </tr>
				  <tr>
					<td>
					<table width="980" border="0" cellspacing="5" cellpadding="0">
					  <tr>
						<td align="top" valign="left">
							<div class="bd">
								<div id="mydiv" class="ex1 txt13">&nbsp;</div>
							</div>
						</td>
						
					  </tr>
					</table>

					<input name="hidMsg" id="hidMsg" type="hidden" value="" />
					<span class="txt txt_bold fhide" id="msg"></span>
					<iframe id="uploadtarget" name="uploadtarget" src="" style="width:0px; height:0px; border:0;"></iframe>
					</td>
				  </tr>
				</table>

			</td>
		  </tr>
		</table>

	</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
</table>
</form>