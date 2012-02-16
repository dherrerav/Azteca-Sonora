<?php
/*
# ------------------------------------------------------------------------
# JA Comment plugin for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );
jimport ( 'joomla.application.component.model' ); 

/**
 * JAComment Content plugin
 */
class plgContentJAComment extends JPlugin
{
    var $_plgCode 			= "#{JAComment(.*?)}#i";
    var $_plgCodeDisable 	= "#{jacomment(\s)off.*}#i";
    var $_plgCodeEnable 	= "#{jacomment(\s)on.*}#i";
    var $_plgStart   		= "\n\n<!-- JAComment starts -->\n";
    var $_plgEnd     		= "\n<!-- JAComment ends -->\n\n";
    var $_isCheckShowComment= 0;
    //: {jacomment contentid=xx option=xxxxx contentittle=''}    
    function plgContentJAComment( &$subject, $config )
    {
        parent::__construct( $subject, $config );	
        $this->plugin = &JPluginHelper::getPlugin('content', 'jacomment');		
        $params = new JRegistry;
        $params->loadJSON($this->plugin->params);
		$this->plgParams  = $params;			
    }
        
    //display top of content
    function onContentBeforeDisplay($context, &$row, &$params, $page=0){		
    	$app = JFactory::getApplication();
		if ( $app->isAdmin() ) { return; }
		if(!file_exists(JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'jacomment.php')){
			return '';	
		}
    	$option = JRequest::getCmd('option');
		$print	= JRequest::getCmd('print', 0);
		$view = JRequest::getCmd("view");	
		if($option != "com_content" || $print >0){
			return '';    			
		}			
		if($view == "article"){
			if($this->_isCheckShowComment == 1) $this->displayComment($row);
		}else{					
	    	//check category allow show comment	    
	    	if($this->_isCheckShowComment == -1 || !$this->checkShowComment($row)){
				if($option != "com_k2"){
					$row->text = preg_replace($this->_plgCodeEnable, "", $row->text);					
					$row->text = preg_replace($this->_plgCodeDisable, "", $row->text);
				}
	        	return '';
	        }
			
			$plgParams = $this->plgParams;
				        	
	    	if($plgParams->get('postion_add_button',0) == "onContentBeforeDisplay" && $this->_isCheckShowComment != -1){    					   		 
		    	return $this->showButton($row);
		    }else{
				return '';
			}
		}
    }
	

 	public function onContentAfterDisplay($context, &$row, &$params, $limitstart=1)
    {		
    	$app = JFactory::getApplication();    	    	        
    	if ( $app->isAdmin() ) { return; }
    	
    	if(!file_exists(JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'jacomment.php')){
			return '';	
		}
		
    	$option = JRequest::getCmd('option');    	
		$print	= JRequest::getCmd('print', 0);		
		if($option != "com_content" || $print >0){
			return '';    			
		}
						
		$plgParams = $this->plgParams;				
    	//check category allow show comment	    
    	if($this->_isCheckShowComment == -1 || !$this->checkShowComment($row)){		
			if($option != "com_k2"){
				$row->text = preg_replace($this->_plgCodeEnable, "", $row->text);				
				$row->text = preg_replace($this->_plgCodeDisable, "", $row->text);
			}
        	return '';
        }					  
    	if($plgParams->get('postion_add_button',0) == "onContentAfterDisplay" && $this->_isCheckShowComment != -1){    		    		    		    					  	
	    	return $this->showButton($row);
	    }else{
			return '';
	    }
    }
    
	public function onContentAfterTitle($context, &$row, &$params, $limitstart=1)
    {		
        $app = JFactory::getApplication();        
    	if ( $app->isAdmin() ) { return; }
    	if(!file_exists(JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'jacomment.php')){
			return '';	
		}
    	$option = JRequest::getCmd('option');
		$print	= JRequest::getCmd('print', 0);		
		if($option != "com_content" || $print >0){
			return '';    			
		}
		$plgParams = $this->plgParams;		
    	//check category allow show comment
		
    	if($this->_isCheckShowComment == -1 || !$this->checkShowComment($row)){	
			if($option != "com_k2"){
				$row->text = preg_replace($this->_plgCodeEnable, "", $row->text);				
				$row->text = preg_replace($this->_plgCodeDisable, "", $row->text);
			}			
        	return '';
        }
    	if($plgParams->get('postion_add_button',0) == "onContentAfterTitle" && $this->_isCheckShowComment != -1){    		    		    		    					   
	    	return $this->showButton($row);
	    }else{
			return '';
	    }    
    }
	
    
 	function getParamValue($group, $param, $default){
    	require_once(JPATH_BASE.DS.'components'.DS.'com_jacomment'.DS.'models'.DS.'comments.php');
        $model = new JACommentModelComments();
        $paramValue = $model->getParamValue( $group, $param ,$default);
        return $paramValue;   
    }
    
