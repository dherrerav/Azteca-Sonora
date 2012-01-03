<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        showvideolayout.php
 * @location    /components/com_contushdvideosahre/views/showvideos/tmpl/showvideolayout.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : showing added new ads, updated ads in admin panel
 *               columns : Adsname, Default, Ads video path, Published, ID, Click Hits, Impression Hits
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$videolist1 = $this->videolist;
$baseurl = JURI::base();
$thumbpath1 = JURI::base() . "/components/com_contushdvideoshare";
JHTML::_('behavior.tooltip');
$toolTipArray = array('className' => 'custom2', 'showDelay' => '0', 'hideDelay' => '500', 'fixed' => 'true', 'onShow' => "function(tip) {tip.effect('opacity',{duration: 500, wait: false}).start(0,1)}", 'onHide' => "function(tip) {tip.effect('opacity', {duration: 500, wait: false}).start(1,0)}");
JHTML::_('behavior.tooltip', '.hasTip2', $toolTipArray);  // class="hasTip2" titles
$filename = 'testtooltip.js'; // used for class="hasTip3" titles
$path = 'templates/rhuk_milkyway/js/';
JHTML::script($filename, $path, true); // MooTools will load if it is not already loaded
$document = & JFactory::getDocument();
$document->addStyleSheet('components/com_contushdvideoshare/css/cc.css');
?>

<script type="text/javascript" src="<?php echo $thumbpath1 . '/js/jquery-1.3.2.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $thumbpath1 . '/js/jquery-ui-1.7.1.custom.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $thumbpath1 . '/js/selectuser.js'; ?>"></script>
<link rel='stylesheet' href='<?php echo $thumbpath1 . "/css/styles123.css"; ?>' type='text/css' media='all' />
<script type="text/javascript">
    // When the document is ready set up our sortable with it's inherant function(s)
    var dragdr = jQuery.noConflict();
    var videoid = new Array();
    dragdr(document).ready(function() {
        dragdr("#test-list").sortable({
            handle : '.handle',
            update : function () {
                var order = dragdr('#test-list').sortable('serialize');
		 
                orderid= order.split("listItem[]=");
		 
                for(i=1;i<orderid.length;i++)
                {
                    videoid[i]=orderid[i].replace('&',"");
                    oid= "ordertd_"+videoid[i];
                    document.getElementById(oid).innerHTML=i-1;
                }
                dragdr("#info").load("<?php echo $baseurl; ?>/index.php?option=com_contushdvideoshare&task=videos&layout=sortorder&"+order);
            }
        });
    });

</script>
<script language="javascript">
    document.getElementById('toolbar-box').style.marginTop=120+"px";
    function deletecomment(cmtid,vid)
    {
        window.open('index.php?option=com_contushdvideoshare&layout=adminvideos&page=comment&id='+vid+'&cmtid='+cmtid,'_self',false);
    }
</script>
<div  style="position:absolute;top:100px;left:20px;width:97%">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>
    <div class="m">
        <div style="float:left;width:20%;padding-top:8px;"><img src="components/com_contushdvideoshare/assets/customization_contushdvideoshare.png" alt="" /></div><div style=" padding: 20px 0pt 0pt 50px; float: left; width: 50%;font-size:12px;font-family:Arial, Helvetica, sans-serif;line-height:18px;color:#333333;">
            Do you know that HDVideo Share not just develops Extensions but also provides professional web design and custom development services. We would be glad to help you to design and customize the extension to your business needs.
        </div><div style="float:right;padding:8px 0 0 50px;;text-decoration:underline;color:#0B55C4;"><div><img src="components/com_contushdvideoshare/assets/logo.png" alt="" /></div><div> <div style="padding: 8px 0pt 0pt 10px;float:left;"> <a href="http://www.hdvideoshare.net" target="_blank">Launch hdvideoshare.net</a></div><div style="padding: 8px 0pt 0pt 10px;float:left;"><a href="http://www.hdvideoshare.net/shop/index.php?main_page=contact_us" target="_blank">Contact us</a></div></div></div>
        <div class="clr"></div>
    </div>
    <div class="b">
        <div class="b">
            <div class="b"></div>
        </div>
    </div>
