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
$EMAIL_TEMPLATES_CONFIG = '

== TAGSET configs ==
CONFIG_ADMIN_EMAIL - Administrator email
CONFIG_SITE_CONTACT_EMAIL - Site \'s email
CONFIG_SITE_TITLE - Site Title
CONFIG_ROOT_URL - Root URL of the script
EMAIL_PREFERENCE_LINK - Email preference
== TAGSET user ==
USERS_USERNAME - User\'s username
USERS_EMAIL - User\'s email
USERS_CURRENTUSER - User\'s email
== TAGSET user_post==
USERS_USERNAME_POST - User\'s username
USERS_EMAIL_POST - User\'s email
== TAGSET item_content ==
ITEM_TITLE - Title
ITEM_TITLE_WITH_LINK - Title with link
ITEM_FORUM - forum
ITEM_CREATE_DATE - Create Date
ITEM_CREATE_BY - Create By
ITEM_NUM_OF_VOTERS - Number Of Voters
ITEM_NUM_OF_VOTERS_DOWN - Number Of Voters Down
ITEM_TOTAL_VOTE_DOWN - Total Vote Down
ITEM_NUM_OF_VOTERS_UP - Number Of Voters Up
ITEM_TOTAL_VOTE_UP - Total Vote Up
ITEM_NEW_STATUS_WITH_COLOR - New Status 
ITEM_NEW_STATUS - New Status 
ITEM_OLD_STATUS - Old Status 
== TAGSET item_details ==
ITEM_DETAILS - item details
==EMAIL TAGS user,item_content,configs==
Jacommentnotify_to_user_item_change_status:Jacommentnotify_to_user_item_change_status.txt - Notify to users when item change status
==EMAIL TAGS user,item_content,configs==
Jacommentnotifying_those_whose_comment_has_been_deleted:Jacommentnotifying_those_whose_comment_has_been_deleted.txt - Notify to users when item was deleted
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentnotify_when_new_item_was_post:Jacommentnotify_when_new_item_was_post.txt - Notify to users when item was deleted
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentnotifying_comment_creator_if_there_is_a_new_reply_to_his_comment:Jacommentnotifying_comment_creator_if_there_is_a_new_reply_to_his_comment.txt - Notify to users when item was deleted
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentnotifying_admin_on_a_new_comment_posted:Jacommentnotifying_admin_on_a_new_comment_posted.txt - Notifying admin on a new comment posted 
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentnotifying_those_whose_comment_has_been_approved:Jacommentnotifying_those_whose_comment_has_been_approved.txt - Notifying admin on a new comment posted 
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentnotifying_those_whose_comment_is_reported_as_spam:Jacommentnotifying_those_whose_comment_is_reported_as_spam.txt - Notifying admin on a new comment posted 
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentnotifying_those_whose_comment_has_been_unapproved:Jacommentnotifying_those_whose_comment_has_been_unapproved.txt - Notifying admin on a new comment posted 
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentnotifying_admin_of_a_spam_report_on_a_comment:Jacommentnotifying_admin_of_a_spam_report_on_a_comment.txt - Notifying admin on a new comment posted 
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentnotifying_those_whose_comment_is_removed_as_spam_by_admin:Jacommentnotifying_those_whose_comment_is_removed_as_spam_by_admin.txt - Notifying admin on a new comment posted 
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentconfirmation_sent_to_new_comment_creator_need_admin_approved:Jacommentconfirmation_sent_to_new_comment_creator.txt - Notify to users when item was deleted
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentconfirmation_sent_to_new_comment_creator_dont_need_admin_approved:Jacommentconfirmation_sent_to_new_comment_creator_dont_approved.txt - Notify to users when item was deleted
==EMAIL TAGS user,user_post,item_content,configs==
Jacommentnotifying_comment_creator_if_there_is_a_new_comment_on_the_issue:Jacommentnotifying_comment_creator_if_there_is_a_new_comment_on_the_issue.txt - Notify to users when add new
==EMAIL TAGS user,configs,item_details==
Jacommentnotify_to_user_new_voice_weekly:Jacommentnotify_to_user_new_voice_weekly.txt - Notify to users for history item
==EMAIL TAGS user,configs,item_details==
Jacommentnotify_to_user_new_voice_daily:Jacommentnotify_to_user_new_voice_daily.txt - Notify to users for history item
==EMAIL TAGS configs==
mailheader:mailheader.txt - Header
==EMAIL TAGS configs==
mailfooter:mailfooter.txt - Footer
';


$PARSED_EMAIL_TEMPLATES_CONFIG = array(
    'tagset' => array(),
    'emails' => array(),
);