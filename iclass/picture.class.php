<?PHP
class picture{
	var $pic_filename = "";
	var $dirsite = "./";
	 
	 
	function __construct() {
		if(!file_exists("images/no_picture.gif")){ 
			if(@copy("images/no_picture2.gif", "images/no_picture.gif")!="1"){
				@copy("../../images/no_picture2.gif", "../../images/no_picture.gif");
			}
		}
	}
	function CheckPicture_Type($file, &$file_type, &$flag_type){ // ตรวจสอบนามสกุลรูปภาพ
		if($file['name'] != "")
		{ 		
				$flag = "true";
				$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "<BR><BR>Picture type = ".$QPic_type;
				if ( $QPic_type == ".png" )  {$file_type = ".png"; $flag_type=0; $flag = "true";}
				elseif ( $QPic_type == ".gif" )  {$file_type = ".gif"; $flag_type=0; $flag = "true";}
				elseif ( $QPic_type == ".bmp" )  {$file_type = ".bmp"; $flag_type=0; $flag = "true";}
				elseif( $QPic_type==".jpg" || $QPic_type==".jpeg" || $QPic_type==".pjpeg" || $QPic_type==".JPG" ){ $file_type = ".jpg";  $flag_type=0; $flag = "true";}
				else{ $flag = "file_type_invalid"; } 
				//echo "<br>QPic_type -> ".$QPic_type." and flag = ".$flag."=========<br>";
				return $flag;
		}else{
			return "false";
		} 
	}
	
	function CheckDoc_Type($file, &$file_type, &$flag_type){// ตรวจสอบนามสกุลไฟล์
		if($file['name'] != "")
		{ 	
				$flag = "false";
				$real_name = $file["name"];
				$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "type = ".$QPic_type;
				if( $QPic_type==".docx" || $QPic_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ){ $filename=strtolower($real_name.'.docx'); $file_type = ".docx"; $flag = "true"; }
				elseif ( $QPic_type == ".xls" || $QPic_type == ".xlsx" ){ $filename=strtolower($real_name.$QPic_type); $file_type = $QPic_type; $flag = "true"; }
				elseif( $QPic_type==".txt" || $QPic_type=="text/plain" ){ $filename=strtolower($real_name.'.txt'); $file_type = ".txt"; $flag = "true"; }
				elseif( $QPic_type==".pdf" || $QPic_type=="application/pdf" ){ $filename=strtolower($real_name.'.pdf'); $file_type = ".pdf"; $flag = "true"; }
				else{ $flag = "file_type_invalid"; } //echo "<br>".$QPic_type." flag = ".$flag;  exit();
				
				return $flag;
		}else{
			return "file_type_invalid";
		} 
	}
	function CheckPDF_Type($file){// ตรวจสอบนามสกุลไฟล์
		if($file['name'] != "")
		{ 	
				$flag = "false";
				$real_name = $file["name"];
				$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "type = ".$QPic_type;
				if( $QPic_type==".pdf" || $QPic_type=="application/pdf" || $QPic_type==".PDF" ){ $filename=strtolower($real_name.'.pdf'); $file_type = ".pdf"; $flag = "true"; }
				else{ $flag = "file_type_invalid"; } //echo "<br>".$QPic_type." flag = ".$flag;  exit();
				
				return $flag;
		}else{
			return "file_type_invalid";
		} 
	}
	
	
	function CheckDocument_Type($file, &$file_type, &$flag_type){// ตรวจสอบนามสกุล ใช้สำหรับการอัพโหลดเอกสารพวก สำเนาบัตรประชาชน
		if($file['name'] != "")
		{ 		
				$flag = "true";
				#แปลงนามสกุล และทำการ upload
				$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "type = ".$QPic_type;
				
				$file_type = $QPic_type;
				
				if ( $QPic_type == ".png" )  {$file_type = ".png"; $flag_type=0; $flag = "true";}
				elseif ( $QPic_type == ".gif" )  {$file_type = ".gif"; $flag_type=0; $flag = "true";}
				elseif ( $QPic_type == ".bmp" )  {$file_type = ".bmp"; $flag_type=0; $flag = "true";}
				elseif ( $QPic_type == ".jpg" || $QPic_type == ".jpeg" || $QPic_type==".JPG" ){ $file_type = ".jpg";  $flag_type=0; $flag = "true";}
				
				elseif ( $QPic_type == ".pdf" )  {$file_type = ".pdf"; $flag_type=2; $flag = "true"; }
				
				
				elseif ( $QPic_type==".docx" || $QPic_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ){ $file_type = ".docx";  $flag_type=2; $flag = "true"; }
				elseif ( $QPic_type == ".xls" || $QPic_type == ".xlsx" )  {$file_type = $QPic_type; $flag_type=2; $flag = "true"; }
			
				elseif( $QPic_type==".txt" || $QPic_type=="text/plain" ){ $file_type = ".txt"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".pdf" || $QPic_type=="application/pdf" ){ $file_type = ".pdf"; $flag_type=2; $flag = "true"; }
				
				else{ echo $flag = "file_type_invalid"; } //echo "<br>".$QPic_type." flag = ".$flag;  exit();
				
				return $flag;
		}else{
			return "file_type_invalid";
		} 
	}				
	
