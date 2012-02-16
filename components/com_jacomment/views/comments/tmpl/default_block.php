<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$ischild = 0;   
//require param - config
require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'helpers'.DS.'config.php');	
?>
<?php
	//check site offline			
	if(JRequest::getInt("islogin", 0) == 0){	
		if(!JACommentHelpers::check_permissions()){								 
			return ;
		}
	}			
?>	
	<!-- BEGIN - load blog header -->
	<?php //require_once $helper->jaLoadBlock("comments/head.php");	?>
	<!-- END   - load blog header -->
		
	<!-- BEGIN - load blog header -->
	<?php require_once $helper->jaLoadBlock("comments/header.php");	?>
	<!-- END   - load blog header -->
	
	<?php if( $formPosition == 1 ) {//position: form add new above items ?>
				
				
		<!-- BEGIN - load blog add new -->
		<div id="jac-wrapper-form-add-new" class="clearfix">
			<?php require_once $helper->jaLoadBlock("comments/addnew.php");	?>
		</div>
		<!-- END - load blog total -->					
		
		<!-- BEGIN - load blog sort -->
		<?php require_once $helper->jaLoadBlock("comments/sort.php");	?>
		<!-- END - load blog sort -->		
		
		<!-- BEGIN - load blog total -->
		<?php require_once $helper->jaLoadBlock("comments/total.php");	?>
		<!-- END - load blog total --> 
		<div id="jac-container-new-comment" class="clearfix"></div>
		<!-- END - load blog items -->
		<div id="jac-container-comment" class="clearfix">
			<?php require_once $helper->jaLoadBlock("comments/items.php") ?>    
		</div>
		<!-- END - load blog items -->
		<?php } else {//items above form add new ?>		
		
		<!-- BEGIN - load blog sort -->
			<?php require_once $helper->jaLoadBlock("comments/sort.php");	?>
		<!-- END - load blog sort -->
		
		<!-- BEGIN - load blog total -->
			<?php require_once $helper->jaLoadBlock("comments/total.php");	?>			
		<!-- END - load blog total -->
	
		<!-- END - load blog items -->			 
		<div id="jac-container-comment" class="clearfix">
			<?php require_once $helper->jaLoadBlock("comments/items.php") ?>    
		</div>
		<!-- END - load blog items -->
				
		<div id="jac-container-new-comment" class="clearfix"></div>
	
		<!-- BEGIN - load blog add new -->
		<div id="jac-wrapper-form-add-new" class="wrap clearfix">
			<?php require_once $helper->jaLoadBlock("comments/addnew.php");	?>
		</div>
		<!-- END - load blog total -->				
<?php }?>	
	<div id="jac-pagination" class="pagination wrap clearfix">
		<?php require_once $helper->jaLoadBlock("comments/paging.php");	?>		
	</div>	
									  
	<input type="hidden" id="limitstart" value="0"/>								
</div>
<!-- BEGIN - load template footer -->
<?php if($footerText){?>	
	<?php require_once $helper->jaLoadBlock("comments/footer.php");	?>	
<?php }?>
<!-- END   - load template footer -->