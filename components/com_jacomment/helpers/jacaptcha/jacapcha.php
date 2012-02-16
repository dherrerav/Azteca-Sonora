<?php
// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ();

class jacapcha {
	
	var $seesion;
	var $text;
	var $valid_text = false;
	var $draw_lines = false;
	var $draw_lines_over_text = false;
	var $arc_linethrough = false;
	var $arcline_colors = "#8080ff,#cccfff,#000fff,#fffccc";
	var $text_color = "#ff0000";
	var $usepatern = false;
	// use P=point,L=line,C=circle,E=elipse,CF=fillcircle,EF=fillelipse;T=text
	var $paternType = "p,l,c,e,cf,ef,t";
	var $paternRandColor = 0;
	var $use_multi_text = true;
	var $multi_text_color = "#0a68dd,#f65c47,#8d32fd";
	var $image_bg_color = "#F8F7F8";
	var $xpos_start = 4;
	var $font_size = 18;
	var $text_entered;
	var $text_angle_minimum = - 20;
	var $text_angle_maximum = 20;
	var $text_minimum_space = 20;
	var $text_maximum_space = 25;
	var $use_transparent_text = true;
	var $text_transparency_percentage = 30;
	var $line_color = "#80BFFF";
	var $line_space = 5;
	var $line_thickness = 1;
	var $draw_angled_lines = false;
	var $im;
	var $ttf_file = "components/com_jacomment/helpers/jacaptcha/font.ttf";
	var $bgimg;
	var $text_length = 5;
	var $charset = 'ABCDEFGHKLMNPRSTUVWYZ23456789';
	var $imgwidth = 120;
	var $imgheight = 40;
	
	function jacapcha($background = "") {
		if ($background != "") {
			$this->bgimg = $background;
		}
		$this->seesion = & JFactory::getSession ();
	}
	
	function buildImage($type = "addnew") {
		$this->image = imagecreatetruecolor ( $this->imgwidth, $this->imgheight );
		$bgcolor = imagecolorallocate ( $this->image, hexdec ( substr ( $this->image_bg_color, 1, 2 ) ), hexdec ( substr ( $this->image_bg_color, 3, 2 ) ), hexdec ( substr ( $this->image_bg_color, 5, 2 ) ) );
		imagefilledrectangle ( $this->image, 0, 0, imagesx ( $this->image ), imagesy ( $this->image ), $bgcolor );
		if ($this->bgimg != "") {
			$this->setBackground ();
		}
		$this->generateText ( $this->text_length, $type );
		if (! $this->draw_lines_over_text && $this->draw_lines)
			$this->addLines ();
			//$this->addPatern();
		$this->addWord ();
		if ($this->arc_linethrough == true)
			$this->addarcLines ();
		if ($this->draw_lines_over_text && $this->draw_lines)
			$this->addLines ();
		$this->outputimage ();
	}
	
	function outputimage() {
		header ( "Expires: Sun, 1 Nov 2009 09:00:00 GMT" );
		header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s" ) . "GMT" );
		header ( "Cache-Control: no-store, no-cache, must-revalidate" );
		header ( "Cache-Control: post-check=0, pre-check=0", false );
		header ( "Pragma: no-cache" );
		//$output_type = $this->params->get("IMAGE_TYPE");
		$output_type = 2;
		switch ($output_type) {
			case 0 :
				header ( "Content-Type: image/jpeg" );
				imagejpeg ( $this->image, null, 90 );
				break;
			case 1 :
				header ( "Content-Type: image/gif" );
				imagegif ( $this->image );
				break;
			case 2 :
				header ( "Content-Type: image/png" );
				imagepng ( $this->image );
				break;
		}
		imagedestroy ( $this->image );
	}
	
	function setBackground() {
		$imagefile = @getimagesize ( $this->bgimg );
		if ($imagefile == false) {
			return;
		}
		$type = $imagefile [2];
		switch ($type) {
			case 1 :
				$backimg = @imagecreatefromgif ( $this->bgimg );
				break;
			case 2 :
				$backimg = @imagecreatefromjpeg ( $this->bgimg );
				break;
			case 3 :
				$backimg = @imagecreatefrompng ( $this->bgimg );
				break;
			case 15 :
				$backimg = @imagecreatefromwbmp ( $this->bgimg );
				break;
			case 16 :
				$backimg = @imagecreatefromxbm ( $this->bgimg );
				break;
			default :
				return;
		}
		if (! $backimg)
			return;
		imagecopy ( $this->image, $backimg, 0, 0, 0, 0, $this->imgwidth, $this->imgheight );
	}
	
	function generateText($length, $type) {
		
		$text = '';
		for($i = 1, $cslen = strlen ( $this->charset ); $i <= $length; ++ $i) {
			$text .= strtoupper ( $this->charset {rand ( 0, $cslen - 1 )} );
		}
		$this->text = $text;
		$this->saveText ( $type );
	
	}
	
