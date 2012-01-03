<?php
/*
* "ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
function contushdvideoshareBuildRoute( &$query )
{
    $segments = array();

    if (isset($query['view'])) {
        $segments[] = $query['view'];
        unset( $query['view'] );
    }
    if (isset($query['id'])) {
        $segments[] = $query['id'];
        unset( $query['id'] );
    }
     if (isset($query['catid'])) {
        $segments[] = $query['catid'];
        unset( $query['catid'] );
    }
    if (isset($query['type'])) {
        $segments[] = $query['type'];
        unset( $query['type'] );
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
function contushdvideoshareParseRoute( $segments )
{
    $vars = array();

    // view is always the first element of the array
    $count = count($segments);




    if ($count)
    {

	   switch($segments[0])
       {
               case 'category':
                       $vars['view'] = 'category';
					   $vars['catid'] = $segments[1];
                       break;
               case 'player':
                       $vars['view'] = 'player';
                       if(isset($segments[1]))
					   $vars['id'] = $segments[1];
                        if(isset($segments[2]))
					  $vars['catid'] =$segments[2];
                       break;
			    case 'configxml':
                $vars['view'] = 'configxml';
                if(isset($segments[1]))
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
                case 'commentlogin':
                $vars['view'] = 'commentlogin';
                if(isset($segments[1]))
		$vars['rmode'] =$segments[1];
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
						   if(isset($segments[1]))
						$vars['id'] =$segments[1];
						if(isset($segments[2]))
						$vars['type'] =$segments[2];
                       break;
             case 'commentappend':
                       $vars['view'] = 'commentappend';
					   if(isset($segments[1]))
					$vars['id'] =$segments[1];
					if(isset($segments[2]))
					$vars['cmdid'] =$segments[2];
                       break;
       }



    }


    return $vars;
}