	function CheckUpload_Type($file, &$file_type, &$flag_type){// ตรวจสอบนามสกุล
		if($file['name'] != "")
		{ 		
				$flag = "true";
				#แปลงนามสกุล และทำการ upload
				$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "type = ".$QPic_type;
				
				$file_type = $QPic_type;
				
				if ( $QPic_type == ".png" || $QPic_type == "image/png" || $QPic_type == "image/x-png" )  {$file_type = ".png"; $flag_type=0; $flag = "true";}
				elseif ( $QPic_type == ".gif" ||  $QPic_type == "image/gif" )  {$file_type = ".gif"; $flag_type=0; $flag = "true";}
				elseif ( $QPic_type == ".bmp" ||  $QPic_type == "image/bmp" )  {$file_type = ".bmp"; $flag_type=0; $flag = "true";}
				elseif(( $QPic_type == ".jpg" || $QPic_type == ".jpeg" || $QPic_type=="image/jpg")||($QPic_type=="image/jpeg")||($QPic_type=="image/pjpeg")||($QPic_type=="image/JPG")||($QPic_type==".jpg")){ $file_type = ".jpg";  $flag_type=0; $flag = "true";}
				
				elseif ( $QPic_type==".swf" || $QPic_type == "application/x-shockwave-flash" ){ $file_type = ".swf"; $flag_type=1; $flag = "true";}
				elseif( $QPic_type==".wmv" || $QPic_type=="video/x-ms-wmv" ){ $file_type = ".wmv"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".wma" || $QPic_type=="audio/x-ms-wma" ){ $file_type = ".wma"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".mp3" || $QPic_type=="audio/mpeg" ){ $file_type = ".mp3"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".wav" || $QPic_type=="audio/wav"){ $file_type = ".wav"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".vob" || $QPic_type=="application/octet-stream" ){ $file_type = ".vob"; $flag_type=1; $flag = "true"; }
				
				elseif( $QPic_type==".txt" || $QPic_type=="text/plain" ){ $file_type = ".txt"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".pdf" || $QPic_type=="application/pdf" ){ $file_type = ".pdf"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".docx" ){ $file_type = ".txt"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".xlsx" || $QPic_type==".xls" ){ $file_type = ".xlsx"; $flag_type=2; $flag = "true"; }
				
				elseif( $QPic_type==".zip" || $QPic_type=="application/download" ){ $file_type = ".zip"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".rar" || $QPic_type=="application/x-rar-compressed" ){ $file_type = ".rar"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".7z" || $QPic_type=="application/octet-stream" ){ $file_type = ".7z"; $flag_type=2; $flag = "true"; }	
				else{ $flag = "file_type_invalid"; }
				//echo "<br>type=".$QPic_type."<br>";
				//echo "<br>CheckUpload_Type - flag=".$flag."<br>";
				
				return $flag;
		}else{
			return "true";
		} 
	}
	/*============================OLD VERSION=================================
	function CheckUpload_Type($file, &$file_type, &$flag_type){// ตรวจสอบนามสกุล
		if($file['name'] != "")
		{ 		
				$flag = "false";
				#แปลงนามสกุล และทำการ upload
				$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "type = ".$QPic_type;
				if ( $QPic_type == "image/png" || $QPic_type == "image/x-png" )  {$file_type = ".png"; $flag_type=0; $flag = "true";}
				elseif ( $QPic_type == "image/gif" )  {$file_type = ".gif"; $flag_type=0; $flag = "true";}
				elseif ( $QPic_type == "image/bmp" )  {$file_type = ".bmp"; $flag_type=0; $flag = "true";}
				elseif(($QPic_type=="image/jpg")||($QPic_type=="image/jpeg")||($QPic_type=="image/pjpeg")||($QPic_type=="image/JPG")||($QPic_type==".jpg")){ $file_type = ".jpg";  $flag_type=0; $flag = "true";}
				
				elseif ( $QPic_type==".swf" || $QPic_type == "application/x-shockwave-flash" ){ $file_type = ".swf"; $flag_type=1; $flag = "true";}
				elseif( $QPic_type==".wmv" || $QPic_type=="video/x-ms-wmv" ){ $file_type = ".wmv"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".wma" || $QPic_type=="audio/x-ms-wma" ){ $file_type = ".wma"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".mp3" || $QPic_type=="audio/mpeg" ){ $file_type = ".mp3"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".wav" || $QPic_type=="audio/wav"){ $file_type = ".wav"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".vob" || $QPic_type=="application/octet-stream" ){ echo "jjjjjjjjj"; $file_type = ".vob"; $flag_type=1; $flag = "true"; }
				
				elseif( $QPic_type==".txt" || $QPic_type=="text/plain" ){ $file_type = ".txt"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".pdf" || $QPic_type=="application/pdf" ){ $file_type = ".pdf"; $flag_type=2; $flag = "true"; }
				
				elseif( $QPic_type==".zip" || $QPic_type=="application/download" ){ $file_type = ".zip"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".rar" || $QPic_type=="application/x-rar-compressed" ){ $file_type = ".rar"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".7z" || $QPic_type=="application/octet-stream" ){ $file_type = ".7z"; $flag_type=2; $flag = "true"; }	
				else{ $flag = "file_type_invalid"; }
				echo "<br>type=".$QPic_type."<br>";
				echo "<br>CheckUpload_Type - flag=".$flag."<br>";
				
				return $flag;
		}else{
			return "true";
		} 
	}
	=====================================OLD VERSION================================================
	*/
	function CheckMedia_Type($file){// ตรวจสอบนามสกุล
		if($file['name'] != "")
		{ 		
				$flag = "false";
				#แปลงนามสกุล และทำการ upload
				$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "type = ".$QPic_type;
				if ( $QPic_type==".swf" || $QPic_type == "application/x-shockwave-flash" ){ $file_type = ".swf"; $flag_type=1; $flag = "true";}
				elseif( $QPic_type==".wmv" || $QPic_type=="video/x-ms-wmv" ){ $file_type = ".wmv"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".wma" || $QPic_type=="audio/x-ms-wma" ){ $file_type = ".wma"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".mp3" || $QPic_type=="audio/mpeg" ){ $file_type = ".mp3"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".wav" || $QPic_type=="audio/wav"){ $file_type = ".wav"; $flag_type=1; $flag = "true"; }
				elseif( $QPic_type==".vob" || $QPic_type=="application/octet-stream" ){ $file_type = ".vob"; $flag_type=1; $flag = "true"; }
				else{ $flag = "file_type_invalid"; }
				// echo "<br>type=".$QPic_type."<br>";
				return $flag;
		}else{
			return "file_type_invalid";
		} 
	}
	function CheckZip_Type($file, &$file_type, &$flag_type){// ตรวจสอบนามสกุล
		if($file['name'] != "")
		{ 		
				$flag = "false";
				#แปลงนามสกุล และทำการ upload
				$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "type = ".$QPic_type;
				if( $QPic_type==".zip" || $QPic_type=="application/download" ){ $file_type = ".zip"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".rar" || $QPic_type=="application/x-rar-compressed" ){ $file_type = ".rar"; $flag_type=2; $flag = "true"; }
				elseif( $QPic_type==".7z" || $QPic_type=="application/octet-stream" ){ $file_type = ".7z"; $flag_type=2; $flag = "true"; }	
				else{ $flag = "file_type_invalid"; }
				return $flag;
		}else{
			return "file_type_invalid";
		} 
	}
	
