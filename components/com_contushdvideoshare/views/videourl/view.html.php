<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class contushdvideoshareViewvideourl extends JView
{

	function display()
	{
        $model =& $this->getModel();
		$detail = $model->getallvideourl();
	}
function getvideourl()
	{
        $model =& $this->getModel();

		$detail = $model->getallvideourl();
	}
    function getallvideourl()
    {


        $this->showallurl();
        exit();

    }

    function showallurl()
    {
        //$video = new hdflvplayerModelvideourl();
        //$video =$this->getyoutube($videourl);

        $vurl="";
        $vurl=JRequest::getvar('url','','get','var');
        $imgurl=JRequest::getvar('imageurl','','get','var');

 //if(isset($_GET['url']) && isset($_GET['imageurl']))
 if(($vurl) && ($imgurl))
        {
            //$vurl=$_GET['url'];
            $vurl=$vurl;
            $video=$this->getVideoType($vurl);
            if ($this->url AND $this->type != '') {

                $vidurl=$this->catchURL();
            }
            $vidurl[0] = str_replace("&","%26",$vidurl[0]);
            $vidurl[1] = str_replace("&","%26",$vidurl[1]);
            $vidurl[2] = str_replace("&","%26",$vidurl[2]);

            $vurl=$imgurl;
            $video=$this->getVideoType($vurl);

            $imgurl =$this->imgURL($vurl);
            print("&location1=".$vidurl[0]."&location2=".$vidurl[1]."&location3=".$vidurl[2]."&imageurl=".$imgurl);
            //print($imgurl);
            exit();

        }
        if($vurl)
        {
            $vurl=$vurl;
            $video=$this->getVideoType($vurl);


            if ($this->url AND $this->type != '') {

                $vidurl=$this->catchURL();
            }
            /*$vidurl[0] = str_replace("&","$",$vidurl[0]);
            $vidurl[1] = str_replace("&","$",$vidurl[1]);
            $vidurl[2] = str_replace("&","$",$vidurl[2]); */

            $vidurl[0] = str_replace("&","%26",$vidurl[0]);
            $vidurl[1] = str_replace("&","%26",$vidurl[1]);
            $vidurl[2] = str_replace("&","%26",$vidurl[2]);

            print("&location1=".$vidurl[0]."&location2=".$vidurl[1]."&location3=".$vidurl[2]);
        }
        //elseif(isset($_GET['imageurl']))
         elseif($imgurl)
        {
            $vurl=$imgurl;
            $video=$this->getVideoType($vurl);

            $imgurl =$this->imgURL($vurl);
            print($imgurl);
            exit();



        }


    }




        function page_exists($url){

            $c = curl_init();

            $url = trim($url);

            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($c, CURLOPT_URL, $url);

            $contents = curl_exec($c);

            curl_close($c);

            if($contents) {

                return true;

            } else {

                return false;

            }

        } // END page_exists() FUNCTION



        // THIS FUNCTION CATCHES FLV URL

        // INPUT: $url REPRESENTING THE URL





        // THIS FUNCTION CATCHES FLV URL

        // INPUT: $url REPRESENTING THE URL

        // OUTPUT: TRUE OR FALSE

         function getVideoType($location, $add = 0){


            if(preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $location, $vresult)) {

                $type= 'youtube';

            } elseif(preg_match('/http:\/\/(.*?)blip\.tv\/file\/[0-9]+/', $location, $vresult)) {


                $type= 'bliptv';

            } elseif(preg_match('/http:\/\/(.*?)break\.com\/(.*?)\/(.*?)\.html/', $location, $vresult)) {

                $type= 'break';

            } elseif(preg_match('/www\.metacafe\.com\/watch\/(.*?)\/(.*?)\//', $location, $vresult)) {

                $type= 'metacafe';

            } elseif(preg_match('/http:\/\/video\.google\.com\/videoplay\?docid=[^&]+/', $location, $vresult)) {

                $type= 'google';

            } elseif(preg_match('/http:\/\/www\.dailymotion\.com\/video\/+/', $location, $vresult)) {

                $type= 'dailymotion';
                $vresult[0]=$location;
            }


            $this->url = $vresult[0];

            $this->type = $type;







        } // END getVideoType() FUNCTION



        function imgURL()
        {

            $contents = trim($this->file_get_contents_curl($this->url));
            switch ($this->type) {
                case "youtube":
                    $location_img_url = explode('watch?v=',$this->url);
                    echo $this->url."<br>";
                    print_r($location_img_url)."<br>";
                    $img = 'http://img.youtube.com/vi/'.$location_img_url[1].'/1.jpg';
                    echo $img;
                    break;
                case "bliptv":
                    preg_match('/rel=\"image_src\" href=\"http:\/\/[^\"]+/', $contents, $result_img);
                    preg_match('/http:\/\/[^\"]+/', $result_img[0], $result_img);
                    $img = $result_img[0];
                    break;
                case "break":
                    preg_match('/meta name=\"embed_video_thumb_url\" content=\"http:\/\/[^\"]+/', $contents, $result_img);
                    preg_match('/http:\/\/[^\"]+/', $result_img[0], $result_img);
                    $img = $result_img[0];
                    break;
                case "metacafe":
                    preg_match('/thumb_image_src=http%3A%2F%2F(.*?)%2Fthumb%2F[0-9]+%2F[0-9]+%2F[0-9]+%2F(.*?)%2F[0-9]+%2F[0-9]+%2F(.*?)\.jpg/', $contents, $result_img);
                    preg_match('/http%3A%2F%2F(.*?)%2Fthumb%2F[0-9]+%2F[0-9]+%2F[0-9]+%2F(.*?)%2F[0-9]+%2F[0-9]+%2F(.*?)\.jpg/', $result_img[0], $result_img);
                    $img = urldecode($result_img[0]);
                    break;
                case "google":
                    preg_match('/http:\/\/[0-9]\.(.*?)\.com\/ThumbnailServer2%3Fapp%3D(.*?)%26contentid%3D(.*?)%26offsetms%3D(.*?)%26itag%3D(.*?)%26hl%3D(.*?)%26sigh%3D[^\\\\]+/', $contents, $result);
                    $img = urldecode($result[0]);
                    break;
                case "dailymotion":
                    $img=str_replace('www.dailymotion.com','www.dailymotion.com/thumbnail',$this->url);
                    break;
                }


                return $img;



            } // END getType() FUNCTION






            // THIS FUNCTION CATCHES FLV URL

            // INPUT: $url REPRESENTING THE VIDEO PAGE URL

            // OUTPUT: ARRAY CONTAINING $location AND $type

            function catchData(){



                $newInfo = trim($this->file_get_contents_curl($this->url));



                switch ($this->type) {

                    case "youtube":

                        $feed = explode("=", $this->url);

                        $feed = "http://gdata.youtube.com/feeds/api/videos/".$feed[1];

                        $newInfo = trim($this->file_get_contents_curl($feed));



                        preg_match('/<media:title(.*?)<\/media:title>/', $newInfo, $result);

                        $title = strip_tags($result[0]);



                        preg_match('/<media:description(.*?)<\/media:description>/', $newInfo, $result);

                        $desc = strip_tags($result[0]);



                        preg_match('/<media:keywords(.*?)<\/media:keywords>/', $newInfo, $result);

                        $tags = strip_tags(str_replace(",", "", $result[0]));



                        break;

                    case "bliptv":

                        preg_match('/div id=\"EpisodeTitle\">(.*?)<\/div>/', $newInfo, $result);

                        $title = str_replace('div id="EpisodeTitle">', '', $result[0]);

                        $title = stripslashes(str_replace('</div>', '', $title));



                        preg_match('/div class=\'BlipDescription\'><p>(.*?)<\/p><\/div>/', $newInfo, $result);

                        $desc = str_replace('div class=\'BlipDescription\'><p>', '', $result[0]);

                        $desc = stripslashes(str_replace('</p></div>', '', $desc));

                        $desc = strip_tags(preg_replace("/<br(.*?)>/", "\n", $desc));



                        preg_match('/<a href=\'http:\/\/blip\.tv\/topics\/view\/(.*?)<\/a>\s/', $newInfo, $result);

                        $tags = strip_tags(str_replace(",", "", $result[0]));



                        break;

                    case "metacafe":

                        $new_string = preg_replace("/\n|\r\n|\r$/", "", $newInfo);

                        $new_string = preg_replace("/>\s{2,}</", "> <", $new_string);



                        preg_match('/<h1 id=\"ItemTitle\">(.*?)<\/h1>/', $new_string, $result);

                        $title = preg_replace("/<br(.*?)>/", "\n", $result[0]);

                        $title = trim(strip_tags($title));



                        preg_match('/<div id=\"Desc\">(.*?)<\/div>/', $new_string, $result);

                        $desc = preg_replace("/<br(.*?)>/", "\n", $result[0]);

                        $desc = trim(strip_tags($desc));



                        preg_match('/<dd>(.*?)<\/dd>/', $new_string, $result);

                        $tags = preg_replace("/<br(.*?)>/", "\n", $result[0]);

                        $tags = trim(strip_tags($tags));



                        break;

                    case "break":

                        $new_string = preg_replace("/\n|\r\n|\r$/", "", $newInfo);

                        $new_string = preg_replace("/>\s{2,}</", "> <", $new_string);



                        preg_match('/meta name="title" content="[^\"]+/', $new_string, $result);

                        $pos = strrpos($result[0], "\"");

                        $title = substr($result[0], $pos+1);



                        preg_match('/meta name=\"embed_video_description\" id=\"vid_desc\" content="[^\"]+/', $new_string, $result);

                        $pos = strrpos($result[0], "\"");

                        $desc = substr($result[0], $pos+1);



                        preg_match('/meta name="keywords" content="[^\"]+/', $new_string, $result);

                        $pos = strrpos($result[0], "\"");

                        $tags = str_replace(",", "", substr($result[0], $pos+1));



                        break;

                    case "google":

                        $new_string = preg_replace("/\n|\r\n|\r$/", "", $newInfo);

                        $new_string = preg_replace("/>\s{2,}</", "> <", $new_string);



                        preg_match('/<span id=details-title>(.*?)<\/span>/', $new_string, $result);

                        $title = trim(strip_tags($result[0]));



                        preg_match('/<p id=details-desc>(.*?)<p id=share-report>/', $new_string, $result);

                        $desc = trim(strip_tags($result[0]));

                        if (substr($desc, -7) == '&laquo;') {

                            $desc = substr($desc, 0, -7);

                        }



                        $tags = "";



                        break;

                    case "dailymotion":

                        $new_string = preg_replace("/\n|\r\n|\r$/", "", $newInfo);

                        $new_string = preg_replace("/>\s{2,}</", "> <", $new_string);



                        preg_match('/<h1 class="dmco_title">(.*?)<\/h1>/', $new_string, $result);

                        $title = trim(strip_tags($result[0]));



                        preg_match('/<div class="dmco_html column span-8 last video_description foreground" id="video_description">(.*?)<\/div>/', $new_string, $result);

                        $desc = trim(strip_tags($result[0]));

                        if (substr($desc, -7) == '&laquo;') {

                            $desc = substr($desc, 0, -7);

                        }



                        $tags = "";



                        break;

                    }



                    return array($title, $desc, $tags);



                } // END catchData() FUNCTION

                function http_test_existance($url, $timeout = 10) {
                    $timeout = (int)round($timeout/2+0.00000000001);
                    $return = array();

                    ### 1 ###
                    $inf = parse_url($url);

                    if (!isset($inf['scheme']) or $inf['scheme'] !== 'http') return array('status' => -1);
                    if (!isset($inf['host'])) return array('status' => -2);
                    $host = $inf['host'];

                    if (!isset($inf['path'])) return array('status' => -3);
                    $path = $inf['path'];
                    if (isset($inf['query'])) $path .= '?'.$inf['query'];

                    if (isset($inf['port'])) $port = $inf['port'];
                    else $port = 80;

                    ### 2 ###
                    $pointer = fsockopen($host, $port, $errno, $errstr, $timeout);
                    if (!$pointer) return array('status' => -4, 'errstr' => $errstr, 'errno' => $errno);
                    socket_set_timeout($pointer, $timeout);

                    ### 3 ###
                    $head =
                        'HEAD '.$path.' HTTP/1.1'."\r\n".
                        'Host: '.$host."\r\n";

                    if (isset($inf['user']))
                    $head .= 'Authorization: Basic '.
                    base64_encode($inf['user'].':'.(isset($inf['pass']) ? $inf['pass'] : ''))."\r\n";
                    if (func_num_args() > 2) {
                        for ($i = 2; $i < func_num_args(); $i++) {
                            $arg = func_get_arg($i);
                            if (
                                strpos($arg, ':') !== false and
                                strpos($arg, "\r") === false and
                                strpos($arg, "\n") === false
                            ) {
                                $head .= $arg."\r\n";
                            }
                        }
                    }
                    else $head .= 'User-Agent: Selflinkchecker 1.0 (http://aktuell.selfhtml.org/artikel/php/existenz/)'."\r\n";

                    $head .= 'Connection: close'."\r\n"."\r\n";

                    ### 4 ###
                    fputs($pointer, $head);

                    $response = '';

                    $status = socket_get_status($pointer);
                    while (!$status['timed_out'] && !$status['eof']) {
                        $response .= fgets($pointer);
                        $status = socket_get_status($pointer);
                    }
                    fclose($pointer);
                    if ($status['timed_out']) {
                        return array('status' => -5, '_request' => $head);
                    }

                    ### 5 ###
                    $res = str_replace("\r\n", "\n", $response);
                    $res = str_replace("\r", "\n", $res);
                    $res = str_replace("\t", ' ', $res);

                    $ares = explode("\n", $res);
                    $first_line = explode(' ', array_shift($ares), 3);

                    $return['status'] = trim($first_line[1]);
                    $return['reason'] = trim($first_line[2]);

                    foreach ($ares as $line) {
                        $temp = explode(':', $line, 2);
                        if (isset($temp[0]) and isset($temp[1])) {
                            $return[strtolower(trim($temp[0]))] = trim($temp[1]);
                        }
                    }

                    //$return['_response'] = $response;
                    //$return['_request'] = $head;



                    return $return;
                }




