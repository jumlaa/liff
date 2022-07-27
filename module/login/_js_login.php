<script language="javascript">
    //ปิด dialog Confirm From Resubmission
    if (window.history.replaceState) {
        window.history.replaceState( null, null, window.location.href );
    }
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
	
	function Clear_Msg(){
		document.getElementById("msg_name").innerHTML = "";
		document.getElementById("msg_lastname").innerHTML = "";
		document.getElementById("msg_email").innerHTML = "";
		document.getElementById("msg_org").innerHTML = "";
		document.getElementById("msg_org_sub").innerHTML = "";
		document.getElementById("msg").innerHTML = "";
	}
	function CheckDup_Email(){
		HttPRequest = new XMLHttpRequest();
		HttPRequest.open("POST", "module/login/_ajax_checkdup_email.php", true);
		var pmeters = "email="+encodeURI(trim(document.getElementById("txtEmail").value));
		//alert(pmeters);
		HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		HttPRequest.setRequestHeader("Content-length", pmeters.length);
		HttPRequest.setRequestHeader("Connection", "close");
		HttPRequest.send(pmeters);
		HttPRequest.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) { 
			//alert("responseText= "+HttPRequest.responseText);
			var data = HttPRequest.responseText; 
			var obj = JSON.parse(data);
			//alert(obj.flag);
			if(obj.flag=="duplicate_email"){
				document.getElementById("msg_email").innerHTML = "มีอีเมลล์นี้อยู่ในระบบแล้ว ไม่สามารถทำการลงทะเบียนซ้ำได้ !!!";
				document.getElementById('txtEmail').focus();
				return;
			}else{
				return true;
			}
		 }
		};
	}

	function CheckFill(){
		Clear_Msg();
		if(trim(document.getElementById("txtName").value)==''){
			document.getElementById("msg_name").innerHTML = "คุณยังไม่ได้ป้อน ชื่อ !!!";
			document.getElementById("txtName").focus(); return false;	} 
		if(trim(document.getElementById("txtLastname").value)==''){
			document.getElementById("msg_lastname").innerHTML = "คุณยังไม่ได้ป้อน นามสกุล !!!";
			document.getElementById("txtLastname").focus(); return false;	} 		
			
		if(trim(document.getElementById("txtEmail").value)==''){
				document.getElementById("msg_email").innerHTML = "คุณยังไม่ได้ป้อน อีเมลล์ !!!";
				document.getElementById('txtEmail').focus(); return false; }
		
		if(trim(document.getElementById("txtEmail").value)!=''){
			if(checkemail(document.getElementById('txtEmail').value)){
				document.getElementById("msg_email").innerHTML = "คุณป้อนอีเมลล์ ไม่ถูกต้อง !!!";
				document.getElementById('txtEmail').focus(); return false;
			}
		}
		
		if(trim(document.getElementById("cboOrg").value)=='-999'){
				document.getElementById("msg_org").innerHTML = "คุณยังไม่ได้เลือก หน่วยงานหลัก !!!";
				document.getElementById('cboOrg').focus(); return false; }
		
		if(trim(document.getElementById("cboOrg_Sub").value)=='-999'){
				document.getElementById("msg_org_sub").innerHTML = "คุณยังไม่ได้เลือก หน่วยงานย่อยภายใต้การกำกับดูแล !!!";
				document.getElementById('cboOrg_Sub').focus(); return false; }	
					
		if(trim(document.getElementById("txtEmail").value)!=''){
			if(CheckDup_Email()==false){
				return false;
			}
		}
		return true;
	}
	
	function checkemail(str){
		var emailFilter=/^.+@.+\..{2,3}$/;
		//var str=document.form.text1.value;alert(str);
		if (!(emailFilter.test(str))) { 
			   //alert ("ท่านใส่อีเมล์ไม่ถูกต้อง");
			   return true;
		}
		return false;
	}
	function trim(myString){
		return myString.replace(/^\s*|\s*$/g,'');
	}	
	
	
    </script>


    <script language="javascript">
   

    function LoginOK() { //alert("flag="+flag);
       
    }

    function redirect() {
        //window.location.reload(true);
        window.location.href = "../../index.php";

    }

    function SubmitForm() {
        document.getElementById('myform_login').submit();
        //this.myform.submit();
    }


    function toCheckFill() {
        document.getElementById('cmdSubmit').onkeypress = function(e) {
            if (!e) e = window.event; // resolve event instance
            if (e.keyCode == '13') {
                CheckFill_Login('<?=@$_SESSION['lang'];?>');
                return false;
            }
        }
    }
	
	
	function Load_Org_Sub(){
		HttPRequest = new XMLHttpRequest();
		HttPRequest.open("POST", "module/login/_ajax_load_org_sub.php", true);
		var pmeters = "org_id="+encodeURI(document.getElementById("cboOrg").value);
		//alert(pmeters);
		HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		HttPRequest.setRequestHeader("Content-length", pmeters.length);
		HttPRequest.setRequestHeader("Connection", "close");
		HttPRequest.send(pmeters);
		HttPRequest.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) { 
			//alert("responseText= "+HttPRequest.responseText);
			var data = HttPRequest.responseText; 
			var obj = JSON.parse(data);
			//alert(obj.sql);
			if(obj.flag=="success"){
				document.getElementById("cboOrg_Sub").innerHTML = obj.str;
			}
		 }
		};
	}
    </script>