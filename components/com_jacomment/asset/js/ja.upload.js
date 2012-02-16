function changeBackground(obj){
		//obj.parentNode.parentNode.className = obj.parentNode.parentNode.className + " " +'focused';
}
	
function changeBackgroundNone(obj){
	//obj.parentNode.parentNode.className = obj.parentNode.parentNode.className.replace("focused", "");
}
function in_array(needle, haystack, strict) {
	for(var i = 0; i < haystack.length; i++) {
		if(strict) {
			if(haystack[i] === needle) {
				return true;
			}
		} else {
			if(haystack[i] == needle) {
				return true;
			}
		}
	}

	return false;
}
function checkTypeFile(value, action, id){		
	var pos = value.lastIndexOf('.');
	var type = value.substr(pos+1, value.length).toLowerCase();
	if(!in_array(type, JACommentConfig.v_array_type, false)){			
		if(action == "admin"){			
			document.getElementById('err_myfile_reply').style.display = "block";			
		}else if(action == "edit"){				
			document.getElementById('err_myfileedit').innerHTML = "<span class='err' style='color:red;'>"+JACommentConfig.error_type_file+"<\/span>" +"<br />";
		}else{			
			document.getElementById('err_myfile').innerHTML = "<span class='err' style='color:red;'>"+JACommentConfig.error_type_file+"<\/span>" +"<br />";		
		}
		return false;
	}
	
	var fileName = value.substr(0, pos+1).toLowerCase();
	if(fileName.length > 100){
		if(action == "admin"){			
			document.getElementById('err_myfile_reply').style.display = "block";			
		}else if(action == "edit"){				
			document.getElementById('err_myfileedit').innerHTML = "<span class='err' style='color:red;'>"+JACommentConfig.error_name_file+"<\/span>" +"<br />";
		}else{			
			document.getElementById('err_myfile').innerHTML = "<span class='err' style='color:red;'>"+JACommentConfig.error_name_file+"<\/span>" +"<br />";		
		}
		return false;
	}
	return true;
}	

function checkTotalFile(){		
	var listFiles =  $("result_upload").getElements('input[name^=listfile]');	
	var currentTotal = 0;
	for(i = 0 ; i< listFiles.length; i++){		
		if(listFiles[i].checked == true){
			currentTotal+=1;
		}
	}	
	if(currentTotal < JACommentConfig.total_attach_file){		
		document.getElementById('myfile').disabled = false;
		for(i = 0 ; i< listFiles.length; i++){
			if(listFiles[i].checked == false){
				listFiles[i].disabled = false;
			}
		}
	}else{		
		document.getElementById('myfile').disabled = true;
		for(i = 0 ; i< listFiles.length; i++){
			if(listFiles[i].checked == false){
				listFiles[i].disabled = true;
			}
		}	
	}
}

function checkTotalFileEdit(action){		
	action = "edit";	
	var listFiles =  $("result_upload" + action).getElements('input[name^=listfile]');	
	var currentTotal = 0;
	for(i = 0 ; i< listFiles.length; i++){		
		if(listFiles[i].checked == true){
			currentTotal+=1;
		}
	}	
	if(currentTotal < JACommentConfig.total_attach_file){		
		document.getElementById('myfile'+action).disabled = false;
		for(i = 0 ; i< listFiles.length; i++){
			if(listFiles[i].checked == false){
				listFiles[i].disabled = false;
			}
		}
	}else{		
		document.getElementById('myfile'+action).disabled = true;
		for(i = 0 ; i< listFiles.length; i++){
			if(listFiles[i].checked == false){
				listFiles[i].disabled = true;
			}
		}	
	}
}


function startUpload(id){				
	if(!checkTypeFile(document.form1.myfile.value)) return false;	
	document.form1.setAttribute( "autocomplete","off" );
	document.form1.action = "index.php?tmpl=component&option=com_jacomment&view=comments&task=uploadFile";		
	document.form1.target = "upload_target";
	document.getElementById('jac_upload_process').style.display='block';
	document.form1.submit();
}

function startEditUpload(id){						
	if(!checkTypeFile(document.form1edit.myfileedit.value, "edit")) return false;	
	document.form1edit.setAttribute( "autocomplete","off" );		
	document.form1edit.action = "index.php?tmpl=component&option=com_jacomment&view=comments&task=uploadFileEdit&id="+id;	
	document.form1edit.target = "upload_target";
	document.getElementById('jac_upload_processedit').style.display='block';
	document.form1edit.submit();	
}			

function startAdminUpload(id){	
	if(!checkTypeFile(document.formreply.myfile.value, "admin", id)) return false;			
	document.formreply.setAttribute( "autocomplete","off" );	
	document.formreply.action = "index.php?tmpl=component&option=com_jacomment&view=comments&task=uploadFileReply";
	document.formreply.target = "upload_target";
	document.getElementById('upload_process_1_reply').style.display='block';
	document.formreply.submit();
}