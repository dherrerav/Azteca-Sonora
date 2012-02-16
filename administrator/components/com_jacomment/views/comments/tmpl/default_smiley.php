<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
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

defined ( '_JEXEC' ) or die ( 'Restricted access' );
     
global $jacconfig;
$app = JFactory::getApplication();
$smiley = $jacconfig['layout']->get('smiley', 'default');
//die(JURI::base()."components/com_jacomment/asset/images/smileys/".$theme."smileys_bg.png");
?> 
<style type="text/css"> 
#plugin_embed .smileys{
    background:#ffea00;
    clear:both;
    height:84px;
    width:105px;
    margin:16px 0 0 -92px;
    padding:2px 1px 1px 2px !important;
    position:absolute;
    z-index:51;
    -webkit-box-shadow:0 1px 3px #999;box-shadow:1px 2px 3px #666;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;
}
#plugin_embed .smileys li{
    display: inline;
    float: left;
    height:20px;
    width:20px;
    margin:0 1px 1px 0 !important;
    border:none;
    padding:0
}
#plugin_embed .smileys .smiley{
    background: url(<?php echo JURI::root();?>components/com_jacomment/asset/images/smileys/<?php echo $smiley;?>/smileys_bg.png) no-repeat;
    display:block;
    height:20px;   
    width:20px;
}
#plugin_embed .smileys .smiley:hover{
    background:#fff;
}
#plugin_embed .smileys .smiley span{
    background: url(<?php echo JURI::root();?>components/com_jacomment/asset/images/smileys/<?php echo $smiley;?>/smileys.png) no-repeat;   	
    float: left;
    height:12px;
    width:12px;
    margin:4px !important;
}
#plugin_embed .smileys .smiley span span{
   	display: none;
}
</style>  
<ul onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";' onmouseout='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="none";' style="display: none;" id="smileys-<?php echo $this->cid;?>" class="smileys">
    <li><a href='javascript:<?php echo $this->func;?>(":)");' class="smiley"><span style="background-position: 0px 0px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:)</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":D");' class="smiley"><span style="background-position: -12px 0px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:D</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>("xD");' class="smiley"><span style="background-position: -24px 0px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>xD</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(";)");' class="smiley"><span style="background-position: -36px 0px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>;)</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":p");' class="smiley"><span style="background-position: -48px 0px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:p</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>("^_^");' class="smiley"><span style="background-position: 0px -12px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>^_^</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":$");' class="smiley"><span style="background-position: -12px -12px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:$</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>("B)");' class="smiley"><span style="background-position: -24px -12px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>B)</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":*");' class="smiley"><span style="background-position: -36px -12px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:*</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>("(3");' class="smiley"><span style="background-position: -48px -12px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>(3</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":S");' class="smiley"><span style="background-position: 0px -24px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:S</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":|");' class="smiley"><span style="background-position: -12px -24px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:|</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>("=/");' class="smiley"><span style="background-position: -24px -24px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>=/</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":x");' class="smiley"><span style="background-position: -36px -24px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:x</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>("o.0");' class="smiley"><span style="background-position: -48px -24px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>o.0</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":o");' class="smiley"><span style="background-position: 0px -36px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:o</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":(");' class="smiley"><span style="background-position: -12px -36px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:(</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":@");' class="smiley"><span style="background-position: -24px -36px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:@</span></span></a></li>
    <li><a href='javascript:<?php echo $this->func;?>(":&#39;(");' class="smiley"><span style="background-position: -36px -36px;" onmouseover='document.getElementById("smileys-<?php echo $this->cid;?>").style.display="block";'><span>:&#39;(</span></span></a></li>
</ul>
<a href="javascript:void(0);" onclick='jacChangeDisplay("smileys-<?php echo $this->cid;?>", "block")'><img src="<?php echo JURI::root();?>components/com_jacomment/asset/images/smileys/<?php echo $smiley;?>/smileys_icon.png" alt="Smileys" title="<?php echo JText::_('ADD_A_SMILEY')?>"  /></a>


