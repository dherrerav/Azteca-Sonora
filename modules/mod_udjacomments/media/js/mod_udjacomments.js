/**
* @author Andy Sharman
* @copyright Andy Sharman (www.udjamaflip.com)
* @link http://www.udjamaflip.com
* @license GNU/GPL V2+
* @version 1.0rc1
* @package mod_udjacomments
**/ 

jQuery.noConflict();

jQuery(document).ready(function ($) {

    $('.commentReplyLink').click(function () {
        var id = $(this).attr('id');
        $('#hdnIsReply').val(id);
        $('form#frmCommentPost h3.commentsTitle').text('Replying to comment...');
        document.location.href = '#frmCommentPost';
        $('#txtUdjaName').focus();
        return false;
    });

});