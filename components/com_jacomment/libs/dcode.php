<?php
/********************* [DCODE] parser ********************\
               Courtesy of http://oopstudios.com/
           Class for parsing [DCODE] markup into HTML
  \**********************************************************/
if (! class_exists ( 'DCODE' )) {
  class DCODE {
    //
    // A list of the tags and their parsing regex's
    //  Note that extra work is needed for the lists, you can see them in the main function...
    //    
    var $tags = array (
      "LARGE" =>   array ('/\[LARGE\](.*)\[\/LARGE\]/iUs',
                    "<h3>\\1</h3>"),
      "MEDIUM" =>  array ('/\[MEDIUM\](.*)\[\/MEDIUM\]/iUs',
                    "<h4>\\1</h4>"),
      "HR" =>      array ('/\[HR\]/iUs',
                    "<div class=\"hr\"><hr /></div>"),
      "B" =>       array ('/\[B\](.*)\[\/B\]/iUs',
                    "<strong>\\1</strong>"),
      "I" =>       array ('/\[I\](.*)\[\/I\]/iUs',
                    "<em>\\1</em>"),
      "U" =>       array ('/\[U](.*)\[\/U\]/iUs',
                    "<u>\\1</u>"),
      "S" =>       array ('/\[S\](.*)\[\/S\]/iUs',
                    "<strike>\\1</strike>"),
      "UL" =>      array ('/\[\*\](.*)\[\/\*\]/iUs',
                    "<uli>\\1</uli>"),
      "OL" =>      array ('/\[\#\](.*)\[\/\#\]/iUs',
                    "<oli>\\1</oli>"),
      "SUB" =>     array ('/\[SUB\](.*)\[\/SUB\]/iUs',
                    "<sub>\\1</sub>"),
      "SUP" =>     array ('/\[SUP\](.*)\[\/SUP\]/iUs',
                    "<sup>\\1</sup>"),
      "QUOTE" =>   array ('/\[QUOTE(.*)\](.*)\[\/QUOTE\]/iUs',
                    "<blockquote class='comment-quotecontent'>+\\1+\\2<span class='comment-quoteclose'> </span></blockquote>"),
      "LINK" =>    array ('/\[LINK=([\w-]+@([\w-]+\.)+[\w-]+)\]\[\/LINK\]/iUs',
                    "<a href=\"mailto:\\1\">\\1</a>",
                          '/\[LINK=([^\]]*)\]\[\/LINK\]/iUs',
                    "<a href=\"\\1\">\\1</a>",
                          '/\[LINK=([\w-]+@([\w-]+\.)+[\w-]+)\](.+)\[\/LINK\]/iUs',
                    "<a href=\"mailto:\\1\">\\3</a>",
                          '/\[LINK=([^\]]*)\](.+)\[\/LINK\]/iUs',
                    "<a href=\"\\1\">\\2</a>"),
      "IMG" =>     array ('/\[IMG\](.*)\[\/IMG\]/iUs',
                    "<img src=\"\\1\" alt=\"\"/>"),
      "YOUTUBE" => array ('/\[YOUTUBE\](.*)\[\/YOUTUBE\]/iUs',
                    "<youtube>\\1</youtube>")
    );
    //
    // A whitelist of the tags we allow
    //
    var $whiteList = array ("LARGE", "MEDIUM", "HR", "B", "I", "U", "S", "UL", "OL", "SUB", "SUP", "QUOTE", "LINK", "IMG", "YOUTUBE");
    //
    // Functions for modifying the whitelist...
    //
    function addTag ($tag) {
      // Add it if necessary
      $pos = array_search ($tag, $this->whiteList);
      if ($pos === false) {
        if (array_key_exists ($tag, $this->tags)) {
          $this->whiteList[] = $tag;
        }
      }
    }
    
    function parceQuote($strQuote=""){
    	global $jacconfig;
		$app = JFactory::getApplication();
    	if($strQuote == ""){
    		return "";				
    	}else{    		    		
    		$strResult = "";
    		$arrayQuotes = explode("+",$strQuote);
    		$strName = "";
    		$itemID = 0;
    		
    		if(count($arrayQuotes)<=1){
    			return "notParce";    		    		
    		}
    		if($arrayQuotes[1] == ""){
    			return "notParce";
    		}
    		$arrName = explode(":",$arrayQuotes[1]);
    		if(isset($arrName[0])){    		
    			$strName = substr($arrName[0],1);
    		}
    		if(isset($arrName[1])){
    			$itemID  = $arrName[1];
    		}
    		
    		if($strName==""){
    			return "notParce";
    		}else{
    			if($itemID==0){
    				$strResult = '<span class="comment-quotefrom">'.JText::_("QUOTE_FROM").' <strong>'.$strName.'</strong>:</span><br />';	
    			}else{
    				require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'models'.DS.'comments.php');
        			$model = new JACommentModelComments();
        			$item = $model->getComment ($itemID);        			
        			if($item){
						$app = JFactory::getApplication();        				        				
        				$url = $app->isAdmin() ? JURI::root () : JURI::base();        				        			
        				$strResult = '<a href="'.$url.$item->referer.'" class="comment-quotefrom tonus" target="_blank" title="'.JText::_("CLICK_TO_SEE_ORGINAL").'"><span>'.JText::_("QUOTE_FROM").' <strong>'.$strName.'</strong>:</span><br /></a>';					                  			            			                								            	        				
        			}else{
        				$strResult = '<span class="comment-quotefrom">'.JText::_("QUOTE_FROM").' <strong>'.$strName.'</strong>:</span><br />';       			        			
        			}        					   				        			        			        			    				
    			}
    		}
    		    		
    		$strQuote = "";    		
    		for($i = 0; $i< count($arrayQuotes); $i++){
    			if($i==1){
    				$strQuote .= $strResult;			    			
    			}else{
    				$strQuote .= $arrayQuotes[$i];
    			}
    		}    		    		     		
   			return $strQuote; 			
    	}
    }
    
    function removeTag ($tag) {
      // Remove it if it exists
      $pos = array_search ($tag, $this->whiteList);
      if ($pos !== false) {
        array_splice ($this->whiteList, $pos, 1);
      }
    }
    function setTags () {
      $tags = func_get_args ();
      // Check each tag is OK
      $okTags = array ();
      foreach ($tags as $tag) {
        if (array_key_exists ($tag, $this->tags)) {
          // Use keys in case of dupe tags ;-)
          $okTags[$tag] = true;
        }
      }
      $this->whiteList = array_keys ($okTags);
    }
    //
    // Which YouTube method are we using?
    //
    var $youTubeMethod = "default";
    function setYouTubeMethod ($method) {
      // Valid values are default, swfobject_1, swfobject_2, swfobject
      //  everything else is "defaulted"
      $this->youTubeMethod = $method;
    }
    var $youTubeNum = 0;
    function formatYouTube ($matches) {
      // Increment
      $this->youTubeNum ++;
      // id and vidId
      $vidId = $matches[1];
      $id = "dcode_youtube_{$this->youTubeNum}";
      // Output the requested format
      switch ($this->youTubeMethod) {
        case "swfobject_1":
          // SWFObject v1
          return <<<HEREHTML
<div id="{$id}">
  <p><em>You will need to <a href="http://www.adobe.com/products/flashplayer/">get Flash 8</a> or better to watch <a href="http://www.youtube.com/watch?v={$vidId}">this video</a>.</em></p>
</div>
<script type="text/javascript">
   var so = new SWFObject ("http://www.youtube.com/v/{$vidId}", "{$id}_o", "480", "295", "8");
   so.write("{$id}");
</script>
HEREHTML;
          break;
        case "swfobject":
        case "swfobject_2":
          // SWFObject v2
          return <<<HEREHTML
<div id="{$id}">
  <p><em>You will need to <a href="http://www.adobe.com/products/flashplayer/">get Flash 8</a> or better to watch <a href="http://www.youtube.com/watch?v={$vidId}">this video</a>.</em></p>
</div>
<script type="text/javascript">
  swfobject.embedSWF ("http://www.youtube.com/v/{$vidId}", "{$id}", "480", "295", "8", null, null, {allowScriptAccess: "always"}, {id: "{$id}_o"});
</script>
HEREHTML;
          break;
        case "default":
        default:
          // Stright HTML
          return <<<HEREHTML
<object width="480" height="295" id="{$id}_o">
  <param name="movie" value="http://www.youtube.com/v/{$vidId}&amp;hl=en&amp;fs=1"></param>
  <param name="allowFullScreen" value="true"></param>
  <param name="allowscriptaccess" value="always"></param>
  <embed src="http://www.youtube.com/v/{$vidId}&amp;hl=en&amp;fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="295"></embed>
</object>
HEREHTML;
          break;
      }
    }
    //
    // Parses a [DCODE] string into (X)HTML using the tags set
    //
    function parse ($string, $isNofollow) {
      // Convert chars and regulate the line breaks
        $string = htmlentities ($string);
        $string = preg_replace ('/(\r\n|\r)/', "\n", $string);
      // Run the regex's
        foreach ($this->whiteList as $tag) {
          for ($t=0; $t<count ($this->tags[$tag]); $t+=2) {
          	if($isNofollow){
          		if($this->tags[$tag][($t+1)] == "<a href=\"\\1\">\\1</a>"){
          			$this->tags[$tag][($t+1)] = "<a href=\"\\1\" rel=\"nofollow\">\\1</a>";
          		}
          		if($this->tags[$tag][($t+1)] == "<a href=\"\\1\">\\2</a>"){
          			$this->tags[$tag][($t+1)] = "<a href=\"\\1\" rel=\"nofollow\">\\2</a>";
          		}
          	}
          	$quoteString = $string;          	
            $string = preg_replace ($this->tags[$tag][$t], $this->tags[$tag][($t+1)], $string);
          	//part data for quote
          	if($this->tags[$tag][($t+1)] == "<blockquote class='comment-quotecontent'>+\\1+\\2<span class='comment-quoteclose'></span></blockquote>"){
          		$string = $this->parceQuote($string);          		
          		if($string=="notParce"){
          			$string = preg_replace ($this->tags[$tag][$t], "<blockquote class='comment-quotecontent'>\\1\\2<span class='comment-quoteclose'></span></blockquote>", $quoteString);
          					          		          			
          		}
          	}
          }
        }
      // Split up block elements
        $preg = "/(<(h3|h4|div|blockquote|uli|oli|youtube)[^>]*>)(.*)(<\/\\2>)/Us";
        $matches = preg_split ($preg, $string, -1, PREG_SPLIT_DELIM_CAPTURE);
        // Uncomment this line to see how the "shape" of the split worked and thus
        // how / why the next part is as it is!
        // echo "<pre>" . htmlentities (print_r ($matches, true)) . "</pre>";
      // Add <br /> and <p>...</p> where needed
        $string = "";
        for ($m=-4, $n=count ($matches); $m<$n; $m+=5) {
          // $m   = opening tag
          // $m+1 = tagname (ignore)
          // $m+2 = untrimmed tag contents
          // $m+3 = closing tag
          @$string .= "\n" . $matches[$m] . str_replace ("\n", "<br />", trim ($matches[$m+2])) . $matches[$m+3];
          // $m+4 = paragraph(s)
          $tmp = trim ($matches[$m+4]);
          if ($tmp) {
            $tmp = preg_replace ("/\n\n+/", "</p><p>", $tmp);
            $tmp = preg_replace ("/\n/", "<br />", $tmp);
            $tmp = preg_replace ("/<\/p><p>/", "</p>\n<p>", $tmp);
            $string .= "\n<p>" . $tmp . "</p>";
          }
        }
      // Do them youtubers!
        $string = preg_replace_callback ("/<youtube>(.*)<\/youtube>/iUs", array ($this, 'formatYouTube'), $string);
      // Lists need wrapping up
        // This step always seems unnecesarily large, the truth is that I can't
        // get my head around any regex I could use with preg_replace!
        $preg = "/(<(u|o)li>.*<\/\\2li>)/Us";
        $matches = preg_split ($preg, $string, -1, PREG_SPLIT_DELIM_CAPTURE);
        // Loop and group
        $string = "";
        $curlist = "";
        for ($m=0, $n=count ($matches); $m<$n; $m+=3) {
          // $m = plain content (or empty)
          if (trim ($matches[$m])) {
            // Close the previous list?
            if ($curlist) {
              $string .= "</{$curlist}l>";
              $curlist = "";
            }
            // The string
            $string .= $matches[$m];
          }
          // $m+1 = list item
          // $m+2 = list item type
          if (@$matches[$m+2]) {
            if (!$curlist) {
              $string .= "<" . $matches[$m+2] ."l>\n";
            } elseif ($matches[$m+2] != $curlist) {
              $string .= "</{$curlist}l>\n<" . $matches[$m+2] ."l>\n";
            }
            $curlist = $matches[$m+2];
            $string .= "  " . $matches[$m+1] . "\n";
          }
        }
        // If the last entry is empty, close the final list
        echo @$matches[$n];
        if (!trim (@$matches[$n])) {
          if ($curlist) {
            $string .= "</{$curlist}l>";
          }
        }
        // Change <uli> & <oli> to plain old <li>
        $string = preg_replace ('/<(\/?)(uli|oli)>/iUs', '<$1li>', $string);
        // Add line-breaks to <br /> (just a visual thing)
        $string = preg_replace ('/<br\s\/>/iUs', "<br />\n", $string);
      // Return
        return trim ($string);
    }
  }
}
?>