	function saveText($type = "addnew") {
		if ($type == "addnew") {
			setcookie ( 'text_captchanew', strtolower ( $this->text ), time () + 3600 );
		} else {
			setcookie ( 'text_captchareply', strtolower ( $this->text ), time () + 3600 );
		}
	}
	
	function validateText($type = "addnew") {
		if ($type == "addnew") {
			$securimage_text = isset ( $_COOKIE ["text_captchanew"] ) ? $_COOKIE ["text_captchanew"] : "";
		} else {
			$securimage_text = isset ( $_COOKIE ["text_captchareply"] ) ? $_COOKIE ["text_captchareply"] : "";
		}
		//echo $securimage_text;die();   
		if (isset ( $securimage_text ) && $securimage_text !== "") {
			if ($securimage_text == strtolower ( trim ( $this->text_entered ) )) {
				$this->valid_text = true;
				setcookie ( 'text_captcha', '', 360 );
			} else {
				$this->valid_text = false;
			}
		} else {
			$this->valid_text = false;
		}
	}
	function addlines() {
		$linecolor = imagecolorallocate ( $this->image, hexdec ( substr ( $this->line_color, 1, 2 ) ), hexdec ( substr ( $this->line_color, 3, 2 ) ), hexdec ( substr ( $this->line_color, 5, 2 ) ) );
		imagesetthickness ( $this->image, $this->line_thickness );
		
		//ver lines
		for($x = 1; $x < $this->imgwidth; $x += $this->line_space) {
			imageline ( $this->image, $x, 0, $x, $this->imgheight, $linecolor );
		}
		//hor lines
		for($y = 11; $y < $this->imgheight; $y += $this->line_space) {
			imageline ( $this->image, 0, $y, $this->imgwidth, $y, $linecolor );
		}
		//angle lines
		if ($this->draw_angled_lines == true) {
			for($x = - ($this->imgheight); $x < $this->imgwidth; $x += $this->line_space) {
				imageline ( $this->image, $x, 0, $x + $this->imgheight, $this->imgheight, $linecolor );
			}
			for($x = $this->imgwidth + $this->imgheight; $x > 0; $x -= $this->line_space) {
				imageline ( $this->image, $x, 0, $x - $this->imgheight, $this->imgheight, $linecolor );
			}
		}
	
	}
	/* Add the CAPTCHA text over the image */
	function addWord() {
		if ($this->use_transparent_text == true) {
			$alpha = intval ( $this->text_transparency_percentage / 100 * 127 );
			$font_color = imagecolorallocatealpha ( $this->image, hexdec ( substr ( $this->text_color, 1, 2 ) ), hexdec ( substr ( $this->text_color, 3, 2 ) ), hexdec ( substr ( $this->text_color, 5, 2 ) ), $alpha );
		} else { //no transparency
			$font_color = imagecolorallocate ( $this->image, hexdec ( substr ( $this->text_color, 1, 2 ) ), hexdec ( substr ( $this->text_color, 3, 2 ) ), hexdec ( substr ( $this->text_color, 5, 2 ) ) );
		}
		$x = $this->xpos_start;
		$strlen = strlen ( $this->text );
		$y_min = ($this->imgheight / 2) + ($this->font_size / 2) - 2;
		$y_max = ($this->imgheight / 2) + ($this->font_size / 2) + 2;
		$colors = explode ( ',', $this->multi_text_color );
		
		for($i = 0; $i < $strlen; ++ $i) {
			$angle = rand ( $this->text_angle_minimum, $this->text_angle_maximum );
			$y = rand ( $y_min, $y_max );
			if ($this->use_multi_text == true) {
				$idx = rand ( 0, sizeof ( $colors ) - 1 );
				$r = substr ( $colors [$idx], 1, 2 );
				$g = substr ( $colors [$idx], 3, 2 );
				$b = substr ( $colors [$idx], 5, 2 );
				if ($this->use_transparent_text == true) {
					$font_color = imagecolorallocatealpha ( $this->image, "0x$r", "0x$g", "0x$b", $alpha );
				} else {
					$font_color = imagecolorallocate ( $this->image, "0x$r", "0x$g", "0x$b" );
				}
			}
			imagettftext ( $this->image, $this->font_size, $angle, $x, $y, $font_color, $this->ttf_file, $this->text {$i} );
			$x += rand ( $this->text_minimum_space, $this->text_maximum_space );
		}
	}
	
