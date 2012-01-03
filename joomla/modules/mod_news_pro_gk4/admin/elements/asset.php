<?php

/**
* Asset Element
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldAsset extends JFormField {
        protected $type = 'Asset';

        protected function getInput() {
                $doc = JFactory::getDocument();
                $doc->addScript(JURI::root().$this->element['path'].'script.js');
                $doc->addStyleSheet(JURI::root().$this->element['path'].'style.css');        
                return null;
        }
}

/* eof */