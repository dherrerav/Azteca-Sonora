<?php 
defined( '_JEXEC' ) or die( 'Restricted access' ); 
$app = JFactory::getApplication();
if(!isset($theme)) $theme ="default";
$session = &JFactory::getSession();
if(JRequest::getVar("jacomment_theme", '')){
	jimport( 'joomla.filesystem.folder' );
	$themeURL = JRequest::getVar("jacomment_theme");
	if(JFolder::exists('components/com_jacomment/themes/'.$themeURL) || (JFolder::exists('templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$themeURL))){
		$theme =  $themeURL;						
	}
	$session->set('jacomment_theme', $theme);			
}else{
	if($session->get('jacomment_theme', null)){
		$theme = $session->get('jacomment_theme', $theme);
	}
}
if($enableSmileys && !defined("JACOMMENT_GLOBAL_CSS_SMILEY")){
	$style = '
	     #jac-wrapper .plugin_embed .smileys,.jac-mod_content .smileys{
            top: 17px;
        	background:#ffea00;
            clear:both;
            height:84px;
            width:105px;	            
            padding:2px 1px 1px 2px !important;
            position:absolute;
            z-index:51;
            -webkit-box-shadow:0 1px 3px #999;box-shadow:1px 2px 3px #666;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;
        }        
        #jac-wrapper .plugin_embed .smileys li,.jac-mod_content .smileys li{
            display: inline;
            float: left;
            height:20px;
            width:20px;
            margin:0 1px 1px 0 !important;
            border:none;
            padding:0
        }
        #jac-wrapper .plugin_embed .smileys .smiley,.jac-mod_content .smileys .smiley{
            background: url('.JURI::base().'components/com_jacomment/asset/images/smileys/'.$smiley.'/smileys_bg.png) no-repeat;
            display:block;
            height:20px;
            width:20px;
        }
        #jac-wrapper .plugin_embed .smileys .smiley:hover,.jac-mod_content .smileys .smiley:hover{
            background:#fff;
        }
        #jac-wrapper .plugin_embed .smileys .smiley span, .jac-mod_content .smileys .smiley span{
            background: url('.JURI::base().'components/com_jacomment/asset/images/smileys/'.$smiley.'/smileys.png) no-repeat;
            display: inline;
            float: left;
            height:12px;
            width:12px;
            margin:4px !important;
        }
        #jac-wrapper .plugin_embed .smileys .smiley span span, .jac-mod_content .smileys .smiley span span{
            display: none;
        } 
        #jac-wrapper .comment-text .smiley {
            font-family:inherit;
			font-size:100%;
			font-style:inherit;
			font-weight:inherit;
			text-align:justify;
        }
        #jac-wrapper .comment-text .smiley span, .jac-mod_content .smiley span{
            background: url('.JURI::base().'components/com_jacomment/asset/images/smileys/'.$smiley.'/smileys.png) no-repeat scroll 0 0 transparent;
			display:inline;
			float:left;
			height:12px;
			margin:4px !important;
			width:12px;
        }
        .comment-text .smiley span span,.jac-mod_content .smiley span span{
            display:none;
        }
	';
	$doc = & JFactory::getDocument();
	$doc->addStyleDeclaration($style);
}
?>
<?php	 
	if(!defined('JACOMMENT_PLUGIN_ATD')){JHTML::stylesheet('atd.css', 'components/com_jacomment/asset/css/');JHTML::script('jquery.atd.js', 'components/com_jacomment/libs/js/atd/');JHTML::script('csshttprequest.js', 'components/com_jacomment/libs/js/atd/');JHTML::script('atd.js', 'components/com_jacomment/libs/js/atd/');define('JACOMMENT_PLUGIN_ATD', true);}
