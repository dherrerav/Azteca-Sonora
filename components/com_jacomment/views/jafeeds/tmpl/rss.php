<?php 
	defined('_JEXEC') or die('Restricted access'); 
	define("TIME_ZONE","");	
	include(JPATH_COMPONENT.DS.'helpers'.DS.'feedcreator.class.php');

	$app = JFactory::getApplication();
	$helper = new JACommentHelpers();
	
	if (isset($this->feed_alias))
		$feedid = $this->feed_alias;
	else 
		$feedid = time();
	$docache = intval($this->cache)>0?1:0;
	//add_stats($lists); /*<< MAD 2007/09/28 */ //Oct 24 2008
	

	//if type is Summaries then get numwords from db
	//$numWords = $this->numWords > 0  ? $this->numWords: 10000; // numWord == 0 represents ALL

	//make a feed id based filename
	$filename = JPATH_COMPONENT.DS."views".DS."jafeeds".DS."feeds".DS."feeds".$feedid.".xml";
	$rss = new UniversalFeedCreator();

	//Use cache if docache is set to 1
	if (intval($docache)==1) {
	    $rss->useCached($this->type,$filename,$this->cache); // use cached version if age<1 hour. May not return!
	}
	$rss->title 				= htmlspecialchars($this->title);
	$rss->description			= "Description jacomment";			
	$rss->link 					= JURI::root();
	$rss->syndicationURL 		= $_SERVER['SERVER_NAME']. $_SERVER["PHP_SELF"];
	$rss->descriptionHtmlSyndicated 	= true;

	$image 						= new FeedImage();
	$image->title 				= $app->getCfg('sitename');
	$image->url 				= $this->imgUrl;
	$image->link 				= JURI::root();	
	$image->descriptionHtmlSyndicated	= true;

	if ( $this->imgUrl!="") { $rss->image = $image; }	
	$rows = $this->items;//var_dump($rows);		
	if (is_array($rows))
	foreach ($rows as $row) {
		$item 		 = new FeedItem();
		$item->title = htmlspecialchars($row->name);
								
		$itemurl = $row->referer;
		$itemurl = str_replace('&amp;', '&', $itemurl);
		$itemurl = str_replace('&', '&amp;', $itemurl);
		$lastIndex = strpos($itemurl, "index.php");
		$itemurl = substr($itemurl, $lastIndex);

		$item->link = $itemurl;
        
		$item->guid = $itemurl;		
		//set avata image			      						
		
        $AddReadMoreLink = false;   		
		$words = $helper->replaceBBCodeToHTML($row->comment);					
		$words = html_entity_decode($helper -> showComment($words));												
		$words = addAbsoluteURL($words);//LVH Oct 26 2008
		$item->description 			= $words;
		
		$item->descriptionHtmlSyndicated	= true;		
		$itemDate = JFactory::getDate(JHTML::_('date', $row->date, JText::_('DATE_FORMAT_LC2')));		
		$item->date 				= $itemDate->toUnix() ;
		if($row->voted >0){
			$item->voted 				= "+".$row->voted;
		}else{
			$item->voted 				= $row->voted;				
		}
		$rss->addItem($item);		
	}
	
 	$rss->saveFeed($this->type,$filename,true);
	



function noHTML($words) {
    $words = preg_replace("'<script[^>]*>.*?</script>'si","",$words);
	$words = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $words);
	$words = preg_replace('/<!--.+?-->/','',$words);
	$words = preg_replace('/{.+?}/','',$words);
	$words = strip_tags($words);
	$words = preg_replace('/&nbsp;/',' ',$words);
	$words = preg_replace('/&amp;/','&',$words);
	$words = preg_replace('/&quot;/','"',$words);

	return $words;
}

function addAbsoluteURL($html) {
	$root_url = JURI::root();
	$html = preg_replace('@href="(?!http://)(?!https://)([^"]+)"@i', "href=\"{$root_url}\${1}\"", $html);
	$html = preg_replace('@src="(?!http://)(?!https://)([^"]+)"@i', "src=\"{$root_url}\${1}\"", $html);

	return $html;
}

/*
** Delete all the images from the url
*/
function delImagesFromHTML($html) {
  $html = preg_replace('/<img\\s.*>/i','', $html);

  return $html;
}

/* >> MAD 2007/10/09
 * Added function word_limiter
 */
function word_limiter($string, $limit = 100) {
	$words = array();
	$string = eregi_replace(" +", " ", $string);
	$array = explode(" ", $string);
	//$limit = (count($array) <= $numwords) ? count($array) : $numwords;
	for($k=0;$k < $limit;$k++)
	{
		if($limit>0 && $limit == $k)
			break;
		if (eregi("[0-9A-Za-zÀ-ÖØ-öø-ÿ]", $array[$k]))
			$words[$k] = $array[$k];
	}
	$txt = implode(" ", $words);
	return $txt;
}
?>