</div>
<?php
if (JRequest::getVar('page', '', 'get', 'string') && JRequest::getVar('page', '', 'get', 'string') == 'comment' && JRequest::getVar('page', '', 'get', 'string') != 'myvideos' && JRequest::getVar('page', '', 'get', 'string') != 'deleteuser') {
    $cmd = $this->comment['comment'];
    $tot = count($cmd);
    if (JRequest::getVar('id', '', 'get', 'int')) {
        $cid = "&id=" . JRequest::getVar('id', '', 'get', 'int');
    }
?>
    <form action="index.php?option=com_contushdvideoshare&layout=membervideos&page=comment<?php echo $cid; ?>" method="post" name="adminForm">
        <div id="videocontent" align="center">
            <div class="videocont">
                <div class="clearfix">
                    <h1><?php echo $cmd[0]->title; ?></h1>
                </div>
                <h2>Comments</h2>
                <table border="0" width="600" >
                    <?php jimport('joomla.filter.output'); ?>
                    <?php
                    if ($tot > 0) {
                    foreach ($this->comment['comment'] as $row) {
                    ?>
                    <?php
                        if ($row->parentid == 0) {
                    ?>
                    <tr>
                        <td>
                            <div class="clearfix">
                                <p class="subhead" style="color:#132855;"><b><?php echo $row->name; ?> : <span></span></b></p>
                            </div>
                            <p><?php echo $string = nl2br($row->message); ?></p>
                        </td>
                        <td valign="center" align="center"><img id="<?php echo $row->id; ?>" src="components/com_contushdvideoshare/images/publish_x.png" onclick="deletecomment(id,<?php echo $row->videoid; ?>);" style="cursor:pointer;"/> </td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr></td>
                    </tr>
                        <?php } else { ?>
                    <tr>
                        <td>
                            <blockquote>
                                <p>
                                <strong>Re : <span style="color:#132855;"><?php echo $row->name; ?></span></strong>
                                <p><?php echo $string = nl2br($row->message); ?></p>
                            </blockquote>
                        </td>
                        <td valign="center" align="center"><img id="<?php echo $row->id; ?>" src="components/com_contushdvideoshare/images/publish_x.png" onclick="deletecomment(id,<?php echo $row->videoid; ?>);" style="cursor:pointer;" /></td>
                    <tr>
                        <td colspan="2" ><hr style="background-color: #fff; border: 1px dotted #132855; border-style: none none dotted;"></td>
                    </tr>
                    <?php
                    }
                    }
                    }
                    ?>
                <tfoot>
                <td><?php echo $this->comment['pageNav']->getListFooter(); ?></td>
                </tfoot>
            </table>
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
    <input type="hidden" name="filter_order" value="<?php echo $this->comment['lists']['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->comment['lists']['order_Dir']; ?>" />
    <input type="hidden" name="submitted" value="true" id="submitted"/>
    <input type="hidden" name="task" value="adminvideos" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_('form.token'); ?>
</form>
<?php } else { ?>

<form action="index.php?option=com_contushdvideoshare&layout=adminvideos<?php echo (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos') ? "&actype=" . JRequest::getVar('actype', '', 'get', 'string') : ""; ?>" method="post" name="adminForm">
        <table>
            <tr>
                <td align="left" width="100%">
                    Filter:
                    <input type="text" name="search" id="search" value="<?php if (isset($videolist1['lists']['search'])) echo $videolist1['lists']['search']; ?>"  onchange="document.adminForm.submit();" />
                    <button onClick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
                    <button onClick="document.getElementById('search').value='';"><?php echo JText::_('Reset'); ?></button>
                </td>
            </tr>
        </table>
        <table class="videolist">
            <thead>

                <th>Sorting  </th>
                <th> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($videolist1['rs_showupload']); ?>);" /> </th>
                <th> <?php echo JHTML::_('grid.sort', 'Title', 'title', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th> <?php echo JText::_('Comments'); ?> </th>
                <th> <?php echo JHTML::_('grid.sort', 'Category', 'playlistid', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th> <?php echo JHTML::_('grid.sort', 'Viewed', 'times_viewed', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th> <?php echo JText::_('Streamer Name'); ?> </th>
                <th> <?php echo JText::_('Streamer Path'); ?> </th>
                <th> <?php echo JText::_('User Name'); ?> </th>
                <th> <?php echo JHTML::_('grid.sort', 'Video Link', 'videourl', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th> <?php echo JHTML::_('grid.sort', 'Thumb Link', 'thumburl', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th> Postroll Ads </th>
                <th> Preroll Ads </th>
                <th> Midroll Ads </th>
                <th> <?php echo JHTML::_('grid.sort', 'Order', 'ordering', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th> Published </th>
                <th> <?php echo JHTML::_('grid.sort', 'Featured', 'featured', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th> <?php echo JHTML::_('grid.sort', 'Id', 'Id', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>

            </thead>
            <tbody id="test-list">

                <?php $imagepath = JURI::base() . "components/com_contushdvideoshare/images"; ?>
                <?php
                    $k = 0;
                    jimport('joomla.filter.output');
                    $j = $videolist1['limitstart'];
                    $n = count($videolist1['rs_showupload']);
                    $vpath = VPATH2 . "/";
                    if ($n >= 1) {
                        for ($i = 0; $i < $n; $i++) {
                            $row_showupload = $videolist1['rs_showupload'][$i];
                            $checked = JHTML::_('grid.id', $i, $row_showupload->id);
                            $published = JHTML::_('grid.published', $row_showupload, $i);
                            $user = & JFactory::getUser();
                            $userid = $user->get('id');
                            $actype = (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos') ? "&actype=" . JRequest::getVar('actype', '', 'get', 'string') : "";
                            $link = JRoute::_('index.php?option=com_contushdvideoshare&layout=adminvideos&task=editvideos' . $actype . '&cid[]=' . $row_showupload->id);
                            $str1 = explode('administrator', JURI::base());
                            $videopath = $str1[0] . "components/com_contushdvideoshare/videos/";
                ?>

                <tr id="listItem_<?php echo $row_showupload->id; ?>">

                    <td> <p class="hasTip content" title="Click and Drag" style="padding:6px;">  <img src="<?php echo $imagepath . '/arrow.png'; ?>" alt="move" width="16" height="16" class="handle" /> </p> </td>
                    <td> <p class="content" style="padding:6px;"> <?php echo $checked; ?></p> </td>
                    <td> <p class="content" style="padding:6px;">  <a href="<?php echo $link; ?>"> <?php echo $newtext = wordwrap($row_showupload->title, 15, "\n", true); ?></a></p> </td>
                    <td align="center"> <?php if (isset($row_showupload->cvid)) { if ($row_showupload->cvid == $row_showupload->id) { ?><a href="index.php?option=com_contushdvideoshare&layout=adminvideos&page=comment&id=<?php echo $row_showupload->id; ?>">Comments </a><?php } } else { ?>No Comments<?php } ?></td>
                    <td> <p class="content" style="padding:6px;"> <?php $showname = ""; ($row_showupload->category == "" ? $showname = "None" : $showname = $row_showupload->category); echo $newtext = wordwrap($showname, 15, "\n", true); ?> </p> </td>
                    <td> <p class="content" style="padding:6px;"> <?php echo $row_showupload->times_viewed; ?></p> </td>
                    <td> <p class="content" style="padding:6px;"> <?php echo $newtext = wordwrap($row_showupload->streameroption, 15, "\n", true); ?></p> </td>
                    <td> <p class="content" style="padding:6px;"> <?php if ($row_showupload->streamerpath != "") : echo $newtext = wordwrap($row_showupload->streamerpath, 15, "\n", true); else : ?> &nbsp; <?php endif; ?> </p> </td>
                    <td> <p style="padding:6px;" class="content"> <?php echo $row_showupload->username; ?> </p> </td>
                    <td> <p class="content" style="padding:6px;"> <?php $str1 = explode('administrator', JURI::base()); $videopath1 = $str1[0]; $videolink1 = 'index.php?option=com_contushdvideoshare&id=' . $row_showupload->id; $videolink = $videopath1 . $videolink1; if ($row_showupload->filepath == "File" || $row_showupload->filepath == "FFmpeg") { $videolink2 = $row_showupload->videourl; if ($videolink2 != "") : ?> <a href="javascript:void(0)" onclick="window.open('<?php echo $videopath . $row_showupload->videourl; ?>','','width=300,height=200,maximize=yes,menubar=no,status=no,location=yes,toolbar=yes,scrollbars=yes')"> <?php echo $newtext = wordwrap($row_showupload->videourl, 15, "\n", true); ?> </a> <?php else : ?> &nbsp; <?php endif; }elseif ($row_showupload->filepath == "Url" || $row_showupload->filepath == "Youtube") { $videolink2 = $row_showupload->videourl; if ($videolink2 != "") : ?> <a href="javascript:void(0)"  onclick="window.open('<?php echo $videolink; ?>','','width=600,height=500,maximize=yes,menubar=no,status=no,location=yes,toolbar=yes,scrollbars=yes')"> <?php echo $newtext = wordwrap($videolink2, 15, "\n", true); ?> </a> <?php else : ?> &nbsp; <?php endif; } ?> </p> </td>
                    <td> <p class="content" style="padding:6px;">  <?php $str1 = explode('administrator', JURI::base()); $thumbpath1 = $str1[0] . "/components/com_contushdvideoshare/videos/"; if ($row_showupload->filepath == "File" || $row_showupload->filepath == "FFmpeg") { $thumblink2 = $row_showupload->thumburl; if ($thumblink2 != "") : ?> <a href="javascript:void(0)" onclick="window.open('<?php echo $thumbpath1 . $row_showupload->thumburl; ?>','','width=300,height=200,menubar=yes,status=yes,location=yes,toolbar=yes,scrollbars=yes')"> <?php echo $newtext = wordwrap($row_showupload->thumburl, 15, "\n", true); ?>  </a> <?php else : ?> &nbsp; <?php endif; } elseif ($row_showupload->filepath == "Url" || $row_showupload->filepath == "Youtube") { $thumblink2 = $row_showupload->thumburl; if ($thumblink2 != "") : ?> <a href="javascript:void(0)" onClick="window.open('<?php echo trim($thumblink2); ?>','','width=600,height=500,menubar=yes,status=yes,location=yes,toolbar=yes,scrollbars=yes')"> <?php echo $newtext = wordwrap($thumblink2, 15, "\n", true); ?> </a> <?php else : ?> &nbsp; <?php endif; } else { ?> &nbsp; <?php } ?> </p> </td>
                    <td> <?php if ($row_showupload->postrollads == 1) $postrollads = "true"; else $postrollads="false"; ?>  <p style="padding:6px;">   <?php echo $postrollads; ?> </p> </td>
                    <td> <?php if ($row_showupload->prerollads == 1) $prerollads = "true"; else $prerollads="false"; ?> <p style="padding:6px;">  <?php echo $prerollads; ?> </p> </td>
                    <td> <?php if ($row_showupload->midrollads == 1) $midrollads = "true"; else $midrollads="false"; ?> <p style="padding:6px;">  <?php echo $midrollads; ?> </p> </td>
                    <td id="<?php echo $row_showupload->id; ?>"> <p style="padding:6px;" id="ordertd_<?php echo $row_showupload->id; ?>"> <?php echo $row_showupload->ordering; ?> </p> </td>
                    <td> <p style="padding:6px;">  <?php echo $published; ?> </p> </td>
                    <td align="center"> <?php $featured = $row_showupload->featured; if ($featured == "1") { $fimg = '<a title="unfeatured Item" onclick="return listItemTask(\'cb' . $i . '\',\'unfeatured\')" href="javascript:void(0);"> <img src="components/com_contushdvideoshare/images/tick.png" /></a>'; } else { $fimg = '<a title="featured Item" onclick="return listItemTask(\'cb' . $i . '\',\'featured\')" href="javascript:void(0);"><img src="components/com_contushdvideoshare/images/publish_x.png" /></a>'; } ?> <?php echo $fimg; ?> </td>
                    <td> <p style="padding:3px;"> <?php echo $row_showupload->id; ?> </p>  </td>

            </tr>
            <?php

                $k = 1 - $k;
                $j++;
            }
            ?>
            <tr>
                <td colspan="18"><?php echo $videolist1['pageNav']->getListFooter(); ?></td>
            </tr>

                <?php } // If condn for count ?>
        </tbody>
    </table>
    <!-- To sort Table Ordering -->
    <input type="hidden" name="filter_order" value="<?php echo $videolist1['lists']['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $videolist1['lists']['order_Dir']; ?>" />
    <input type="hidden" name="task" value="adminvideos" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="memberid" value=<?php echo $row_showupload->memberid; ?> />
    <input type="hidden" name="usertype" value=<?php echo $row_showupload->usertype; ?> />
    <?php echo JHTML::_('form.token'); ?>
</form>
<?php } ?>