	function GetFile_Name($file, $_path){
		putenv("TZ=Asia/Bangkok");
		$this_year = date("Ymd");
		$filename = "";
		//echo "<br>file = ".$file['name']."<br>";
		if($file['name'] != ""){
			$real_name = substr($file['name'],0,strpos($file['name'],".")); 
			$Pic_name = substr ($real_name, -4);
			srand((double)microtime()*1000000); 
			$QPic_name=$random_pic = rand(1,99999); 
			putenv("TZ=Asia/Bangkok");
			$this_year = date("Ymd");
			
			#ตรวจสอบขนาดของรูป
			#แปลงนามสกุล และทำการ upload
		    //$QPic_type = $file["type"]; 
			$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "type = ".$QPic_type;
			/*
			if ( $QPic_type == "image/png" || $QPic_type == "image/x-png" )  {$filename = strtolower($QPic_name.".png"); }
			elseif ( $QPic_type == "image/gif" )  {$filename = strtolower($QPic_name.".gif"); }
			elseif ( $QPic_type == "image/bmp" )  {$filename = strtolower($QPic_name.".bmp"); }
			elseif(($QPic_type=="image/jpg")||($QPic_type=="image/jpeg")||($QPic_type=="image/pjpeg")||($QPic_type=="image/JPG")){ $filename = strtolower($QPic_name.'.jpg'); }
			*/

			if ( $QPic_type == "image/png" || $QPic_type == "image/x-png" )  {$filename = strtolower($real_name.".png"); }
			elseif ( $QPic_type == "image/gif" )  {$filename = strtolower($real_name.".gif"); }
			elseif ( $QPic_type == "image/bmp" )  {$filename = strtolower($real_name.".bmp"); }
			elseif(($QPic_type=="image/jpg")||($QPic_type=="image/jpeg")||($QPic_type=="image/pjpeg")||($QPic_type=="image/JPG"||($QPic_type==".jpg"))){ $filename = strtolower($real_name.'.jpg'); }

			elseif( $QPic_type==".docx" || $QPic_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ){ $filename=strtolower($real_name.'.docx'); }
			elseif( $QPic_type==".swf" || $QPic_type == "application/x-shockwave-flash" ){ $filename=strtolower($real_name.'.swf'); }
			elseif( $QPic_type==".wmv" || $QPic_type=="video/x-ms-wmv" ){ $filename=strtolower($real_name.'.wmv'); }
			elseif( $QPic_type==".wma" || $QPic_type=="audio/x-ms-wma" ){ $filename=strtolower($real_name.'.wma'); }
			elseif( $QPic_type==".mp3" || $QPic_type=="audio/mpeg" ){ $filename=strtolower($real_name.'.mp3'); }
			elseif( $QPic_type==".wav" || $QPic_type=="audio/wav"){ $filename=strtolower($real_name.'.wav'); }
			elseif( $QPic_type==".vob" || $QPic_type=="application/octet-stream" ){ $filename=strtolower($real_name.'.vob'); }
				
			elseif( $QPic_type==".txt" || $QPic_type=="text/plain" ){ $filename=strtolower($real_name.'.txt'); }
			elseif( $QPic_type==".pdf" || $QPic_type=="application/pdf" ){ $filename=strtolower($real_name.'.pdf'); }
			
			elseif( $Pic_name==".zip" || $QPic_type=="application/download" ){ $filename=strtolower($real_name.'.zip'); }
			elseif( $Pic_name==".rar" || $QPic_type=="application/x-rar-compressed" ){ $filename=strtolower($real_name.'.rar'); }
			elseif( $QPic_type==".7z" || $QPic_type=="application/octet-stream" ){ $filename=strtolower($real_name.'.7z'); }
			else{ echo $flag = "file_type_invalid"; }
			//echo "<br>type=".$QPic_type."<br>";	
			//echo "<br>path= ".$_path.$filename;
			$filename = $_path.$this_year."_".$filename; //echo "path = ".$filename."<br>";
			$bad_chars = array('\\' , '[' , ']' , '@' , '#' , '!' , '{' , '}' , '&' , '฿', '+' , 'http');
			for ($i=0 ; $i<sizeof($bad_chars) ; $i++) {
					$filename = str_replace($bad_chars[$i],"",$filename);
			}	
			$filename = str_replace(" ", "_", $filename);
			return $filename;
		}
		return "images/no_picture.gif";
	}
	function GenFile_Name($file, $_path, $txt){//txt = คำแปะหน้าไฟล์ บอกให้รู้ว่าเป็นไฟล์เกี่ยวกับอะไร
		putenv("TZ=Asia/Bangkok");
		$this_year = date("Ymd");
		//echo "<br>file = ".$file['name']."<br>";
		if($file['name'] != ""){
			$real_name = substr($file['name'],0,strpos($file['name'],".")); 
			$Pic_name = substr ($real_name, -4);
			srand((double)microtime()*1000000); 
			$QPic_name = $random_pic = rand(1,9999999); 
			
			putenv("TZ=Asia/Bangkok");
			$this_year = date("Ymd");
			#ตรวจสอบขนาดของรูป
			#แปลงนามสกุล และทำการ upload
		    //$QPic_type = $file["type"];
			$QPic_type	= $this->GetFile_Lastname($file['name']);
			
			$filename = $_path.$this_year."_".$QPic_name.$QPic_type; 
		
			$bad_chars = array('\\' , '[' , ']' , '@' , '#' , '!' , '{' , '}' , '&' , '฿', '+' , 'http');
			for ($i=0 ; $i<sizeof($bad_chars) ; $i++) {
					$filename = str_replace($bad_chars[$i],"",$filename);
			}	
			
			$filename = str_replace(" ", "_", $filename);
			$filename = str_replace("//", "/", $filename);
			$filename."<br><hr></p>";
			return $filename;
		}
		return "images/no_picture.gif";
	}
	function GetPicture_Name($file, $_path){
		putenv("TZ=Asia/Bangkok");
		$this_year = date("Ymd");
		
		if($file['name'] != ""){
			$Pic_name = substr ($file['name'], -4); 
			//srand((double)microtime()*1000000); 
			$QPic_name=$random_pic = rand(1,99999); 
			#ตรวจสอบขนาดของรูป
			#แปลงนามสกุล และทำการ upload
			#แปลงนามสกุล และทำการ upload
			$QPic_type	= $this->GetFile_Lastname($file['name']); //echo "type = ".$QPic_type;
			if ( $QPic_type == "image/png" ){$filename = strtolower($QPic_name.".png");	}
			if ( $QPic_type == "image/x-png" ){$filename = strtolower($QPic_name.".png"); }
			if ( $QPic_type == "image/gif" ){$filename = strtolower($QPic_name.".gif");	}
			if ( $QPic_type == "image/bmp" ){$filename = strtolower($QPic_name.".bmp");	}
	
			
			elseif(($QPic_type=="image/jpg")||($QPic_type=="image/jpeg")||($QPic_type=="image/pjpeg")||($QPic_type=="image/JPG")||($QPic_type==".jpg"))	
				{
					$filename = strtolower($QPic_name.'.jpg');
				}
			//echo "<br>type=".$QPic_type."<br>";	
			//echo "<br>path= ".$_path.$filename;
			$pic_filename = $this_year."_".$filename;
			$filename = $_path.$this_year."_".$filename; //echo "path = ".$filename."<br>";
			return $filename;
		}
		return "images/no_picture.gif";
	}
	function GetPic_Filename(){
		return trim($pic_filename);
	}
	function CheckFile_Limit($file, $_path, $file_limit){ //echo "<p>CheckFile_Limit -> file_limit = ".$file_limit."</p>";
		$limit = $this->Get_File_Limit($file_limit);
		$upload_size = $file['size'];
		if($file['name']!=""){
			if($upload_size!="" && $upload_size!=0){
				if($upload_size > $limit){ //$flimit_upload อยู่ใน constant.php //---(3) ตรวจสอบขนาดไฟล์
						$flag = "over_limit_upload";
						return $flag;
				}//---(3) ตรวจสอบขนาดไฟล์
				else{ return "true";}
			}else{
				$flag = "over_limit_upload";
				return $flag;
			}
		}else{
			$flag = "fail";
			return $flag;
		}			
		/*===============================
		$filename = $this->GetFile_Name($file, $_path);
		if($filename!=''){
			$fileName = $filename; 
			copy($file['tmp_name'],$fileName);
			$size = filesize($filename); // หาขนาดไฟล์เป็น Byte
			@unlink($filename);
			//echo "<br>size_cap = ".	$size_cap = $iofile->GetFileSize($size);
			//echo "flimit_upload= ". $flimit_upload;
			if($size > $limit){ //$flimit_upload อยู่ใน constant.php //---(3) ตรวจสอบขนาดไฟล์
				$flag = "over_limit_upload";
				return $flag;
			}//---(3) ตรวจสอบขนาดไฟล์
			else{ return "true";}
			
		}else{ return "true";}
		*/
	}
	function Get_File_Limit($file_limit){
		$flimit_upload = $file_limit * (1000*1024); //ขนาดไฟล์สูงสุดที่ยอมให้ Upload
		return $flimit_upload;
	}
	function CheckFile_Limit_Member($file, $_path){
		include($this->dirsite."config.php");// ห้ามเอา $this->dirsite ออก
		$filename = $this->GetPicture_Name($file, $_path);
		if($filename!=''){
			$fileName = $filename; 
			copy($file['tmp_name'],$fileName);
			$size = filesize($filename); // หาขนาดไฟล์เป็น Byte
			@unlink($filename);
			//echo "<br>size_cap = ".	$size_cap = $iofile->GetFileSize($size); 
			if($size > $flimit_upload_display){ //$flimit_upload อยู่ใน constant.php //---(3) ตรวจสอบขนาดไฟล์
				echo $flag = "over_limit_upload";
				return $flag;
			}//---(3) ตรวจสอบขนาดไฟล์
			else{ return "true";}
			
		}else{ return "true";}
	}
	function CheckFile_Limit_Module($file, $_path){//echo "path = ".$_path;
	
		include($this->dirsite."config.php"); // ห้ามเอา $this->dirsite ออก
		$filename = $this->GetPicture_Name($file, $_path);
		if($filename!=''){
			$fileName = $filename; 
			copy($file['tmp_name'],$fileName);
			$size = filesize($filename); // หาขนาดไฟล์เป็น Byte
			@unlink($filename);
			//echo "<br>size_cap = ".	$size_cap = $iofile->GetFileSize($size); 
			if($size > $flimit_upload){ //$flimit_upload อยู่ใน constant.php //---(3) ตรวจสอบขนาดไฟล์
				echo $flag = "over_limit_upload";
				return $flag;
			}//---(3) ตรวจสอบขนาดไฟล์
			else{ return "true";}
			
		}else{ return "true";}
	}
	function CheckNo_File($path){
		if($path=="" || $path=="images/no_picture.gif"){
			return "true";
		}else{
			return "false";
		}
	}
	function Copy_File($file, $path){ 
		if( $file['name'] != "" ) { $fileName1 = $path;	copy($file['tmp_name'],$fileName1); @unlink($file['tmp_name']); }
	}
	function Image_Preview($address, $img, $width, $height){
		$image = $address.$img;
		$nphoto_size = @getimagesize($image);
		
		if(trim($image)!="" && $nphoto_size[0]!=""){
			echo "<a href='$image' class='highslide' onclick='return hs.expand(this)'>";
			echo "<img src='$image' border='0'  width='$width' height='$height' /></a>";
		}else{
			echo "<a href='".NO_PICTURE."' class='highslide' onclick='return hs.expand(this)'>";
			echo "<img src='".NO_PICTURE."' border='0' width='$width' height='$height'/></a>";
		}
	}
	function Show_Pic($path, $file_path, $name, $size){
		$file = $path.$file_path;
		$nphoto_size = @getimagesize($file);
		if($nphoto_size[0]!="" && $file_path!=NO_PICTURE){
			echo '<a href='.$file.' class="highslide" onclick="return hs.expand(this)">';
			echo "<img src='$file' alt='$name' border='0' ";
			$ww = $nphoto_size['0'];
			$hh = $nphoto_size['1'];
			
			
			if($ww>$size) {  echo "width='$size'"; }
			echo "/></a>";
		}else{
			echo "<a href='".$this->dirsite.NO_PICTURE."' class='highslides' onclick='return hs.expand(this)'><img src='".$this->dirsite.NO_PICTURE."' border='0' /></a>";
		}
	}
	function Show_File( $name ){
		if($name=="" || $name=="images/no_file.gif"){
			//echo "<img src='images/bullet/icdownload.gif' border='0' title='$name' >";
			//echo "<span class='txt_red'>ไม่มีไฟล์</span>";
			echo "<img src='images/bullet/download_disable.png' border='0' title='ไม่มีไฟล์' >";
		}else{
			require_once("iclass/encrypt.class.php");
			$enc = new encrypt;
			$name_str = str_replace("/", "#", $name);
		
			$name_enc = $enc->coeec2($name_str);
			echo "<a href='downloader.php?filename=$name_enc'><img src='images/bullet/download.png' border='0' ></a>";
		}
	}
	function Show_Doc( $name ){
		$lastname = $this->GetFile_Lastname($name);
		if($name=="" || $name=="images/no_picture.gif"){
			echo "<img src='images/icon/ic_notepad_disable.png' border='0' title='$name' >";
		}else{
		switch($lastname){
			case ".docx" : echo "<img src='images/icon/ic_word.png' border='0' title='$name'>"; break;
			case ".txt" : echo "<img src='images/icon/ic_txt.png' border='0' title='$name'>"; break;
			case ".pdf" : echo "<img src='images/icon/ic_pdf.png' border='0' title='$name'>"; break;
		}
		}
	}
	function Show_Media( $name ){
		if($name=="" || $name=="images/no_picture.gif"){
			echo "<img src='images/icon/ic_media_disable.png' border='0' title='$name' >";
		}else{
			echo "<img src='images/icon/ic_media.png' border='0' title='$name' >";
		}
	}
	function Show_Zip( $name ){
		if($name=="" || $name=="images/no_picture.gif"){
			echo "<img src='images/icon/ic_zip_disable.png' border='0' title='$name' >";
		}else{
			echo "<img src='images/icon/ic_zip.png' border='0' title='$name' >";
		}
	}
	function Show_Application( $name ){
		if($name=="" || $name=="images/no_picture.gif"){
			echo "<img src='images/icon/ic_app_disable.png' border='0' title='$name' >";
		}else{
			echo "<img src='images/icon/ic_app.png' border='0' title='$name' >";
		}
	}
	function GetFile_Type($file_name){
		$info = pathinfo( $file_name , PATHINFO_EXTENSION ) ;
		return ".".$info ;
	}
	function GetFile_Lastname($file){
		$extension = strtolower(strrchr( $file , '.' ));
		return $extension;
	}
	
