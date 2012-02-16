<?php
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	$captcha->valid_text = false;
	$captcha->draw_lines = false;
	$captcha->draw_lines_over_text = false;
	$captcha->arc_linethrough = false;
	$captcha->arcline_colors = "#8080ff,#cccfff,#000fff,#fffccc";
	$captcha->text_color = "#ff0000";
	$captcha->usepatern = false;
	// use P=point,L=line,C=circle,E=elipse,CF=fillcircle,EF=fillelipse;T=text
	$captcha->paternType = "p,l,c,e,cf,ef,t";
	$captcha->paternRandColor = 0;
	$captcha->use_multi_text = true;
	$captcha->multi_text_color = "#0a68dd,#f65c47,#8d32fd";
	$captcha->image_bg_color = "#F8F7F8";
	$captcha->xpos_start = 4;
	$captcha->font_size = 18;
	$captcha->text_entered;
	$captcha->text_angle_minimum = - 20;
	$captcha->text_angle_maximum = 20;
	$captcha->text_minimum_space = 20;
	$captcha->text_maximum_space = 25;
	$captcha->use_transparent_text = true;
	$captcha->text_transparency_percentage = 30;
	$captcha->line_color = "#80BFFF";
	$captcha->line_space = 5;
	$captcha->line_thickness = 1;
	$captcha->draw_angled_lines = false;
	$captcha->im;
	$captcha->ttf_file = $helper->getFontOfCaptcha();
	$captcha->bgimg;
	$captcha->text_length = 5;
	$captcha->charset = 'ABCDEFGHKLMNPRSTUVWYZ23456789';
	$captcha->imgwidth = 120;
	$captcha->imgheight = 40;