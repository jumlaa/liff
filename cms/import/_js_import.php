<script language="javascript">
function CheckFill(){
	if(document.getElementById("QPic").value==""){
		alert("คุณยังไม่ได้เลือกไฟล์ !!!"); document.getElementById("QPic").focus(); return false;
	}
	return true;
}
function sendData(){
	var mydiv = document.getElementById("mydiv");
	if(mydiv.value!=""){
		mydiv.innerHTML = "กรุณารอสักครู่ ระบบกำลังประมวลผล...";
		document.getElementById("msg").innerHTML = "";
	}
	return true;
}
function Already(){
	var qpic = document.getElementById("QPic");
	var mydiv = document.getElementById("mydiv");
	if(mydiv.value!=""){
		mydiv.innerHTML = "พร้อมประมวลผล...";
		document.getElementById("msg").innerHTML = "";
	}
}
function editDataOK(flag, error_msg){ //alert("flag = "+flag+"-----error_msg = "+error_msg);
	var msg ="";
	if(flag=='success'){
			msg = "<span class=txt_blue><?=SAVE_COMPLETED?></span>";
	}else{
			msg = "<span class=txt_red><?=SAVE_FAIL?></span>";
	}
	document.getElementById("msg").innerHTML = error_msg;
	document.getElementById("mydiv").innerHTML = error_msg;
	return true;
}
</script>