?>
<script type="text/javascript">
//<![CDATA[	
	jQuery(document).ready(function($){	
		jac_init();		
	});
	
	var JACommentConfig = {
		jac_base_url 			: '<?php echo JURI::base(true)."/";?>',
		siteurl 				: '<?php echo JURI::base(true)."/index.php?tmpl=component&option=com_jacomment&view=comments";?>',
		minLengthComment 		: '<?php echo $minLength;?>',		
		errorMinLength 			: '<?php echo JText::_("YOUR_COMMENT_IS_TOO_SHORT");?>',
		maxLengthComment 		: '<?php echo $maxLength;?>',
		errorMaxLength 			: '<?php echo JText::_("YOUR_COMMENT_IS_TOO_LONG");?>',			
		isEnableAutoexpanding  : '<?php echo $isEnableAutoexpanding;?>',
		dateASC					: '<?php echo JText::_("LATEST_COMMENT_ON_TOP");?>',
		dateDESC				: '<?php echo JText::_("LATEST_COMMENT_IN_BOTTOM");?>',
		votedASC				: '<?php echo addslashes(JText::_("MOST_RATED_ON_TOP"));?>',
		strLogin				: '<?php echo JText::_("LOGIN_NOW");?>',
		isEnableBBCode			: '<?php echo $enableBbcode;?>',
		hdCurrentComment		: 0,
<?php if( isset($lists['contentoption'])){?>		
		contentoption			: '<?php echo $lists['contentoption'];?>',
		contentid				: '<?php echo $lists['contentid'];?>',
		commenttype				: '<?php echo $lists['commenttype'];?>',
		jacomentUrl				: '<?php echo $lists['jacomentUrl'];?>',
		contenttitle			: '<?php echo $lists['contenttitle'];?>',
<?php }?>				
		hidInputComment			: '<?php echo JText::_("YOU_MUST_INPUT_COMMENT");?>',
		hidInputWordInComment	: '<?php echo JText::_("THE_WORDS_ARE_TOO_LONG_YOU_SHOULD_ADD_MORE_SPACES_BETWEEN_THEM");?>',
		hidEndEditText			: '<?php echo JText::_("PLEASE_EXIT_SPELL_CHECK_BEFORE_SUBMITTING_COMMENT"); ?>',
		hidInputName			: '<?php echo JText::_("YOU_MUST_INPUT_NAME");?>',
		hidInputEmail			: '<?php echo JText::_("YOU_MUST_INPUT_EMAIL");?>',
		hidValidEmail			: '<?php echo JText::_("YOUR_EMAIL_IS_INVALID");?>',
		hidAgreeToAbide			: '<?php echo JText::_("YOU_MUST_AGREE_TO_ABIDE_BY_THE_WEBSITE_RULES");?>',
		hidInputCaptcha			: '<?php echo JText::_("YOU_MUST_INPUT_TEXT_OF_CAPTCHA");?>',
		textQuoting			    : '<?php echo JText::_("QUOTING");?>',
		textQuote			    : '<?php echo JText::_("QUOTE");?>',
		textPosting			    : '<?php echo JText::_("POSTING");?>',
		textReply			    : '<?php echo JText::_("REPLY");?>',
		textCheckSpelling		: '<?php echo JText::_("NO_WRITING_ERRORS");?>',
		mesExpandForm			: '<?php echo "(+) ".JText::_("CLICK_TO_EXPAND");?>',
		mesCollapseForm			: '<?php echo "(-) ".JText::_("CLICK_TO_COLLAPSE");?>',
		theme					: '<?php echo $theme;?>',
		txtCopiedDecode			: '<?php echo JText::_("COPIED_DCODE");?>'							
	};																	
//]]>
</script>
<?php if($isAttachImage){	
	$strTypeFile = JText::_("SUPPORT_FILE_TYPE").": ".$attachFileType." ".JText::_("ONLY");		
	$arrTypeFile = explode(",", $attachFileType);			
	$strListFile = "";
	if ($arrTypeFile) {
		foreach ($arrTypeFile as $type){
			$strListFile .= "'$type',";
		}
		$strListFile .= '0000000';
	}	
	?>
	<script type="text/javascript">			
		JACommentConfig.v_array_type 	  = [ <?php echo $strListFile;?> ];	
		JACommentConfig.error_type_file   = "<?php echo $strTypeFile;?>";
		JACommentConfig.total_attach_file =	"<?php echo $totalAttachFile;?>";
		JACommentConfig.error_name_file   = "<?php echo JText::_("FILE_NAME_IS_TOO_LONG");?>";  
	</script>
	<script type="text/javascript" src="components/com_jacomment/asset/js/ja.upload.js"></script>
	<iframe id="upload_target" name="upload_target" src="#" style="width:0; height:0; border:0px solid #fff;"></iframe>
<?php }?>
<?php if($isEnableAutoexpanding){?><script type="text/javascript" src="components/com_jacomment/libs/js/jquery/jquery.autoresize.js"></script><?php }?>
<?php if($enableBbcode){?>
	<script type="text/javascript" src="components/com_jacomment/libs/js/dcode/dcodr.js"></script>
	<script type="text/javascript" src="components/com_jacomment/libs/js/dcode/dcode.js"></script>
<?php }?>	  
<?php if($enableYoutube){?>
<script language="javascript" type="text/javascript">
	function open_youtube(id){jacCreatForm('open_youtube',id,400,200,0,0,'<?php echo JText::_("EMBED_A_YOUTUBE_VIDEO");?>',0,'<?php echo JText::_("EMBED_VIDEO");?>');}
</script>
<?php }?>	               