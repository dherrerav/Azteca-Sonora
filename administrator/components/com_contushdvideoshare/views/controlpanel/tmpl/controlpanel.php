<?php
/**
 * @version     2.3, Creation Date : March-24-2011
 * @name        settings.php
 * @location    /components/com_contushdvideosahre/views/settings/tmpl/settings.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Admin Member details layout
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.pane');

?>
<style>
    .contus-icon{
   
margin-right: 15px;
float: left;
margin-bottom: 15px;
border:1px solid #333;
padding:10px;
    }
    .contus-icon:hover{background:#e5e5e5}
    .clear{clear:both;}
    .text{color:#333;margin:10px;line-height: 17px;font-size: 12px;}
    .text a{padding: 7px;font-size: 12px;font-weight: 700;border:1px solid #ccc;text-transform:uppercase }
    .text a:hover{padding: 7px;font-size: 12px;font-weight: 700;color: #000;background: #FAFAFA }
    #toolbar-box{display: none;}
    html, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td{margin:0; padding:0; border:0; outline:0}

ol, ul{list-style:none}
.floatleft{float:left}
.floatright{float:right}

.clear{clear:both; height:0px; font-size:0px}
.clearfix:after{ clear:both;  display:block;  content:"";  height:0px;  visibility:hidden}
.clearfix{ display:inline-block}

* html .clearfix{ height:1%}
.clearfix{ display:block}
li.clearfix{ display:list-item}

div.cpanel-left {float: left;width:40%;}
.banner{padding-bottom: 10px;}
#cpanel div.icon {background: white;float: left;margin-bottom: 15px;margin-right: 15px;text-align: center;}
#cpanel div.icon a {border: 1px solid #EAEAEA;color: #565656;display: block;float: left;height: 97px;text-decoration: none;vertical-align: middle;width: 108px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;}
#cpanel div.icon a:hover {background: #FBFBFB;border-bottom: 1px solid #CCC;border-left: 1px solid #EEE;border-right: 1px solid #CCC;border-top: 1px solid #EEE;}
#cpanel img {margin: 0px auto;padding: 10px 0px;}
#cpanel span {display: block;text-align: center;font-family: 'arial';color:#8D8371;font-size: 12px;}
.heading{ margin-bottom: 10px;  font-family: arial; line-height: 24px;  font-size: 24px;  font-weight: bold;  color: #146295;    padding: 0;}
.pane-sliders{margin: 0px;padding: 0px;}
</style>
<div class="contus-contropanel">
    <h2 class="heading">HD Video Share Control panel</h2>
    </div>
<div class="cpanel-left" >
            <div class="banner"><a href="http://www.apptha.com" target="_blank"><img src="components/com_contushdvideoshare/assets/apptha-banner.jpg" width="485" height="94" alt=""></a></div>
            <div id="cpanel">
                <div class="icon">
                   <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&layout=adminvideos&userid=62");?>" title="adminvideos">
                        <img src="components/com_contushdvideoshare/assets/admin-video.png" title="Admin Videos" alt="Admin Videos">
                        <span>Admin Videos</span></a>
                </div>

                <div class="icon">
                   <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&layout=adminvideos");?>" title="membervideos">
                        <img src="components/com_contushdvideoshare/assets/member-videos.png" title="Member Videos" alt="Member Videos">
                        <span>Member Videos</span></a>
                </div>

                <div class="icon">
                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&layout=memberdetails");?>" title="memberdetails">
                        <img src="components/com_contushdvideoshare/assets/member-details.png" title="Member Details" alt="Member Details">
                        <span>Member Details</span></a>
                </div>

                <div class="icon">
                  <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&layout=category");?>" title="Category">
                        <img src="components/com_contushdvideoshare/assets/category .png" title="Category" alt="Category">
                        <span>Category</span></a>
                </div>

                <div class="icon">
                  <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&layout=ads");?>" title="Ads">
                        <img src="components/com_contushdvideoshare/assets/ads-icon.png" title="ads" alt="ads">
                        <span>ads</span></a>
                </div>

                <div class="icon">
                   <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&layout=googlead");?>" title="Google Adsense">
                        <img src="components/com_contushdvideoshare/assets/google- adsense-icon.png" title="Google Adsense" alt="Google Adsense">
                        <span>Google Adsense</span></a>
                </div>

                <div class="icon">
                     <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&layout=settings");?>" title="Player Settings">
                        <img src="components/com_contushdvideoshare/assets/player-settings-icon.png" title="Player Settings" alt="Player Settings">
                        <span>Player Settings</span></a>
                </div>

                <div class="icon">
                   <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&layout=sitesettings");?>" title="Site Settings">
                        <img src="components/com_contushdvideoshare/assets/site-settings-icon.png" title="Site Settings" alt="Site Settings">
                    <span>Site Settings</span></a>
                </div>

            </div>
        </div>

<div style="width:50%;float:right;">
<?php
$controlpaneldetail =$this->controlpaneldetails;
$adminvideocount =   $this->controlpaneldetails['adminvideocount'];
$membervideocount =   $this->controlpaneldetails['membervideocount'];
$membervideos =   $this->controlpaneldetails['membervideos'];
$popularvideos = $this->controlpaneldetails['popularvideos'];
$latestvideos = $this->controlpaneldetails['latestvideos'];
 //echo '<pre>';print_r($controlpaneldetail);die;
$pane   = JPane::getInstance('sliders');
//$pane =& JPane::getInstance('tabs', array('startOffset'=>2));
echo $pane->startPane( 'pane' );
echo $pane->startPanel( 'Welcome to hdvideoshare', 'panel1' );?>
    
    <div class="main-text">

        <div class="text">
  HD Video Share is an extension for Joomla CMS. This video sharing script was developed to enable the Joomla websites to start converting into a joomla video site. Same like joomla video sharing this helps a great deal in creating in youtube clone script also.
        </div>   <div class="text">
     <a href="http://www.apptha.com/forum/viewforum.php?f=45" target="_blank">
     Support</a>
     <a href="http://www.apptha.com/download.php?name=documentation.pdf&amp;link=images/Extensions/Joomla/hdvideoshare/documentation.pdf">Documentation</a>
   </div>
    </div>
<?php 
echo $pane->endPanel();
echo $pane->startPanel( 'Member Details', 'panel2' );
?>
<table class="adminlist">
	<thead>
		<tr>
			<th>
				Member Name			</th>
			<th>
				<strong>Videos count</strong>
			</th>
			
			
		</tr>
	</thead>
	<tbody>
            <?php foreach($membervideos as $details) { ?>
			<tr>
			<td><?php  echo $details->username; ?>
							</td>
			<td class="center">
				<?php  echo $details->count; ?>		</td>
<?php }?>
		</tr>
			</tbody>
</table>
<?php
echo $pane->endPanel();
echo $pane->startPanel( 'Top 5 Popular Videos', 'panel3' ); ?>
<table class="adminlist">
	<thead>
		<tr>
			<th>
				Video Title			</th>
			<th>
				<strong>Times Viewed</strong>
			</th>


		</tr>
	</thead>
	<tbody>
            <?php foreach($popularvideos as $details) { ?>
			<tr>
			<td>
                            <?php
                            $route =JURI::Base()."index.php?option=com_contushdvideoshare&layout=adminvideos&task=editvideos&actype=adminvideos&cid[]=".$details->id;
                            ?>
                            <a href="<?php echo $route; ?>" target="_blank"><?php  echo $details->title; ?></a>
							</td>
			<td class="center">
				<?php  echo $details->times_viewed; ?>		</td>
<?php }?>
		</tr>
			</tbody>
</table><?php
echo $pane->endPanel();
echo $pane->startPanel( 'Last 5 Added Videos', 'panel4' );
 ?>
<table class="adminlist">
	<thead>
		<tr>
			<th>
				Video Title			</th>
			<th>
				<strong>Created Date</strong>
			</th>


		</tr>
	</thead>
	<tbody>
            <?php foreach($latestvideos as $details) { ?>
			<tr>
			<td>
                            <?php
                            $route =JURI::Base()."index.php?option=com_contushdvideoshare&layout=adminvideos&task=editvideos&actype=adminvideos&cid[]=".$details->id;
                            ?>
                            <a href="<?php echo $route; ?>" target="_blank"><?php  echo $details->title; ?></a>
							</td>
			<td class="center">
				<?php  echo $details->created_date; ?>		</td>
<?php }?>
		</tr>
			</tbody>
</table><?php
echo $pane->endPanel();
echo $pane->endPane();

?>

</div>



        <!-- Page Top videoshare information  -->