	function getLinkButton($fileName){
		$app = JFactory::getApplication();
    	$templateJaName = $this->getParamValue('layout', 'theme' , 'default');
    							
		$templateDirectory  =  JPATH_BASE.DS.'templates'.DS.$app->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS.$templateJaName.DS."html";									
		 if(file_exists($templateDirectory.DS.$fileName)){
		 	return $templateDirectory.DS.$fileName;	
		 }else{		 			 	
		 	if(file_exists('components/com_jacomment/themes/'.$templateJaName.'/html/'.$fileName)){		 			
				return 'components/com_jacomment/themes/'.$templateJaName.'/html/'.$fileName;
		 	}else{
		 		return 'components/com_jacomment/themes/default/html/'.$fileName; 	
		 	}
		 }			
    }
    
    //get text button
    function showButton($article){
    	
    	$app = JFactory::getApplication();
    	if(!file_exists(JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'jacomment.php')){
			return '';	
		}    	
		
    	$plugin 	= $this->plugin;
    	$plgParams 	= $this->plgParams;
    	$content 	= "";    	    	
		$theme   = $this->getParamValue('layout', 'theme' , 'default');
		
		$session = &JFactory::getSession();
		if(JRequest::getVar("jacomment_theme", '')){
			jimport( 'joomla.filesystem.folder' );
			$themeURL = JRequest::getVar("jacomment_theme");
			if(JFolder::exists('components/com_jacomment/themes/'.$themeURL) || JFolder::exists('templates/'.$app->getTemplate().'html/com_jacomment/themes/'.$themeURL)){
				$theme =  $themeURL;				
			}			
			$session->set('jacomment_theme', $theme);
		}else{
			if($session->get('jacomment_theme', null)){
				$theme = $session->get('jacomment_theme', $theme);
			}
		}
	    
	    $id             = $article->id;
	    $option         = JRequest::getCmd('option');
        $view           = JRequest::getCmd('view');
        
        $links = $this->getLink($article);		
        JPlugin::loadLanguage( 'com_jacomment', JPATH_SITE);
        
        if($links != ""){	    
	    	ob_start ();
			require $this->getLinkButton("comments/getbutton.php");
			$content = ob_get_contents ();
			ob_end_clean ();
        }
        
		return $content;
    }
    
    //check allow show comment in a category
    function checkShowComment($article){    	
    	$option         = JRequest::getCmd('option');
		$print			= JRequest::getCmd('print', 0);
		
    	if($option != "com_content" || $print > 0){
			if($option != "com_k2"){
				$article->text = preg_replace($this->_plgCodeEnable, "", $article->text);
				$article->text = preg_replace($this->_plgCodeDisable, "", $article->text);    		
			}
			return false;    	
		}
		
        $catid          = $article->catid;
        $id             = $article->id;
        $option         = JRequest::getCmd('option');
        $view           = JRequest::getCmd('view');
        $show           = JRequest::getCmd('show');
        $itemid         = JRequest::getInt('Itemid');                                
        $plgParams = $this->plgParams;    	
		
    	$check = true;
        if ($option != "com_content" && $option != "com_myblog"){ 
            $check = false;            
        }   
        
        if(!$article->id) {
            $check = false;         
        }
        
        $catsid = $plgParams->get('catsid','');
        if($catsid){
        	if(!in_array($catid, $catsid)){
        		$check = false;
        	}
        }               
        
        $menusid = $plgParams->get('menusid','');
        if($menusid){
        	if(!in_array($itemid, $menusid)){
        		$check = false;
        	}
        }
		
		if(isset($article->text) && preg_match($this->_plgCodeEnable, $article->text)) {    		
			$article->text = preg_replace($this->_plgCodeEnable, "", $article->text);    		    		    		
			$check = true;                
		}
		
		if(isset($article->introtext) && preg_match($this->_plgCodeEnable, $article->introtext)) {
			$article->introtext = preg_replace($this->_plgCodeEnable, "", $article->introtext);    		    		    		
			$check = true;                
		}
						
		if(isset($article->text) && preg_match($this->_plgCodeDisable, $article->text)) {
			$article->text = preg_replace($this->_plgCodeDisable, "", $article->text);                  	            		       	
			$check = false;            
		}
		
		if(isset($article->introtext) && preg_match($this->_plgCodeDisable, $article->introtext)) {
			$article->introtext = preg_replace($this->_plgCodeDisable, "", $article->introtext);                  	            		       	
			$check = false;            
		}
        
        if($check == false)     	
        	$this->_isCheckShowComment = -1;
        else 
           	$this->_isCheckShowComment = 1;        
     	return $check;
    }
    