	function File_Exist($path, $file_path){
		echo $file = $path.$file_path;
		$nphoto_size = @getimagesize($file);
		if($nphoto_size[0]!=""){
			return "true";
		}else{
			return "false";
		}
	}
	
	function smartReadFile($location, $filename, $mimeType='application/octet-stream')
	{ if(!file_exists($location))
	  { header ("HTTP/1.0 404 Not Found");
		return;
	  }
	  
	  $size=filesize($location);
	  $time=date('r',filemtime($location));
	  
	  $fm=@fopen($location,'rb');
	  if(!$fm)
	  { header ("HTTP/1.0 505 Internal server error");
		return;
	  }
	  
	  $begin=0;
	  $end=$size;
	  
	  if(isset($_SERVER['HTTP_RANGE']))
	  { if(preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches))
		{ $begin=intval($matches[0]);
		  if(!empty($matches[1]))
			$end=intval($matches[1]);
		}
	  }
	  
	  if($begin>0||$end<$size)
		header('HTTP/1.0 206 Partial Content');
	  else
		header('HTTP/1.0 200 OK');  
	  
	  header("Content-Type: $mimeType"); 
	  header('Cache-Control: public, must-revalidate, max-age=0');
	  header('Pragma: no-cache');  
	  header('Accept-Ranges: bytes');
	  header('Content-Length:'.($end-$begin));
	  header("Content-Range: bytes $begin-$end/$size");
	  header("Content-Disposition: inline; filename=$filename");
	  header("Content-Transfer-Encoding: binary\n");
	  header("Last-Modified: $time");
	  header('Connection: close');  
	  
