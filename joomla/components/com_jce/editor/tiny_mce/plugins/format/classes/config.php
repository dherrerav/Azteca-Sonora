<?php
/**
 * @version		$Id: config.php 71 2011-02-20 14:01:27Z happy_noodle_boy $
 * @package     JCE
 * @copyright   Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author		Ryan Demmer
 * @license     GNU/GPL 2 - See licence.txt
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class WFFormatPluginConfig
{
    public function getConfig(&$settings)
    {
       	$model 	= JModel::getInstance('editor', 'WFModel');
    	$wf 	= WFEditor::getInstance();
        
		// Add format plugin to plugins list
        if (!in_array('format', $settings['plugins'])) {
            $settings['plugins'][] = 'format';
        }

        // Encoding
        $settings['entity_encoding'] 	= $wf->getParam('editor.entity_encoding', 'raw', 'named');
        $settings['inline_styles'] 		= $wf->getParam('editor.inline_styles', 1, 1);
        
        // Paragraph handling
        $settings['forced_root_block'] 	= $wf->getParam('editor.forced_root_block', 'p', 'p');
        
        $formats = array(
        	'advanced.paragraph' 	=> 'p',
			'advanced.address' 		=> 'address',
			'advanced.pre' 			=> 'pre',
			'advanced.h1' 			=> 'h1',
			'advanced.h2' 			=> 'h2',
			'advanced.h3' 			=> 'h3',
			'advanced.h4' 			=> 'h4',
			'advanced.h5' 			=> 'h5',
			'advanced.h6' 			=> 'h6',
			'advanced.div'			=> 'div',
			'advanced.blockquote' 	=> 'blockquote',
			'advanced.code' 		=> 'code',
			'advanced.dt' 			=> 'dt',
			'advanced.dd' 			=> 'dd',
			'advanced.samp' 		=> 'samp',
			'advanced.span' 		=> 'span'
        );
        
        $blocks = $wf->getParam('editor.theme_advanced_blockformats', 'p,div,address,pre,h1,h2,h3,h4,h5,h6,code,samp,span', 'p,address,pre,h1,h2,h3,h4,h5,h6');
        
        $list = array();
        
        foreach($formats as $k => $v) {
        	if (in_array($v, explode(',', $blocks))) {
        		$list[$k] = $v; 
        	}
        }
		
		// Format list / Remove Format
		$settings['theme_advanced_blockformats'] = json_encode($list);

        $settings['removeformat_selector'] = $wf->getParam('editor.removeformat_selector', 'span,b,strong,em,i,font,u,strike', 'span,b,strong,em,i,font,u,strike');
        
        // add span 'format'
        $settings['formats'] = "{span : {inline : 'span'}}";
        
        $selector = $settings['removeformat_selector'] == '' ? 'span,b,strong,em,i,font,u,strike' : $settings['removeformat_selector'];

        $selector 	= explode(',', $selector);
        $blocks 	= explode(',', $blocks);
        
        $rootblock 	= ($settings['forced_root_block'] === '') ? 'p' : $settings['forced_root_block'];

        if ($k = array_search($rootblock, $blocks) !== false) {
        	unset($blocks[$k]);
        }

        // remove format selector
        $settings['removeformat_selector'] = implode(',', array_unique(array_merge($blocks, $selector)));
        
        // new lines (paragraphs or linebreaks)
        $newlines = $wf->getParam('editor.newlines', 0);
        $settings['force_br_newlines'] 	= $newlines == 1 ? 1 : 0;
        $settings['force_p_newlines'] 	= $newlines == 0 ? 1 : 0;
        
        // Relative urls
        $settings['relative_urls'] = $wf->getParam('editor.relative_urls', 1, 1);
        if ($settings['relative_urls'] == 0) {
            $settings['remove_script_host'] = 0;
        }
        
        // Fonts
        $settings['theme_advanced_fonts'] = $model->getEditorFonts($wf->getParam('editor.theme_advanced_fonts_add', ''), $wf->getParam('editor.theme_advanced_fonts_remove', ''));
        $settings['theme_advanced_font_sizes'] = $wf->getParam('editor.theme_advanced_font_sizes', '8pt,10pt,12pt,14pt,18pt,24pt,36pt');
		$settings['theme_advanced_default_foreground_color'] = $wf->getParam('editor.theme_advanced_default_foreground_color', '#000000');
		$settings['theme_advanced_default_background_color'] = $wf->getParam('editor.theme_advanced_default_background_color', '#FFFF00');
        
		// colour picker custom colours
        $settings['custom_colors'] = $wf->getParam('editor.custom_colors', '', '');
    }
}
?>