	function addarcLines() {
		$colors = explode ( ',', $this->arcline_colors );
		imagesetthickness ( $this->image, 5 );
		$color = $colors [rand ( 0, sizeof ( $colors ) - 1 )];
		$linecolor = imagecolorallocate ( $this->image, hexdec ( substr ( $color, 1, 2 ) ), hexdec ( substr ( $color, 3, 2 ) ), hexdec ( substr ( $color, 5, 2 ) ) );
		$xpos = $this->xpos_start + rand ( 20, 40 );
		$width = $this->imgwidth / 2.55 + rand ( 3, 10 );
		$height = $this->imgheight / 2.55 + rand ( 3, 10 );
		if (rand ( 0, 100 ) % 2 == 0) {
			$start = rand ( 0, 66 );
			$ypos = $this->imgheight / 2 - rand ( 5, 15 );
			$xpos += rand ( 1, 5 );
		} else {
			$start = rand ( 180, 246 );
			$ypos = $this->imgheight / 2 + rand ( 5, 15 );
		}
		
		$end = $start + rand ( 95, 130 );
		//imagearc($this->image, 0, $ypos, $width, $height, $start, $end, $linecolor);
		imagearc ( $this->image, $xpos, $ypos, $width, $height, $start, $end, $linecolor );
		
		$color = $colors [rand ( 0, sizeof ( $colors ) - 1 )];
		$linecolor = imagecolorallocate ( $this->image, hexdec ( substr ( $color, 1, 2 ) ), hexdec ( substr ( $color, 3, 2 ) ), hexdec ( substr ( $color, 5, 2 ) ) );
		
		if (rand ( 1, 75 ) % 2 == 0) {
			$start = rand ( 45, 111 );
			$ypos = $this->imgheight / 2 - rand ( 5, 15 );
			$xpos += rand ( 5, 15 );
		} else {
			$start = rand ( 200, 250 );
			$ypos = $this->imgheight / 2 + rand ( 5, 15 );
		}
		$end = $start + rand ( 75, 100 );
		imagearc ( $this->image, $this->imgwidth * .75, $ypos, $width, $height, $start, $end, $linecolor );
	
	}
	
	function addPatern() {
		
		$PTypeNumA = explode ( ',', $this->paternType );
		$PRand = $PTypeNumA [rand ( 0, count ( $PTypeNumA ) - 1 )];
		$PTypeNum = explode ( ';', $PRand );
		$PatType = $PTypeNum [0];
		$PatNum = @$PTypeNum [1];
		
		if ($PatNum == '') {
			if (strpos ( $PatType, 'c' ) !== false)
				$PatNum = 50;
			elseif (strpos ( $PatType, 'e' ) !== false)
				$PatNum = 50;
			elseif ($PatType == 't')
				$PatNum = 500;
			elseif ($PatType == 'p')
				$PatNum = 2;
			elseif ($PatType == 'l')
				$PatNum = 10;
			else
				$PatNum = 10;
		}
		
		$fontcolor = imagecolorallocate ( $this->image, rand ( 160, 255 ), rand ( 160, 255 ), rand ( 160, 255 ) );
		
		for($x = 0; $x <= $this->imgwidth * $this->imgheight / $PatNum; $x ++) {
			$myX = rand ( 1, $this->imgwidth );
			$myY = rand ( 1, $this->imgheight );
			$myZ1 = rand ( 4, 10 );
			if (strpos ( $PatType, 'e' ) === false) {
				$myZ2 = $myZ1;
			} else {
				$myZ2 = rand ( 4, 10 );
			}
			if ($PatType == 'p') {
				if ($this->paternRandColor == 1)
					$fontcolor = imagecolorallocate ( $this->image, rand ( 64, 255 ), rand ( 64, 255 ), rand ( 64, 255 ) );
				imageline ( $this->image, $myX, $myY, $myX, $myY, $fontcolor );
			}
			if ($PatType == 'l') {
				if ($this->paternRandColor == 1)
					$fontcolor = imagecolorallocate ( $this->image, rand ( 64, 255 ), rand ( 64, 255 ), rand ( 64, 255 ) );
				imageline ( $this->image, $myX, $myY, $myX + rand ( - 5, 5 ), $myY + rand ( - 5, 5 ), $fontcolor );
			}
			
			if (strpos ( $PatType, 'c' ) === false ^ strpos ( $PatType, 'e' ) === false) {
				if (strpos ( $PatType, 'f' ) === false) {
					$fontcolor = imagecolorallocate ( $this->image, rand ( 64, 255 ), rand ( 64, 255 ), rand ( 64, 255 ) );
					imageellipse ( $this->image, $myX, $myY, $myZ1, $myZ2, $fontcolor );
				} else {
					$fontcolor = imagecolorallocate ( $this->image, rand ( 160, 255 ), rand ( 160, 255 ), rand ( 160, 255 ) );
					imagefilledellipse ( $this->image, $myX, $myY, $myZ1, $myZ2, $fontcolor );
				}
			}
			
			if ($PatType == 't') {
				$Char = substr ( $this->charset, rand ( 0, strlen ( $this->charset ) - 1 ), 1 );
				if ($this->paternRandColor == 1)
					$fontcolor = imagecolorallocate ( $this->image, rand ( 192, 255 ), rand ( 192, 255 ), rand ( 192, 255 ) );
				imagettftext ( $this->image, rand ( $this->imgheight / 3, $this->imgheight / 3 ), rand ( - 10, 10 ), $myX, $myY, $fontcolor, $this->ttf_file, $Char );
			}
		}
	}
}

?>