	  $cur=$begin;
	  fseek($fm,$begin,0);
	
	  while(!feof($fm)&&$cur<$end&&(connection_status()==0))
	  { print fread($fm,min(1024*16,$end-$cur));
		$cur+=1024*16;
	  }
}
function Unlink_File($path, $file){
	if($file!="images/no_picture.gif"){ 
		@unlink($path.$file);
	}
	return "images/no_picture.gif";
}
function Delete_Picture($path, $file){
	if($file!="images/no_picture.gif"){
		@unlink($path.$file);
	}
}
function Delete_File($path, $file){
	if($file!="images/no_file.gif"){
		@unlink($path.$file);
	}
}

function uploadresizepicture($file, $tmp, $_height, $fileName){
	 $images = $tmp;
	 preg_match('/\.([A-Za-z]+?)$/', $file['name'], $matches);
					 if($matches[1] == 'png' && function_exists('imagecreatefrompng') || 
					 	$matches[1] == 'jpg' && function_exists('imagecreatefromjpeg') || 
						$matches[1] == 'jpeg' && function_exists('imagecreatefromjpeg') || 
						$matches[1] == 'gif' && function_exists('imagecreatefromgif')  || 
						$matches[1] == 'bmp' && function_exists('imagecreatefromwbmp')) {
			
			
						
						$height=$_height;
						$size=GetimageSize($images);
						$width=round($height*$size[0]/$size[1]);
						
						
						if($matches[1] == 'png')
							$original = imagecreatefrompng($tmp);
						if($matches[1] == 'jpg' || $matches[1] == 'jpeg')
							$original = imagecreatefromjpeg($tmp);
						if($matches[1] == 'gif')
							$original = imagecreatefromgif($tmp);
						if($matches[1] == 'bmp')
							$original = imagecreatefromwbmp($tmp);
								
						
						$photoX = ImagesX($original);
						$photoY = ImagesY($original); 
						$images_fin = imagecreatetruecolor($width, $height); 
						/******************************************************/
						imageSaveAlpha($images_fin, true);
						ImageAlphaBlending($images_fin, false);
						$transparentColor = imagecolorallocatealpha($images_fin, 255, 255, 255, 127);
						imagefill($images_fin, 0, 0, $transparentColor); 
						/******************************************************/
						imagecopyresampled($images_fin, $original, 0, 0, 0, 0, $width, $height, $photoX, $photoY); 
						//imagejpeg($images_fin,$fileName); // ชื่อไฟล์ใหม่
						/*
						$resized = imagecreatetruecolor($nwidth, $nheight);
						*/
						
						if($matches[1] == 'png')
							imagepng($images_fin,$fileName);
						if($matches[1] == 'jpg' || $matches[1] == 'jpeg')
							imagejpeg($images_fin,$fileName);
						if($matches[1] == 'gif')
							imagegif($images_fin,$fileName);
						if($matches[1] == 'bmp')
							imagewbmp($images_fin,$fileName);
						
						imagedestroy($original);
						imagedestroy($images_fin); 
						return "true";
					}else{
						return "false"; 
					}
}
}//end class
?>