<?php
/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
?>
<?php
/* comment page coding */
?>

    <input type="hidden" name="id" id="id" value="<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>">
<?php
$user = & JFactory::getUser();
$cmdid = '';
$catid = '';
$cat_id = '';
$cmdid = JRequest::getvar('cmdid', '', 'get', 'int');
$id = JRequest::getVar('id', '', 'get', 'int');
$catid = JRequest::getVar('catid', '', 'get', 'int');
$requestpage = JRequest::getVar('page', '', 'post', 'int');
if ($cmdid == 4) {
?>
<link rel="stylesheet" href="<?php echo JURI::base(); ?>components/com_jcomments/tpl/default/style.css" type="text/css" />
<script type="text/javascript" src="<?php echo JURI::base(); ?>includes/js/joomla.javascript.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jcomments/js/jcomments-v2.1.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jcomments/libraries/joomlatune/ajax.js"></script>
<style type="text/css">

    #comments .comments-list {margin-left: 20px;height:auto}
</style>
<?php
    $comments = JPATH_ROOT . '/components/com_jcomments/jcomments.php';
    if (file_exists($comments)) {
        require_once($comments);
        echo JComments::showComments(JRequest::getVar('id', '', 'get', 'int'),
                'com_contushdvideoshare', $this->commenttitle[0]->title);
    }
}
if ($cmdid == 3) {
?>
<?php require_once( JPATH_PLUGINS . DS . 'content' . DS . 'jom_comment_bot.php' );
    echo jomcomment(JRequest::getVar('id', '', 'get', 'int'), "com_contushdvideoshare"); ?>
  <?php
}
if ($cmdid == 2) {
    if ($id) {
        $tot = count($this->commenttitle);
?>
<?php ?>
        <br/><br/><br/>
        <div class="comment_textcolumn" style="">
            <script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/membervalidator.js"></script>
            <!-- FORM STARTS HERE -->
            <div style="width:<?php echo '500'; ?>px;" class="commentstop" >
                <div class="floatleft"><div class="leave"><?php echo _HDVS_COMMENTS; ?> (<span id="commentcount"><?php echo $this->commenttitle['totalcomment']; ?></span>)</div></div>
<?php if ($user->get('id') != '') { ?>
                    <div class="commentpost"  style="float:right"><a  onclick="comments();" class="utility-link"><?php echo _HDVS_POST_COMMENT; ?></a></div>

        <?php } else {

         if(version_compare(JVERSION,'1.6.0','ge')) { ?>
                    <div class="commentpost"  style="float:right"><a  href="index.php?option=com_users&view=registration"  class="utility-link"><?php echo _HDVS_POST_COMMENT; ?></a></div>
          <?php } else {?>       <!--<div class="commentpost"  style="float:right"><a  onclick="comments_login();" class="utility-link"><?php echo _HDVS_POST_COMMENT; ?></a></div> -->
            <div class="commentpost"  style="float:right"><a  href="index.php?option=com_user&view=register" class="utility-link"><?php echo _HDVS_POST_COMMENT; ?></a></div>
<?php } } ?>
    </div>
    <div class="clear"></div>

<?php
        if ($id && $catid) {
            $id = $id;
            $cat_id = $catid;
        } ?>
        <div id="initial"></div>
        <div id="al"></div>
        <!--FORM ends HERE -->
        <!-- Comments display starts here -->
<?php
        $sum = count($this->commenttitle1);
        if ($sum != 0) {
?>
            <div class="underline"></div>
    <?php } ?>
        <!--FIRST ROW HERE-->
    <?php $page = $_SERVER['REQUEST_URI']; ?>
<?php
        $j = 0;
        foreach ($this->commenttitle1 as $row) {
?>
    <?php if ($row->parentid == 0) {
    ?>
                <div class="clearfix" >
                    <div class="subhead changecomment" ><?php echo $row->name; ?> : <span></span></div>
    <?php if ($user->get('id') != '') {
 ?>

                        <div class="reply changecomment1"><a class="cursor_pointer"onclick="textdisplay(<?php echo $row->id; ?>); parentvalue(<?php
                    if ($row->parentid != 0) {
                        echo $row->parentid;
                    } else {
                        echo $row->id;
                    } ?>)" title="Reply for this comment" value="1" id="hh">Reply</a></div>

            <?php } ?>
        </div>
        <div  class="word_wrap"><?php echo $string = nl2br($row->message); ?></div>

<?php } else {
?>
            <div class="clsreply" ><div>
                    <strong>Re : <span><?php echo $row->name; ?></span></strong>
                    <div class="word_wrapnew"><?php echo $string = nl2br($row->message); ?></div>
                </div>
            </div>
<?php } ?>
            <div id="<?php
            if ($row->parentid != 0) {
                echo $row->parentid;
            } else {
                echo $row->id;
            }
?>"></div>

    <?php
            if ($j < $sum - 1) {

                if ($this->commenttitle1[$j + 1]->parentid == 0) {
    ?>
                    <div class="underline"></div>
<?php }
            } $j++; ?>
    <?php } ?>
        <!-- Comments display ends here -->
        <script type="text/javascript">
            {
                function parentvalue(parentid)
                {

                    document.getElementById('parentvalue').value=parentid;
                    document.getElementById('name').focus();
                }
            }
        </script>
        <!--  PAGINATION STARTS HERE-->
        <table cellpadding="0" cellspacing="0" border="0"   id="pagination" class="floatright">
            <tr align="right">
                <td align="right"  class="page_rightspace">
                    <table cellpadding="0" cellspacing="0"  border="0" align="right">
                        <tr>
<?php
        $q = $this->commenttitle['pageno'] - 1;
        if ($this->commenttitle['pageno'] > 1)
            echo("<td align='right' class='changecolor'><a class='cursor_pointer' onclick='changepage($q);'>" . _HDVS_PREVIOUS . "</a></td>");
        if ($requestpage) {
            if ($requestpage > 3) {
                $page = $requestpage - 2;
                if ($requestpage > 2) {
                    echo("<td align='right' class='changecolor'><a onclick='changepage(1)' class='cursor_pointer'>1</a></td>");
                    echo ("<td align='right' class='changecolor'>...</td>");
                }
            }
            else
                $page=1;
        }
        else
            $page=1;
        for ($i = $page, $j = 1; $i <= $this->commenttitle['pages']; $i++, $j++) {
            if ($this->commenttitle['pageno'] != $i)
                echo("<td align='right' class='changecolor'><a onclick='changepage(" . $i . ")' class='cursor_pointer'>" . $i . "</a></td>");
            else
                echo("<td align='right' class='changecolor'><a onclick='changepage($i);' class='active cursor_pointer' >$i</a></td>");
            if ($j > 2)
                break;
        }
        if ($i < $this->commenttitle['pages']) {
            if ($i + 1 != $this->commenttitle['pages'])
                echo ("<td align='right' class='changecolor'>...</td>");
            echo("<td align='right' class='changecolor'><a onclick='changepage(" . $this->commenttitle['pages'] . ")'>" . $this->commenttitle['pages'] . "</a></td>");
        }
        $p = $this->commenttitle['pageno'] + 1;
        if ($this->commenttitle['pageno'] < $this->commenttitle['pages'])
            echo ("<td align='right' class='changecolornew' ><a onclick='changepage($p);' class='cursor_pointer'>" . _HDVS_NEXT . "</a></td>");
?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--  PAGINATION ENDS HERE-->

    <input type="hidden" value="" id="divnum">
                        <?php
                        $memberidvalue = '';
                        if (JRequest::getVar('memberidvalue', '', 'post', 'int')) {
                            $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                        }
                        ?>
    <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
        <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberidvalue; ?>" />
    </form>
<?php
                        $page = 'index.php?option=com_contushdvideoshare&view=player&id=' . JRequest::getVar('id', '', 'get', 'int');
                        $hiddensearchbox = $searchtextbox = $hidden_page = '';
                        $searchtextbox = JRequest::getVar('searchtxtbox', '', 'post', 'string');
                        $hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');
                        if ($requestpage) {
                            $hidden_page = $requestpage;
                        } else {
                            $hidden_page = '';
                        }
                        if ($searchtextbox) {
                            $hidden_searchbox = $searchtextbox;
                        } else {
                            $hidden_searchbox = $hiddensearchbox;
                        }
?>
                        <form name="pagination" id="pagination" action="<?php echo $page; ?>" method="post">
                            <input type="hidden" id="page" name="page" value="<?php echo $hidden_page ?>" />
                            <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php echo $hidden_searchbox; ?>" />
                        </form>
                        <div id="txt" >
                            <form  id="form" name="commentsform" action="javascript:insert(<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>)" method="post" onsubmit="return validation(this);hidebox();" >
                                <span class="label"> <?php echo _HDVS_NAME; ?>  : </span>
                                <div class="bgbox">
                                    <div class="searchpos">
                                        <input type="text" name="username" id="username" class="newinputbox commenttxtbox"  />
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <span class="label"><?php echo _HDVS_COMMENT; ?>   : </span>
                                <div class="messageboxbg">
                                    <div class="searchpos">
                                        <font>
                                            <textarea class="messagebox commenttxtarea" name="message" id="message"
                                                      onKeyDown="CountLeft(this.form.message,this.form.left,500);"
                                                      onKeyUp="CountLeft(this.form.message,this.form.left,500);" ></textarea>
                                            <div   class="remaining_character"><div class="floatleft" >Remaining Characters:</div>
                                                <div class="commenttxt"><input readonly type="text" name="left" size=1 maxlength=8 value="500" style="border:none;background:none;width:70px;" /></div></div>
                                        </font>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <input type="hidden" name="videoid" value="<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>" id="videoid"/>
                                <input type="hidden" name="category" value="<?php echo $cat_id; ?>" id="category"/>
                                <input type="hidden" name="parentid" value="0" id="parent"/>
                                <input type="submit" value="Post comment" class="button clsinputnew"  />
                                <input type="hidden" name="postcomment" id="postcomment" value="true">
                                <input type="hidden"  value="" id="parentvalue" name="parentvalue" />
                                <div align="center" id="prcimg"  style="display:none;"><img src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/images/commentloading.gif" width="100px"></div>
                            </form><br/>
                            <div id="insert_response" class="msgsuccess"></div><br/>
                            <script> document.getElementById('prcimg').style.display="none"; </script>
                        </div>
                        <script type="text/javascript">

                            function membervalue(memid)
                            {
                                document.getElementById('memberidvalue').value=memid;
                                document.memberidform.submit();
                            }

                            function changepage(pageno)
                            {
                                document.getElementById("page").value=pageno;
                                document.pagination.submit();
                            }
                            function validation(form)
                            {
                                alert("hai");
                                if(document.getElementById('name').value=='')
                                {
                                    alert("Enter Your Name");
                                    document.getElementById('name').focus();
                                    return false;
                                }
                                var comments=form.message.value;
                                if(comments.length==0)
                                {
                                    alert("Enter Your Message");
                                    form.message.focus();
                                    return false;
                                }
                                return true;
                            }


                            function GetXmlHttpObject()
                            {
                                if (window.XMLHttpRequest)
                                {
                                    // code for IE7+, Firefox, Chrome, Opera, Safari
                                    return new XMLHttpRequest();
                                }
                                if (window.ActiveXObject)
                                {
                                    // code for IE6, IE5
                                    return new ActiveXObject("Microsoft.XMLHTTP");
                                }
                                return null;
                            }


                            var xmlhttp;
                            var nocache = 0;
                            function insert()
                            {
                                alert("cmd");
                                var name= encodeURI(document.getElementById('name').value);
                                var message = encodeURI(document.getElementById('message').value);
                                var id= encodeURI(document.getElementById('id').value);

                                var category= encodeURI(document.getElementById('category').value);
                                var parentid= encodeURI(document.getElementById('parentvalue').value);
                                // Set te random number to add to URL request
                                nocache = Math.random();
                                xmlhttp=GetXmlHttpObject();
                                if (xmlhttp==null)
                                {
                                    alert ("Browser does not support HTTP Request");
                                    return;
                                }
                                document.getElementById('prcimg').style.display="block";
                                alert("adsad");
                                var url="index.php?option=com_contushdvideoshare&view=player&id="+id+"&category="+category+"&name="+name+"&message=" +message+"&pid="+parentid+"&nocache = "+nocache;
                                url=url+"&sid="+Math.random();
                                xmlhttp.onreadystatechange=stateChanged;
                                xmlhttp.open("GET",url,true);
                                xmlhttp.send(null);

                            }
                            function stateChanged()
                            {
                                if (xmlhttp.readyState==4)
                                {
                                    document.getElementById('prcimg').style.display="none";
                                    var name= document.getElementById('name').value;
                                    var message =document.getElementById('message').value;
                                    var id= encodeURI(document.getElementById('videoid').value);
                                    var boxid= encodeURI(document.getElementById('id').value);
                                    var category= encodeURI(document.getElementById('category').value);
                                    var parentid= encodeURI(document.getElementById('parentvalue').value);
                                    document.getElementById('name').disabled=true;
                                    document.getElementById('message').disabled=true;
                                    if(parentid==0)
                                    {
                                        document.getElementById("al").innerHTML="<div class='underline'></div><div class='clearfix'><div class='subhead changecomment'>"+name+" : <span></span></div></div><div>"+message+"</div>"+document.getElementById("al").innerHTML;
                                        commentcountval=document.getElementById('commentcount').innerHTML;
                                        document.getElementById('commentcount').innerHTML=parseInt(commentcountval)+1;
                                    }
                                    else
                                    {
                                        document.getElementById(parentid).innerHTML="<div class='clsreply'><div><strong>Re : <span>"+name+"</span></strong><div>"+message+"</div></blockquote>";
                                        commentcountval=document.getElementById('commentcount').innerHTML;
                                        document.getElementById('commentcount').innerHTML=parseInt(commentcountval)+1;
                                    }
                                    document.getElementById('txt').style.display="none";
                                    document.getElementById('initial').innerHTML=" ";
                                }
                            }
                            window.onload=function()
                            {
                                document.getElementById('txt').style.display="none";

                            }
                            function comments()
                            {
                                var d=document.getElementById('txt').innerHTML;
                                document.getElementById('initial').innerHTML=d;
                            }


                            function CountLeft(field, count, max)
                            {
                                // if the length of the string in the input field is greater than the max value, trim it
                                if (field.value.length > max)
                                    field.value = field.value.substring(0, max);
                                else
                                    count.value = max - field.value.length;
                            }
                            function textdisplay(rid)
                            {

                                if(document.getElementById('divnum').value>0 )
                                {
                                    document.getElementById(document.getElementById('divnum').value).innerHTML="";

                                }
                                document.getElementById('initial').innerHTML=" ";
                                var r=rid;
                                var d=document.getElementById('txt').innerHTML;
                                document.getElementById(r).innerHTML=d;
                                document.getElementById('txt').style.display="none";
                                document.getElementById('divnum').value=r;
                            }
                            function hidebox()
                            {
                                document.getElementById('txt').style.display="none";
                                document.getElementById('initial').innerHTML=" ";

                            }

                            function hiddinv()
                            {

                            }

                        </script>
                        <div class="clear"></div></div>
<?php
                    }
                }
                
?>
</body>