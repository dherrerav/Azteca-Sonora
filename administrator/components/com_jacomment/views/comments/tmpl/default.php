<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>
<?php 	
$currentTypeID = $this->currentTypeID;
$items = $this->items;
$totalAll 			= $this->totalAll;
$totalApproved 		= $this->totalApproved;
$totalSpam 			= $this->totalSpam;
$totalUnApproved 	= $this->totalUnApproved;		
$statusdisplay 		= 0;
$lists 				= $this->lists; 
$keyword = $this->keyword;

$helper = new JACommentHelpers();

$arr = array(99, 0, 1, 2);
global $jacconfig;
$minLengthComment = isset($jacconfig["spamfilters"])?$jacconfig["spamfilters"]->get("min_length", 10):10;
$maxLengthComment = isset($jacconfig["spamfilters"])?$jacconfig["spamfilters"]->get("max_length", 200):200;
$isEnableAutoexpanding		= isset($jacconfig['comments'])?$jacconfig['comments']->get('is_enable_autoexpanding', 1):1;
$enableBbcode				= isset($jacconfig['layout'])?$jacconfig['layout']->get('enable_bbcode', 0):0;
//JHTML::_('stylesheet', 'temp.css',JURI::root().'administrator/components/com_jacomment/asset/css/');
jimport( 'joomla.filesystem.folder' );

$reported = JRequest::getInt('reported');
?>
<script type="text/javascript" charset="utf-8">
//<![CDATA[	
jQuery(document).ready(function($){	
	jav_init();	
});
minLengthComment = "<?php echo $minLengthComment;?>";
maxLengthComment = "<?php echo $maxLengthComment;?>";
jQuery(document).ready(function(){				
	jcomment_createTabs('#javtabs-main');
});				

var jav_base_url = '<?php echo JURI::base();?>';


/**
* Toggles the check state of a group of boxes
*
* Checkboxes must have an id attribute in the form cb0, cb1...
* @param The number of box to 'check'
* @param An alternative field name
*/
function checkAllComment( n, ischeck, fldName ) {  
  if (!fldName) {
	 fldName = 'cb';
  }		  	
  getCurrentTypeID = $("currentTypeID").value;
  arrayCheckBox = $('jav-mainbox-'+getCurrentTypeID).getElements('input[name^=cid]');
  arrayCheckBox.each(function(checkBox){
	  checkBox.checked = ischeck;		
  });	  	  
}

function isChecked(isitchecked){	
	currentType = $('currentTypeID').value;			
	if (isitchecked == true){
		$("boxchecked"+currentType).value++;	
	}
	else {
		$("checkAll"+currentType).checked = isitchecked;		
	}
}

Joomla.submitform = function(task, form) {
	submitbutton(task);
};


function JAsubmitbutton() {
    jQuery(document).ready(
        function($) {
            $('#jacomment-wait').css( {
                'display' :''
            });			
            $.post("index.php", $("#iContent").contents().find(
                    "#JAFrom").serialize(), function(res) {
						jaFormHideIFrame();
                        parseData_admin(res);
            }, 'json');
        }
    );
}

function submitbuttonAdmin() {	
	curentTypeID = $('currentTypeID').value;	
	var flag = checkError();
	if (flag) {
		jQuery(document).ready(
				function($) {
					$('#javoice-wait').css( {
						'display' :''
					});			
												
					$.post("index.php?curenttypeid=" + curentTypeID , $("#iContent").contents().find(
							"#adminForm").serialize(), function(res) {
						jaFormHideIFrame();
						parseData_admin(res);
					}, 'json');
				});
	}else
		alert("Invalid data! Please insert information again!");
}

