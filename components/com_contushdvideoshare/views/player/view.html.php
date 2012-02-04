<?php

/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewplayer extends JView {

    function display() {
        $videoid = '';
        $categoryid = '';
        $videourl = '';
        $model = & $this->getModel();

        /* CODE FOR SEO OPTION OR NOT - START */
        $video = JRequest::getVar('video');
        $id = JRequest::getInt('id');
        $flagVideo = is_numeric($video);
        if (isset($video) && $video != "") {
            if ($flagVideo != 1) {

                // joomla router replaced to : from - in query string
                $videoTitle = JRequest::getString('video');
                $video = str_replace(':', '-', $videoTitle);
                $videodetails = $model->getVideoId($video);
                $videoid = $videodetails->id;
                $categoryid = $videodetails->playlistid;
                $videodetails->videourl = $videodetails->videourl;
            } else {
                $videoid = JRequest::getInt('video');
                $videodetails = $model->getVideodetail($videoid);
                $categoryid = JRequest::getInt('category');
                $videodetails->id = $videoid;
                $videodetails->playlistid = $categoryid;
                $videodetails->videourl = $videodetails->videourl;
            }
            $this->assignRef('videodetails', $videodetails);
        } else if (isset($id) && $id != '') {

            $videoid = JRequest::getInt('id');
            $videodetails = $model->getVideodetail($videoid);
            $categoryid = JRequest::getInt('catid');
            $videodetails->id = $videoid;
            $videodetails->playlistid = $categoryid;
            $videodetails->videourl = $videodetails->videourl;
            $this->assignRef('videodetails', $videodetails);
        } else {
            $videodetails->id = $videoid;
            $videodetails->playlistid = $categoryid;
            $videodetails->videourl = '';
            $this->assignRef('videodetails', $videodetails);
        }
        /* CODE FOR SEO OPTION OR NOT - END */

        //Code for html5 player
        $htmlVideoDetails = $model->getHTMLVideoDetails($videoid);
        $this->assignRef('htmlVideoDetails', $htmlVideoDetails);

        $getfeatured = $model->getfeatured();
        $this->assignRef('getfeatured', $getfeatured);

        $detail = $model->showhdplayer($videoid, $categoryid);
        $this->assignRef('detail', $detail);

        $commentsview = $model->ratting($videoid, $categoryid);
        $this->assignRef('commentview', $commentsview);

        $comments = $model->displaycomments($videoid, $categoryid); // calling the function in models comment.php
        $this->assignRef('commenttitle', $comments[0]); // Assigning the reference for the results
        $this->assignRef('commenttitle1', $comments[1]); // Assigning the reference for the results

        $homepagebottom = $model->gethomepagebottom(); //calling the function in models homepagebottom.php
        $this->assignRef('rs_playlist1', $homepagebottom); // assigning the reference for the results

        $homepagebottomsettings = $model->gethomepagebottomsettings(); //calling the function in models homepagebottom.php
        $this->assignRef('homepagebottomsettings', $homepagebottomsettings); // assigning the reference for the results

        $homeAccessLevel = $model->getHTMLVideoAccessLevel();
        $this->assignRef('homepageaccess', $homeAccessLevel);
        parent::display();
    }

}
?>   