    //get link of comment
    function getLink($article){ 	
        $option         = JRequest::getCmd('option');
        $view           = JRequest::getCmd('view');               
        $link = "";        
    	if( $option=='com_content' && ($view=='frontpage' || $view=='featured' || $view=='section' || $view=='category')){                  
            $user = & JFactory::getUser();            
            if($article->access != 1 && $article->access > $user->get('aid', 0)){
            	$link = JRoute::_("index.php?option=com_user&task=register");
            }else{
            	$link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));            	
            }            
        }
        return $link;	
    }       
    
	//Content_top_ads - Content_bottom_ads
    function displayComment(&$article)
    {       	
    	$view = JRequest::getVar('view');						
		$app = JFactory::getApplication();
		
        if(file_exists(JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'jacomment.php')){                  
			if ( $app->isAdmin() ) { return; }			
            $option         = JRequest::getCmd('option');
        	$print			= JRequest::getCmd('print', 0);        						
			
        	if($option != "com_content" || $print > 0){
				if($option != "com_k2"){
					$article->text = preg_replace($this->_plgCodeEnable, "", $article->text);
					$article->text = preg_replace($this->_plgCodeDisable, "", $article->text);        		
				}
				return '';    	
			}
			
            $id             = JRequest::getCmd('id', 0);                       
            $view           = JRequest::getCmd('view');
            $show           = JRequest::getCmd('show');
            $itemid         = JRequest::getInt('Itemid');                                      
            $conntentTitle	= addslashes($article->title);            			           	    		                        
                                                                          
        	
            $links = $this->getLink($article);
            $plugin = $this->plugin;
            $plgParams = $this->plgParams;
                                                                                                                            
                        	
            require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'helpers'.DS.'jahelper.php');
			$helper = new JACommentHelpers();
			
			$GLOBALS['jacconfig'] = array(); 
			JACommentHelpers::get_config_system();
			global $jacconfig;            					
            
			if(is_null($jacconfig) || count($jacconfig) == 0) return;
			
            $theme 				= $jacconfig['layout']->get('theme', 'default' );
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
            
            ob_start();            	 				
			// Put a value in a session var  
			$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
			$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]),0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")).$s;
			$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
			$webUrl = $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];                                                                  
			$app = JFactory::getApplication();
			$url = JURI::base ();
			//if don't search juri root in current url
			if(strpos($webUrl, $url) === false){
				$url = str_replace("https", "http", $url);	
			}
			//$webUrl = JRoute::_(str_replace($url,"",$webUrl));
			$webUrl = JRoute::_($webUrl);
			$webUrl = str_replace($url,"",$webUrl);
            if(substr($webUrl,0,1) == "/"){
				$webUrl 	=	substr($webUrl,1);
			}
			
            $session->set('commenturl', $webUrl);
                            
            //get css and JS befor perform ajax
            if(!defined('JACOMMENT_GLOBAL_CSS')){
				//add style for japopup					
				if(file_exists(JPATH_BASE.DS.'components/com_jacomment/asset/css/ja.popup.css')){			      
					JHTML::stylesheet(JURI::root().'components/com_jacomment/asset/css/ja.popup.css');
				}
				//override template for japopup in template
			    if(file_exists(JPATH_BASE.DS.'templates/'.$app->getTemplate().'/css/ja.popup.css')){
			    	JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/css/ja.popup.css');					    
				}

				//add style for all componennt
				if(file_exists('components/com_jacomment/asset/css/ja.comment.css')){
					JHTML::stylesheet(JURI::root().'components/com_jacomment/asset/css/ja.comment.css');
				}
				//override for all component
            	if(file_exists(JPATH_BASE.DS.'templates/'.$app->getTemplate().'/css/ja.comment.css')){
					JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/css/ja.comment.css');
				}
				
				//add style only IE for all component
				if(file_exists('components/com_jacomment/asset/css/css')){
					JHTML::stylesheet(JURI::root().'components/com_jacomment/asset/css/ja.ie.css');
				}            							
            	if(file_exists(JPATH_BASE.DS.'templates/'.$app->getTemplate().'/css/ja.ie.css')){
				    JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/css/ja.ie.css');
				}					
				
            	//add style of template for component
				if(file_exists('components/com_jacomment/themes/'.$theme.'/css/style.css')){					
            		JHTML::stylesheet(JURI::root().'components/com_jacomment/themes/'.$theme.'/css/style.css');
				}
				if(file_exists(JPATH_BASE.DS.'templates'.DS.$app->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS. $theme .DS."css".DS."style.css")){		
					JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$theme.'/css/style.css');	 
				}
				
				if(file_exists(JPATH_BASE.DS.'components/com_jacomment/themes/'.$theme.'/css/style.ie.css')){
            		JHTML::stylesheet(JURI::root().'components/com_jacomment/themes/'.$theme.'/css/style_ie.css');
				}	
				if(file_exists(JPATH_BASE.DS.'templates'.DS.$app->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS. $theme .DS."css".DS."style.ie.css")){		
					JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$theme.'/css/style.ie.css');	 
				}
            	//override for all component
            	if(file_exists(JPATH_BASE.DS.'templates/'.$app->getTemplate().'/css/ja.comment.css')){
					JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/css/ja.comment.css');
				}
				
				$lang =& JFactory::getLanguage();											
				if ( $lang->isRTL() ) {						
					if(file_exists(JPATH_BASE.DS.'components/com_jacomment/asset/css/ja.popup_rtl.css')){															
						JHTML::stylesheet(JURI::root().'components/com_jacomment/asset/css/ja.popup_rtl.css');	
					}					
					if(file_exists(JPATH_BASE.DS.'templates/'.$app->getTemplate().'/css/ja.popup_rtl.css')){															
						JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/css/ja.popup_rtl.css');	
					}
					if(file_exists(JPATH_BASE.DS.'components/com_jacomment/asset/css/ja.comment_rtl.css')){						
						JHTML::stylesheet(JURI::root().'components/com_jacomment/asset/css/ja.comment_rtl.css');		
					}																
					if(file_exists(JPATH_BASE.DS.'templates/'.$app->getTemplate().'/css/ja.comment_rtl.css')){															
						JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/css/ja.comment_rtl.css');	
					}
					
					//add style only IE for all component
					if(file_exists(JPATH_BASE.DS.'components/com_jacomment/asset/css/ja.ie_rtl.css')){
						JHTML::stylesheet(JURI::root().'components/com_jacomment/asset/css/ja.ie.css');            		
					}					
            		if(file_exists(JPATH_BASE.DS.'templates/'.$app->getTemplate().'/css/ja.ie_rtl.css')){
					    JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/css/ja.ie_rtl.css');
					}					
					
					if(file_exists(JPATH_BASE.DS.'components/com_jacomment/themes/'.$theme.'/css/style_rtl.css')){
						JHTML::stylesheet(JURI::root().'components/com_jacomment/themes/'.$theme.'/css/style_rtl.css');
					}
					if(file_exists(JPATH_BASE.DS.'templates'.DS.$app->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS. $theme .DS."css".DS."style_rtl.css")){		
						JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$theme.'/css/style_rtl.css');	 
					}

					if(file_exists(JPATH_BASE.DS.'components/com_jacomment/themes/'.$theme.'/css/style.ie_rtl.css')){
            			JHTML::stylesheet(JURI::root().'components/com_jacomment/themes/'.$theme.'/css/style_ie_rtl.css');
					}	
					if(file_exists(JPATH_BASE.DS.'templates'.DS.$app->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS. $theme .DS."css".DS."style.ie_rtl.css")){		
						JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$theme.'/css/style.ie_rtl.css');	 
					}
				}				            						  

            	if(file_exists(JPATH_BASE.DS.'templates/'.$app->getTemplate().'/css/ja.comment.custom.css')){
					JHTML::stylesheet(JURI::root().'templates/'.$app->getTemplate().'/css/ja.comment.custom.css');
				}
				
				define('JACOMMENT_GLOBAL_CSS', true);
			}
			if(!defined('JACOMMENT_GLOBAL_JS')){					
				JHTML::script(JURI::root().'components/com_jacomment/asset/js/jquery-1.4.2.js');
			    JHTML::script(JURI::root().'components/com_jacomment/asset/js/ja.comment.js');
			    JHTML::script(JURI::root().'components/com_jacomment/asset/js/ja.popup.js');  
			    define('JACOMMENT_GLOBAL_JS', true);
			}
										
			if(isset($jacconfig['general']) && $jacconfig['general']->get('is_comment_offline', 0)){				
				if(!JACommentHelpers::check_access($article->text)) return ;
			}
			
			require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'helpers'.DS.'config.php');
			$lists['commenttype'] 	= 1;				
			$lists['contentoption'] = $option;
			$lists['contentid']   	= $id;
			$lists['jacomentUrl'] 	= $webUrl;
			$lists['contenttitle'] 	= $conntentTitle;							 																	
            ?>
            <?php JPlugin::loadLanguage( 'com_jacomment', JPATH_SITE);?>
            <!-- BEGIN - load blog head -->
			<?php require_once $helper->jaLoadBlock("comments/head.php");	?>
			<!-- END   - load blog head -->
			<?php if(($jacconfig['layout']->get('enable_addthis')==1) || ($jacconfig['layout']->get('enable_addtoany')==1) || ($jacconfig['layout']->get('enable_tweetmeme')==1)){	?>	 	   	
			  <div id="jac-social-links">
			    <ul>
					<?php							
						if($jacconfig['layout']->get('enable_addthis')==1){
							$txtAddThis  = $jacconfig['layout']->get('custom_addthis');														
				        	echo "<li>" .$txtAddThis. "</li>";
						}if($jacconfig['layout']->get('enable_addtoany')==1){	
				        	echo "<li>" .$jacconfig['layout']->get('custom_addtoany'). "</li>";		       
						}if($jacconfig['layout']->get('enable_tweetmeme')==1){
				        	echo "<li>" .$jacconfig['layout']->get('custom_tweetmeme'). "</li>";
						}
			        ?>
			    </ul>
			  </div>	  
			<?php }?>							
            <div id="jac-wrapper" class="clearfix"></div>				
            <script language="javascript" type="text/javascript">
            //<![CDATA[
            window.addEvent("load", function() {
            	var url = window.location.hash;
            	c_url = url.split('#');
            	id = 0;
            	tmp = 0;
            	if(c_url.length >= 1){		
            		for(i=1; i< c_url.length; i++){			
            			if(c_url[i].indexOf("jacommentid:") >-1){				
            				tmp = c_url[i].split(':')[1];				
            				if(tmp != ""){									
            					id = parseInt(tmp, 10);
            				}
            			}
            		}
            	}
            	            	
            	url = "<?php echo $url; ?>index.php?tmpl=component&option=com_jacomment&view=comments&contentoption=<?php echo $option;?>&contentid=<?php echo $id;?>&ran=" + Math.random();	            	            	        
            	if(id != 0){
					url += "&currentCommentID=" + id;
            	}
				var req = new Request({
					 method: 'get',
                         url: url,                         
                         onComplete: function(text) { 
						$('jac-wrapper').innerHTML = $('jac-wrapper').innerHTML + text;																		 						
						//$('jacommentid:'+id).getPosition();
						moveBackground(id, '<?php echo JURI::root();?>');																																						
							jac_auto_expand_textarea();			 
                        }						
					}).send();					 							
            	});			
				//]]>						
				</script>
            <?php
            $output = ob_get_contents();
            ob_end_clean(); 
            
            $article->text .= $this->_plgStart.$output.$this->_plgEnd;            
            
            
            // return for others comment system
            JRequest::setVar( 'option', 'com_content' );
            
            return true;
            
        }else{
            return false;   
        }
        
    }

}