function actionInTask(task, currentTypeID){
	jQuery(document).ready( function($) {
        id='#'+jav_header;
        $(id).css('z-index','1');        
        $('#loader').show();
    }); 
	type = getCodeTypeOfTab(task);	
	url = "index.php?option=com_jacomment&view=comments&type="+ type +"&layout=changetype&curenttypeid="+ currentTypeID +"&tmpl=component&displaymessage=show";
	
	if($('limitstart'+currentTypeID) != undefined){
		limitstart = $('limitstart'+currentTypeID).value;
		url += "&limitstart="+limitstart;
	}
	if($('list'+currentTypeID) != undefined){
		limit = $('list'+currentTypeID).value;		
		url += "&limit="+limit;
	}

	if($('keywordsearch') != undefined && $('keywordsearch').value != ""){
		url += "&keyword=" + $('keywordsearch').value;
	}
	
	if($('slComponent') != undefined && $('slComponent').value != ""){
		url += "&optionsearch=" + escape($('slComponent').value);		
	}
    if($('slSource') != undefined){
        url += "&sourcesearch=" + escape($('slSource').value);        
    }
	
	if($('jacReported') != undefined){
		if($('jacReported').checked == true)
			url += "&reported=" + escape($('jacReported').value);        
	}	
	
    url = getUrlSort(url);
		
	jQuery(document).ready( function($) {
		//url += "&"+$("#adminForm" + currentTypeID).serialize();
		url = getCheckBoxSelected(url, "delete");		
						
		jQuery.getJSON(url, function(response){
			jav_parseData(response);
			var reload = 0;
			
			//for(j=0;j<4;j++){
           jQuery.each( [99, 0,1,2], function(j, n){
               
				if(n != currentTypeID){						
					clicked = $("#jav-typeid_" + n).attr('class');									
					if(clicked.indexOf('loaded') != -1){
						$("#jav-typeid_" + n).removeClass('loaded');
					}
				}
            });
			//}				
			var myResponse = null;
			if(response.data){
				myResponse = response.data; 
			}else{
				myResponse = response;
			}
			jQuery.each(myResponse, function(i, item) {						
				
				var divId = item.id;
				var type = item.type;
				var value = item.content;
				if ($(divId) != undefined) {
					if (type == 'html') {
						if ($(divId)){
							$(divId).html(value);
						}
						else
							alert('not fount element');
					} else {
						if (type == 'reload') {
							if (value == 1)
								reload = 1;
						} else {
							if(type=='val'){
								$(divId).val(value);
							}else{
								$(divId).attr(type, value);
							}
						}
					}
				}
																	    	 				    					
			});
			
			if (reload == 1)
				window.document.adminForm.submit();
			else
				setTimeout("hiddenMessage()", 5000);
			
		 });
	});	
}

function submitbutton(task){
	if(task == "approve" || task == "unapprove" || task == "delete" || task == "spam"){						
		typeID = $("currentTypeID").value;
		arrayCheckBox = $("jav-mainbox-" + typeID).getElements('input[name^=cid]');
		
		for(i = 0; i< arrayCheckBox.length; i++){
			if(arrayCheckBox[i].checked == true){
				break;
			}
		}
		
		//if don't select comment
		if(i == arrayCheckBox.length){			
			alert($("hidSelectComment").value);
			return;
		}		
		
		if(task == "delete"){			
			var action  = confirm("Delete the selected comment?");
			if (!action) return;												
			//check sub of comment
			
			
			url = "index.php?option=com_jacomment&view=comments&type=delete&layout=checksubofcomment&curenttypeid="+ typeID +"&tmpl=component";			
			jQuery(document).ready( function($) {				
				//url += "&"+$("#adminForm" + typeID).serialize();
				url = getCheckBoxSelected(url);				
				jQuery.ajax({
					   type: "POST",
					   url: url,			   
					   success: function(msg){
						msg = jQuery.trim(msg);
						if(msg == "HASSUB"){
							 alert($("#hidYouMustDelete").val());
							 //alert("You must delete sub comment!");
					    	 return;
					     }else{
					    	 actionInTask(task, typeID);
					     }    
					   }
				});	
			});														
		}else{												
			actionInTask(task, typeID);
		}
  }			
}	
//]]>
</script>
<?php if($jacconfig["comments"]->get("is_enable_autoexpanding", 0)){?>
	<?php echo JHTML::script('jquery.autoresize.js', JURI::root().'components/com_jacomment/libs/js/jquery/');?>	
<?php }?>
<script type="text/javascript">
//<![CDATA[			
	var JACommentConfig = {				
		errorMaxLength 			: '<?php echo JText::_("YOUR_COMMENT_IS_TOO_LONG");?>',					
		isEnableAutoexpanding   : 0,		
		isEnableBBCode			: '<?php echo $enableBbcode;?>',
		textCheckSpelling		: '<?php echo JText::_("NO_WRITING_ERRORS_WERE_FOUND");?>'										
	};																	
