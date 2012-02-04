<?php

/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */

function contushdvideoshareBuildRoute(&$query) {
    $segments = array();

    //Code for get itemid if itemid is empty. It's used to add alias name in URL link
    $db = JFactory::getDBO();
    if (empty($query['Itemid']))
    {
        $db->setQuery("select id from #__menu where link='index.php?option=com_contushdvideoshare&view=index' and published=1 order by id desc Limit 1");
        $query['Itemid'] = $db->loadResult();
    }
     if (isset($query['view']))
     {
        $segments[] = $query['view'];
        unset($query['view']);
    }
    if (isset($query['catid'])) {
        $segments[] = $query['catid'];
        unset($query['catid']);
    } else if (isset($query['category'])) {
        $segments[] = $query['category'];
        unset($query['category']);
    }
    if (isset($query['id'])) {
        $segments[] = $query['id'];
        unset($query['id']);
    }
    else if (isset($query['video'])) {
        $segments[] = $query['video'];
        unset($query['video']);
    }
    if (isset($query['type'])) {
        $segments[] = $query['type'];
        unset($query['type']);
    }
    if (isset($query['channelname'])) {
        $segments[] = $query['channelname'];
        unset($query['channelname']);
    }
    if (isset($query['category'])) {
        $segments[] = $query['category'];
        unset($query['category']);
    }
    if (isset($query['title'])) {
        $segments[] = $query['title'];
        unset($query['title']);
    }
    

    return $segments;
}

/**
 * @param	array	A named array
 * @param	array
 *
 * Formats:
 *
 * index.php?/banners/task/bid/Itemid
 *
 * index.php?/banners/bid/Itemid
 */
function contushdvideoshareParseRoute($segments) {


    $vars = array();
    // view is always the first element of the array
    $count = count($segments);
    //echo '<pre>';print_r($segments);
    if ($count) {
        switch ($segments[0]) {
            case 'category':
                $vars['view'] = 'category';
                $vars['category'] = $segments[1];
                break;
            case 'player':
                $vars['view'] = 'player';
                if (isset($segments[2])) {
                    $vars['category'] = $segments[1];
                    $vars['video'] = $segments[2];
                } else {
                  //  $vars['video'] = $segments[1];
                }
                break;
            case 'configxml':
                $vars['view'] = 'configxml';
                $vars['id'] = $segments[1];
                if (isset($segments[2]))
                    $vars['catid'] = $segments[2];
                break;
            case 'playxml':
                $vars['view'] = 'playxml';
                $vars['id'] = $segments[1];
                if (isset($segments[2]))
                    $vars['catid'] = $segments[2];
                break;

            case 'adsxml':
                $vars['view'] = 'adsxml';
                break;
            case 'midrollxml':
                $vars['view'] = 'midrollxml';
                break;
            case 'languagexml':
                $vars['view'] = 'languagexml';
                break;
            case 'playerbase':
                $vars['view'] = 'playerbase';
                break;
            case 'featuredvideos':
                $vars['view'] = 'featuredvideos';
                break;
            case 'myvideos':
                $vars['view'] = 'myvideos';
                break;
            case 'recentvideos':
                $vars['view'] = 'recentvideos';
                break;
            case 'myvideos':
                $vars['view'] = 'myvideos';
                break;
            case 'hdvideosharesearch':
                $vars['view'] = 'hdvideosharesearch';
                break;
            case 'membercollection':
                $vars['view'] = 'membercollection';
                break;
            case 'popularvideos':
                $vars['view'] = 'popularvideos';
                break;
            case 'relatedvideos':
                $vars['view'] = 'relatedvideos';
                break;
            case 'recentvideos':
                $vars['view'] = 'recentvideos';
                break;
            case 'featuredvideos':
                $vars['view'] = 'featuredvideos';
                break;
            case 'videoupload':
                $vars['view'] = 'videoupload';
                if (isset($segments[1]))
                    $vars['id'] = $segments[1];
                if (isset($segments[2]))
                    $vars['type'] = $segments[2];
                break;
            case 'mychannel':
                $vars['view'] = 'mychannel';               
                if (isset($segments[1]))
                    $vars['channelname'] = $segments[1];
                if (isset($segments[2]))
                    $vars['title'] = $segments[2];
                break;
            case 'channelsettings':
                $vars['view'] = 'channelsettings';
                 break;
            case 'playlist':
                $vars['view'] = 'playlist';
                if (isset($segments[1]))
                    $vars['category'] = $segments[1];
                break;
                 break;

        }
    }
    return $vars;
}