function file_get_contents_curl($url) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
      curl_setopt($ch, CURLOPT_URL, $url);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
      }





                // THIS FUNCTION CATCHES FLV URL

                // INPUT: $url REPRESENTING THE VIDEO PAGE URL

                // OUTPUT: ARRAY CONTAINING $location AND $type

                function catchURL(){
                    $url = $this->url;
                    $vid_location=array();
                    $newInfo = trim($this->file_get_contents_curl($url));

                    switch ($this->type) {

                        case "youtube":

                            $urlArray = split("=", $url);

                            $videoid = trim($urlArray[1]);



                            $pageurl = $_SERVER["HTTP_REFERER"];

                            $newAPIurl = "http://www.youtube.com/get_video_info?&video_id=$videoid";

                            $newAPIurl .= "&el=embedded&ps=chromeless&eurl=$pageurl";



                            $newInfo = trim($this->file_get_contents_curl($newAPIurl));

                            $infoArray = split("&", $newInfo);

                            for ($i=0; $i < count($infoArray); $i++) {

                                $tmp = split("=", $infoArray[$i]);

                                $key = urldecode($tmp[0]);

                                $val = urldecode($tmp[1]);

                                $paramArray["$key"] = "$val";

                            }



                            if (array_key_exists("token", $paramArray)) {

                                $t = $paramArray["token"];

                            } else {

                                $legacyAPIurl="http://www.youtube.com/api2_rest?method=youtube.videos.get_video_token&video_id=$videoid";

                                $t = trim(strip_tags($this->file_get_contents_curl($legacyAPIurl)));

                            }


                            $vid = "http://www.youtube.com/get_video.php?video_id=$videoid&t=$t&fmt=18";
                            $response=$this->http_test_existance($vid);
                            $uri=$response["location"];
                            $vid_location[0] = $uri;
                            $vid = "http://www.youtube.com/get_video.php?video_id=$videoid&t=$t&fmt=22";
                            $response=$this->http_test_existance($vid);
                            $uri=$response["location"];
                            $vid_location[1] = $uri;
                            $vid = "http://www.youtube.com/get_video.php?video_id=$videoid&t=$t";
                            $response=$this->http_test_existance($vid);
                            $uri=$response["location"];
                            $vid_location[2] = $uri;






                            break;

                        case "bliptv":

                            preg_match('/http:\/\/(.*?)blip\.tv\/file\/get\/(.*?)\.flv/', $newInfo, $result);





                            $vid_location[0] = urldecode($result[0]);



                            break;

                        case "break":

                            preg_match('/sGlobalFileName=\'[^\']+/', $newInfo, $resulta);

                            $resulta = str_replace('sGlobalFileName=\'', '', $resulta[0]);

                            preg_match('/sGlobalContentFilePath=\'[^\']+/', $newInfo, $resultb);

                            $resultb = str_replace('sGlobalContentFilePath=\'', '', $resultb[0]);



                            $vid_location[0] = 'http://media1.break.com/dnet/media/'.$resultb.'/'.$resulta.'.flv';




                            break;

                        case "metacafe":

                            preg_match('/mediaURL=http%3A%2F%2F(.*?)%2FItemFiles%2F%255BFrom%2520www.metacafe.com%255D%25(.*?)\.flv+/', $newInfo, $result);
                            preg_match('/http%3A%2F%2F(.*?)%2FItemFiles%2F%255BFrom%2520www.metacafe.com%255D%25(.*?)\.flv+/', $result[0], $result);

                            $vid_location[0] = urldecode(str_replace('&gdaKey', '?__gda__', $result[0]));



                            break;

                        case "google":



                            preg_match('/http:\/\/(.*?)googlevideo.com\/videoplayback%3F[^\\\\]+/', $newInfo, $result);



                            $vid_location[0] = urldecode($result[0]);



                            break;
                        case "dailymotion":

                            preg_match('/"video", "(.*?)"/', $newInfo, $result);

                            $flv = preg_split('/@@(.*?)\|\|/', urldecode($result[1]));

                            $vid_location[0]       = $flv[0];

                            break;


                    }


                    return $vid_location;



                } // END catchURL() FUNCTION


}
?>   
