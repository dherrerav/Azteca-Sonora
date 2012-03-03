<?php
/**
 * @package Simple Content Versioning
 * @copyright 2009 - Fatica Consulting L.L.C.
 * @license GPL - This is Open Source Software 
 * $Id: admin.versions.html.php 982 2012-01-12 06:11:40Z fatica $
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class HTML_versions{

	/**
	 * Show the preferences selection screen tgc
	 */
	function showPrefs(&$lists,&$sectioncategories,$rowonly = false){
		
	if(!$rowonly){
	?>
	<script language="javascript" type="text/javascript">
		<!--
		<?php foreach($lists as $list){ 
		$i = 0;
		
		$list['id'] = (int)$list['id'];
		?>
		function getRuleSettings(t){ 

			var url="index.php?option=com_versions&format=raw&task=getrulesettings&id=" + <?php echo (int)$list['id']; ?> + "&short_name=" + document.getElementById(t.id).options[document.getElementById(t.id).selectedIndex].value;
					
			var a=new Ajax(url,{
					method:"get",
					update:$("container_" + t.id)
					}).request();
		}
			
		function addRule(){
			
			var id = parseInt(document.getElementById('rulecount').value) + 1;

			document.getElementById('rulecount').value = id;

			//get and save the settings of all controls
			var rules=new Array();
			var sectionid=new Array();
			var catid=new Array();
			var settings = new Array();
			
			for(var x = 0; x < id; x++){
				try{
					rules[x] 		= document.getElementById('rules_' + x).selectedIndex;
					sectionid[x]	= document.getElementById('sectionid_' + x).selectedIndex;
					catid[x] 		= document.getElementById('catid_' + x).selectedIndex;	
					settings[x] 	= document.getElementById('settings_' + x).selectedIndex;
				}catch(e){}
			}

			
			var url="index.php?option=com_versions&format=raw&task=getrulerow&id=" + id;
			
			var a=new Ajax(url,{
				method:"get",
				parameters: {}, 
				onComplete: function(response){
						$("tablebody").innerHTML = $("tablebody").innerHTML + response;

						//reset the control settings
						for(var x = 0; x < id; x++){
							try{
								document.getElementById('rules_' + x).selectedIndex = rules[x];
								document.getElementById('sectionid_' + x).selectedIndex = sectionid[x];
								document.getElementById('catid_' + x).selectedIndex = catid[x];	
								document.getElementById('settings_' + x).selectedIndex = settings[x];
							}catch(e){}
						}
						
					}
				}).request();
			
		}
		
		window.addEvent("domready",function(){
							
			$("rules_<?php echo (int)$list['id']; ?>").addEvent("change",function(){
				var url="index.php?option=com_versions&format=raw&task=getrulesettings&id=" + <?php echo (int)$list['id']; ?> + "&short_name=" + document.getElementById('rules_<?php echo (int)$list['id']; ?>').options[document.getElementById('rules_<?php echo (int)$list['id']; ?>').selectedIndex].value;
					
				var a=new Ajax(url,{
					method:"get",
					update:$("container_rules_<?php echo (int)$list['id']; ?>")
					
					}).request();
				});
			});

		<?php
			}
		?>	
		var sectioncategories = new Array;
		<?php
		$i = 0;
		foreach ($sectioncategories as $k=>$items) {
			foreach ($items as $v) {
				echo "sectioncategories[".$i++."] = new Array( '$k','".addslashes( $v->id )."','".addslashes( $v->title )."' );\n\t\t";
			}
		}
		?>

		/** 
		*  Show the settings for a particular rule
		*/
		function showSettings(t){

		}
		
		-->
	</script>
		<form name="adminForm" method="POST">
		<table class="adminlist" cellspacing="1">
		<thead>
			<th >
			Rule
			</th>
			<th>
			Section 
			</th>
			<th>
			Category
			</th>
			<th>
			Setting
			</th>
			</thead>	
			<tbody id="tablebody">
	<?php
	}
		foreach($lists as $list){
	?>
	<tr>
		<td><?php showRules($list['id']); ?></td>
		<td><?php echo $list['sectionid'] ?></td>
		<td><?php echo $list['catid'] ?></td>
		<td><div id="container_rules_<?php echo $list['id']; ?>"></div></td>
	</tr>
	<?php
		}
	if(!$rowonly){
		?>	
		</tbody>
		<tfoot><td colspan=4></td></tfoot>
		</table>
		
		<input type="hidden" name="rulecount" id="rulecount" value="<?php echo count($lists) - 1; ?>" />
		<input type="hidden" name="option" value="com_versions" />
		<input type="hidden" name="task" value="saveprefs" />
		</form>
		<?php 
	
	}
		
	}
	

	
	/**
	 * Show an admin list of versions 
	 */
	function showVersions(&$rows,&$pagenav,&$lists){
		
		$mainframe = JFactory::getApplication();
		
		$user = JFactory::getUser();
		
		if($mainframe->isSite()){
			?>
			<h1><?php echo JText::_( 'User Version Manager' ); ?></h1>
			<?php 
		}
		?>
		<form name="adminForm">
		

			<table>
				<tr>
					<td width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo @$lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" title="<?php echo JText::_( 'Filter by title' );?>"/>
						<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
					</td>
					<td nowrap="nowrap">
						<?php
						echo @$lists['state'];
						?>
					</td>
				</tr>
			</table>
					
		<table class="adminlist" cellspacing="1">
		<thead>
			<th width="5">#</th>
			<th width="5">
				<?php echo JHTML::_('grid.sort',JText::_( 'Versions' ), 'count(v.`id`)', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="5">
			<input type="checkbox" onclick="checkAll(<?php echo count($rows); ?>);" value="" name="toggle"/>
			</th>
			<th>
					<?php echo JHTML::_('grid.sort',JText::_( 'Title' ), 'title', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="1%">
				<?php echo JHTML::_('grid.sort',JText::_( 'Staged' ), 'count(v.`stage`)', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th>
					<?php echo JHTML::_('grid.sort',JText::_( 'Modified Date' ), 'max(v.modified)', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			</thead>
		<?php
		$i = 0;
		if($rows)
		foreach($rows as $row){
			
			?>
			<tr>
			<td  align="center"><?php echo $i+1; ?></td>
			<td  align="center"><?php echo $row->version_count; ?></td>
			<td align="center">
				<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->content_id;?>" name="cid[]" id="cb<?php echo $i; ?>"/>
			</td>
			<td align="left">
			<?php
					
			if(preg_match('/^1.5/',JVERSION) == 1){
				$task = "edit";
				$id_string = '&id=' .  $row->content_id;
				
			}else{
				
				$app = JFactory::getApplication();
				
				$task = "article.edit";	
				$id_string = '&id=' .  $row->content_id;			
				
				if($app->isSite()){
					$id_string = '&a_id=' .  $row->content_id;	
				}
			}
			
			?>
			<a href="index.php?option=com_content&task=<?php echo $task  . $id_string; ?>"><?php echo $row->title; ?></a>	
			</td>
			<td align="center">
			<?php echo (int)$row->staged; ?>
			</td>
			<td align="center"><?php
			
			$db =& JFactory::getDBO();
					
			echo (strlen($row->date) != 0 && $db->getNullDate() != $row->date)?(date("M d y",strtotime($row->date))):(JText::_( "Not Modified" )); ?></td>			
				<?php 
				$i++;		
		}
		?>
		<input type="hidden" name="view" value="directory"/>
		<input type="hidden" name="option" value="com_versions"/>
		<input type="hidden" name="task" value="showversions"/>
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>		
		</form>
		
		<tfoot>
			<tr>
				<td colspan="6">
					<?php echo $pagenav->getListFooter(); ?>
				</td>
			</tr>
		<tfoot>
	
		</table>
	
		<?php
	}
	
	/* Get the appropriate link if we're on the front-end or back end
	 *  Added comments
	 *
	 * @return unknown
	 */
	function getLink(){
		
		$mainframe = JFactory::getApplication();
		
		if($mainframe->isAdmin()){
			$stub =	"index.php";
		}else{
			$stub =	"index.php";
		}
		
        $link = $stub . '?option=com_versions&tmpl=component';
        return $link;
        
	}
	
	/**
	 * Function to determine whether the Button - Versioning plugin allows the user to delete versions
	 * 
	 *
	 */
	function canDeleteVersions(){
		
		$plugin = &JPluginHelper::getPlugin('editors-xtd', 'versioning');
		$pluginParams = new JParameter($plugin->params);
		$param = strtolower($pluginParams->get('allow_delete', 'yes'));
		
		if($param == "yes"){
			return true;	
		}
		
		return false;
			
	}
	
	/* Show the list of available versions
	 * *
	 *
	 * @param recordset $rows
	 */
	function show(&$rows,$current){
		
		//check that the version is at least 1.5.4
		//checkVersion();
		
		//ensure mootools is installed
		JHTML::_('behavior.mootools');
		
		$version = new JVersion();
		
		$version_number = $version->getShortVersion();
		
		//get the secondary version number
		$version_array = explode(".",$version_number);
		
		$major = (int)$version_array[0];
		$minor = (int)$version_array[1];
		$patch  =(int)$version_array[2];
			
		$doc = JFactory::getDocument();	
		if($major == 1 && $minor >= 6){	
		//	$doc->addScript(JURI::root() . "components/com_locator/assets/mootools.compat.js");
		}
			
		//if we have prior versions, show them
		if(count($rows) > 0){
			
			//get the editor name
			$eName	= JRequest::getVar('ename');
			$eName	= preg_replace( '#[^A-Z0-9\-\_\[\]]#i', '', $eName );
			
			$params = &JComponentHelper::getParams( 'com_versions' );
			
			$color = $params->get('background_color','#FFFFFF');
			
			?>
			<style type='text/css'>
				h1,h2,h3,h4,h5{
					margin:2px;
				}
				#preview_container {
					/*height:180px; */
					overflow:auto;
					width:50%;
					float:left;
					background-color: <?php echo $color ;?>
				}
				
				#difference_container{
					width:49%;
					float:left;
					border-left:1px solid black;
					background-color: <?php echo $color ;?>
				}				
				#version_pane{
					overflow:auto;
					border-bottom:1px solid black;
				}
				
				.ins,.ins p,.ins a {
					text-decoration:underline !important;
					color:green;
				}
				
				.del,.del p,.del a {
					text-decoration:line-through  !important;
					color:red;
				}
			</style>
			<script language='javascript' type='text/javascript'>
			
				//preview the content
				function showContent(t){
					
					try {	
						document.getElementById('preview_pane').style.visibility='visible';

						document.getElementById('preview').innerHTML = t.title;
						 
						document.getElementById('difference').innerHTML = t.rev;
					}catch(e){
						alert("Error previewing content: " + e);
					}
					
				}
				
				//clear out the preview pane
				function hideContent(){
					document.getElementById('preview_pane').style.visibility='hidden';
					document.getElementById('preview').innerHTML = '';					
				}
				
				//asynch request to delete the passed id				
				function requestDelete(id,autosave){
					
					if(confirm('<?php echo JText::_('SURE'); ?>')){
						
						try {
							//url to delete
							
							if(autosave == 1){
								
								var url = '<?php echo JURI::base(); ?>index.php?option=com_versions&task=deleteautosave&tmpl=component&no_html=1&id=' + id;
							}else{
								
								var url = '<?php echo JURI::base(); ?>index.php?option=com_versions&task=delete&tmpl=component&no_html=1&id=' + id;
							}
			
							//tell the user when it's gone!
							var myAjax = new Ajax(url, 
							{
					         	method: 'get',
					         	update:'version_error',
					         	'onFailure':
					         	function(){
					         	
					         		alert('<?php echo JText::_('Error deleting version: You are not authorized to delete this version.  You did not create it or you are not the administrator.') ?>');
					         			
					         	}
					         	,
					         	'onComplete':
					         	function(){
					         		//hide the preview
					         		hideContent();
					             	
					         		//remove the li from the list
					             	var d = document.getElementById('versions');
					             	
					             	if(id > 0){
										var remove = document.getElementById('version_' +id);
										d.removeChild(remove);
					             	}else{
					             		alert('<?php echo JText::_('Error: Version table id numbers are not present. Alter the #__version table id field to be AUTOINCREMENT and this error will go away.'); ?>');
					             	}
					            }
					         });		
					         
					         myAjax.request();
						}catch(e){
							alert("Error: Is Mootools available?:" + e);	
						}
					}
				}
				
				//set the editor window to the selected content value
				function use(t){
					
					try {
						
						window.parent.insertVersioning('<?php echo $eName; ?>',t.title);
						
						if(parent.document.getElementById('title')){
							
							parent.document.getElementById('title').value = t.rel;
							window.parent.document.getElementById('sbox-window').close();
						}else{
							parent.document.getElementById('jform_title').value;
							window.parent.SqueezeBox.close();
						}
							
					}catch(e){
						alert("Error inserting content: no editor found named: <?php echo $eName; ?>" + e);	
					}
				}
				
			</script>
			<form name="adminForm">
			
			<div id='version_pane'>
			
			<div id='version_error'></div>
			
			<h3><?php echo JText::_('VERSIONS'); ?></h3>
			<!-- <a href="#" onclick="return false;" ><?php echo JText::_('Annotate current version'); ?></a> -->
			<ul id='versions'>
			<?php
								
				//get the current version
				$current_text = str_replace("'","&apos;",@$current->introtext);
				
				if(strlen(@$current->fulltext) > 0){
					$current_text = $current_text . '<hr id="system-readmore" />' . str_replace("'","&apos;",@$current->fulltext);
				}
				
				foreach ($rows as $row){
					
					$staged = "";
					$autosaved = "";
					
					if(@$row->stage == 1){
						$staged = "<i>Staged</i>";
					}
					
					if(@$row->autosaved == 1){
						$autosaved = "<i>Autosaved</i>";
					}
													
					$hovertext = str_replace("'","&apos;",@$row->introtext);
					$title = str_replace("'","&apos;",@$row->title);
					
					//append the fulltext to the content
					if(strlen($row->fulltext) > 0){
						$complete = $hovertext . '<hr id="system-readmore" />' . str_replace("'","&apos;",@$row->fulltext);
					}else{
						$complete = $hovertext;	
					}
					
					if(strlen(@$row->modified) > 0){
						$ts = @$row->modified;
					}else{
						$ts = @$row->created;	
					}					
										
					//the first version has no modified by info, so we need to use created by instead for the first version only
					$modified_by_user =& JFactory::getUser((int)@$row->modified_by);
					$created_by_user =& JFactory::getUser((int)@$row->created_by);
					
					if(strlen(trim($modified_by_user->name)) == 0){
						$name = $created_by_user->name;
					}else{
						$name = $modified_by_user->name;
					}
								
					
					$diff = htmlDiff($current_text,$complete);
					
					//echo "CT . $current_text" . "DIFF" .  $diff . "COMPL"  . $complete;
										
					$length = (int)strlen($complete);
					
					if($length > 1024){
						$length = number_format(($length / 1024),2) . "K";
					}
					
					if(HTML_versions::canDeleteVersions() === true){
				
						if(@$_REQUEST['task'] == 'showautosave'){
							$delete = "<a href='#' title='".JText::_('DELETE')."' onclick='requestDelete({$row->content_id},1); return false;'>[".JText::_('DELETE')."]</a>";
						}else{
							$delete = "<a href='#' title='".JText::_('DELETE')."' onclick='requestDelete({$row->id},0); return false;'>[".JText::_('DELETE')."]</a>";
						}
						
					}else{
						$delete = "";
					}
					
					if(strpos($ts,'0000-00-00') !== false){
						$ts = JText::_('Original'); 
					}
					
					echo "<li id='version_{$row->id}'>$autosaved $staged $ts $name ($length) ";
					
					$controls = "<a href='#' title='$complete' rel='$title' rev='$diff' onclick='showContent(this); return false;'><abbr title='$hovertext'>[".JText::_('PREVIEW')."]</abbr></a>
							
							  	 <a title='$complete' href='#' rel='$title' onclick='use(this); return false;' >[".JText::_('USE')."]</a>
														
								 $delete";
					//can the user access these controls?
					if((int)@$row->hide_staged == 0){
						echo $controls;	
					}else if(@$row->stage != 1){
						echo $controls;	
					}
					
					echo "</li>";		
				}
			
			?>
			</ul>
			</div>
				<div id="preview_pane" style="visibility:hidden;">
					<div id='preview_container'>
						<h3><?php echo JText::_('PREVIEW'); ?></h3>
						<!-- <h4 id='preview_title'></h4> -->
						<div id='preview'></div>
					</div>
					<div id='difference_container'>
						<h3 style="display:inline;"><?php echo JText::_('DIFFERENCE'); ?></h3> (<span class="ins"><?php echo JText::_('ADDED'); ?></span> <?php echo JText::_('AND'); ?> <span class="del"><?php echo JText::_('DELETED'); ?></span>)
						<div id='difference'></div>
					</div> 
				</div>			
				
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="option" value="com_versions"/>
			<input type="hidden" name="task" value="showversions"/>				
			</form>
				
			<script language='javascript'>
				//add tooltips for previews, not really necessary, but handy
				//added try/catch 
				try{
					window.addEvent('domready', function(){
						var abbrTools = new Tips($$('abbr'));
					});
				}catch(e){
					
				}
			</script> 
			
			<?php
			
		}else{
			
			//no prior versions to show
			?>
			<h2><?php echo JText::_('NOVERSIONS'); ?></h2>
			<?php
				
		}
	}
	
}