//]]>
</script>
<script type="text/javascript" src="../components/com_jacomment/libs/js/dcode/dcodr.js"></script>
<script type="text/javascript" src="../components/com_jacomment/libs/js/dcode/dcode.js"></script>
<?php 
if($jacconfig["comments"]->get("is_attach_image", 0)){
	$attachFileType				= $jacconfig['comments']->get('attach_file_type', "doc,docx,pdf,txt,zip,rar,jpg,bmp,gif,png");
	$arrTypeFile = explode(",", $attachFileType);			
	$strListFile = "";
	if ($arrTypeFile) {
		foreach ($arrTypeFile as $type){
			$strListFile .= "'$type',";
		}
		$strListFile .= '0000000';
	}		
	$strTypeFile 				= JText::_("SUPPORT_FILE_TYPE").$attachFileType." ".JText::_("ONLY");
?>
<script type="text/javascript">	
	var v_array_type 	= [ <?php echo $strListFile;?> ];
	var error_type_file = "<?php echo $strTypeFile;?>"; 
	var error_name_file = "<?php echo JText::_("FILE_NAME_IS_TOO_LONG");?>"; 
</script>
<script language="javascript" type="text/javascript">
	<!--					
	function changeBackground(obj){		
		obj.parentNode.parentNode.className = 'focused';
	}
	
	function changeBackgroundNone(obj){		
		obj.parentNode.parentNode.className = '';
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

	function checkTypeFile(value){
		var pos = value.lastIndexOf('.');
		var type = value.substr(pos+1, value.length).toLowerCase();
				
		if(!in_array(type, v_array_type, false)){																	
				document.getElementById('err_myfile_reply').innerHTML = "<span class='err' style='color:red;'>"+error_type_file+"</span>" +"<br />";								
			return false;
		}
		
		var fileName = value.substr(0, pos+1).toLowerCase();
		if(fileName.length > 100){
			document.getElementById('err_myfile_reply').innerHTML = "<span class='err' style='color:red;'>"+error_name_file+"</span>" +"<br />";			
			return false;
		}
		
		return true;
	}
							
	function startReplyUpload(id){		
		if(!checkTypeFile(document.formreply.myfile.value)) return false;
		document.formreply.setAttribute( "autocomplete","off" );		
		document.formreply.action = "index.php?tmpl=component&option=com_jacomment&view=comments&task=uploadFileReply";
		document.formreply.target = "upload_target";
		document.getElementById('upload_process_1_reply').style.display='block';
		document.formreply.submit();
	}								
	//-->		
</script>
<?php
	}
?>
<?php 
if($jacconfig["layout"]->get("enable_smileys", 0)){
	$smiley = $jacconfig["layout"]->get("smiley", "default");
	$style = '	       
	        .smiley span{
				background: url('.JURI::root().'components/com_jacomment/asset/images/smileys/'.$smiley.'/smileys.png) no-repeat;
				display:inline-block;
				float:none;
				height:12px;
				margin:4px !important;
				width:12px;
			}
			.smiley span span{
				display:none;
			}
	';	
	$document = &JFactory::getDocument(); 
	$document->addStyleDeclaration($style);
}
?>
<div id="loader"><?php echo JText::_("LOADING"); ?>&nbsp;</div>
<!-- Main box -->
<fieldset class="adminform TopFieldset" id="fldcomment">
    <form action="" method="get" name="adminForm" id="adminForm">
	    <input type="hidden" name="option" value="com_jacomment" /> 
	    <input type="hidden" name="view" value="comments" />     
		<div id="comment-header-search-left">
			<?php echo JText::_('FILTER' ); ?>:	
			<input type="text" name="keyword" value="<?php echo $keyword;?>" class="text_area" id="keywordsearch"/>			
			<label for="reported<?php echo $currentTypeID;?>"><input type="checkbox" name="reported" id="jacReported" value="1" <?php if($reported==1){?> checked="checked" <?php } ?> /> <?php echo JTEXT::_("View reported comment");?></label>
			<input type="button"  value="<?php echo JText::_('GO' ); ?>" onclick="document.adminForm.submit();" />
		</div>
								
		<div id="comment-header-search-right">
			<?php if($this->listSearchOptions && count($this->listSearchOptions) >1){?>			
			<?php //echo JText::_('SELECT_COMPONENT' ); ?>		
				<select id="slComponent" onchange="document.adminForm.submit();" name="optionsearch">
					<option value=""><?php echo JText::_("SELECT_COMPONENT");?></option>						
					<?php 									
						foreach ($this->listSearchOptions as $listSearchOption){
					?>													
							<option value="<?php echo $listSearchOption->option;?>" <?php if($listSearchOption->option == $this->searchComponent) echo 'selected="selected"';?>><?php echo $listSearchOption->option;?></option>											
					<?php 		
						}
					?>			
				</select>
			<?php }?>			
	        &nbsp;
	        <?php if($this->listSearchSources){?>
	        <?php //echo JText::_('SOURCE' ); ?>        
	            <select id="slSource" onchange="document.adminForm.submit();" name="sourcesearch" style="min-width: 80px;">
	            	<option value=""><?php echo JText::_("SELECT_SOURCE");?></option>                        
	                <?php                                     
	                    foreach ($this->listSearchSources as $listSearchSource){
	                ?>                        
	                        <option value="<?php echo $listSearchSource->source;?>" <?php if($listSearchSource->source == $this->searchSource) echo 'selected="selected"';?>><?php echo $listSearchSource->source;?></option>                                            
	                <?php         
	                    }
	                ?>            
	            </select>
	        <?php }?>
	        
		</div>
    </form>	
    
</fieldset>
<br />
<fieldset class="adminform" id="fldcommentTab">
	<div id="javtabs-main" class="javtabs-mainwrap clearfix">		
		<?php include_once(JPATH_COMPONENT.DS.'views'.DS.'comments'.DS.'tmpl'.DS.'navigation.php'); ?>		
		<?php if($items){?>																
			<div class="javtabs_container">
			<?php 
	            //for($i= 0 ; $i < 4; $i++){
	            foreach($arr as $i){    
	        ?>
				<div class="javtabs-panel" id="jav-mainbox-<?php echo $i;?>">
					<?php if($i==99){ ?>																					
						<?php 								 
							require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jacomment'.DS.'views'.DS.'comments'.DS.'tmpl'.DS.'comments.php';	  
						?>	
					<?php } ?>
				</div>	
			<?php }?>												
				<input type="hidden" name="currentTypeID" id="currentTypeID" value="99" />
				<input type="hidden" name="currentCommentID" id="currentCommentID" value="0" />
				<input type="hidden" id="hidYouMustDelete" value="<?php echo JText::_("YOU_MUST_DELETE_SUB_COMMENT_OF_IT");?>" />
				<input type="hidden" id="hidSelectComment" value="<?php echo JText::_("YOU_MUST_SELECT_COMMENT");?>" />
				<input type="hidden" id="hidInputComment" value="<?php echo JText::_("YOU_MUST_INPUT_COMMENT");?>" />
				<input type="hidden" id="hidShortComment" value="<?php echo JText::_("YOUR_COMMENT_IS_TOO_SHORT");?>" />
				<input type="hidden" id="hidLongComment" value="<?php echo JText::_("YOUR_COMMENT_IS_TOO_LONG");?>" />
				<input type="hidden" id="hidDeleteComment" value="<?php echo JText::_("DO_YOU_WANT_TO_DELETE_COMMENT");?>" />
				<input type="hidden" id="hidExpandAll" value="<?php echo JText::_('EXPAND_ALL_COMMENTS'); ?>" />
				<input type="hidden" id="hidCollapseAll" value="<?php echo JText::_('COLLAPSE_ALL_COMMENTS'); ?>" />				
				<input type="hidden" id="hidClickToExpand" value="<?php echo JText::_('DOUBLE_CLICK_TO_EXPAND'); ?>" />																						
				<input type="hidden" id="hidClickToCollapse" value="<?php echo JText::_('DOUBLE_CLICK_TO_COLLAPSE'); ?>" />									
				<input type="hidden" id="hidEndEditText" value="<?php echo JText::_('PLEASE_EXIT_SPELL_CHECK_BEFORE_SUBMITTING_COMMENT'); ?>" />
			</div>	
		<?php }?>
	</div>	
</fieldset>		