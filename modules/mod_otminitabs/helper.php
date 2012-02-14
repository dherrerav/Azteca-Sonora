<?php
/**===========================================================================================
# mod_otminitabs        OT Mini Tabs module for Joomla 1.7
#=============================================================================================
# author                OmegaTheme.com
# copyright             Copyright (C) 2011 OmegaTheme.com. All rights reserved.
# @license              http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website               http://omegatheme.com
# Technical support     Forum - http://omegatheme.com/forum/
#=============================================================================================*/

/**------------------------------------------------------------------------
* file:           helper.php 1.7.0 00001, Mar 2011 12:00:00Z OmegaTheme:Linh $
* package:        OT Mini Tabs module
* description:    helper class file
*------------------------------------------------------------------------*/
defined('_JEXEC') or die ('Restricted access');

require_once JPATH_SITE.'/components/com_content/helpers/route.php';
jimport('joomla.application.component.model');
JModel::addIncludePath(JPATH_SITE.'/components/com_content/models');
jimport('joomla.utilities.string');

abstract class modOtMiniTabsHelper
{
    /**
    *    @return       array of tab element(modules, cates) which prepared for rendering
    *    @called by    root
    */
    public static function getTabsSelection(&$params)
    {
        $list_of_tabs = explode(',', str_replace(array(' ','"'), array('',''), trim($params->get('tab_selection','mod_1,cat_66'))));
        
        $tabArr = array();
        
        foreach($list_of_tabs as $key => $value)
        {
            $tabItemArr = explode('_', $value);
            if ($tabItemArr[0] == 'mod')
            {
                $tabArr[] = modOtMiniTabsHelper::getModules($tabItemArr[1]);
            }
            else if ($tabItemArr[0] == 'cat')
            {
                $tabArr[] = modOtMiniTabsHelper::getArticleList($tabItemArr[1], $params);
            }
            
        }
        return $tabArr;
    }
    
    /**
    *    @return       array of modules
    *    @called by    getTabsSelection($params)
    */
    
    public static function getModules(&$modId)
    {
        $db        = JFactory::getDbo();
        $query    = $db->getQuery(true);
        
        $query->select('*');
        $query->from('#__modules');
        $query->where('id='.$modId);
        
        $db->setQuery($query);
        if (!($modules = $db->loadObjectList())) {
            JError::raiseWarning(500, JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $db->getErrorMsg()));
            return false;
        }
        
        $custom    = substr($modules[0]->module, 0, 4) == 'mod_' ?  0 : 1;
        $modules[0]->user = $custom;
        array_unshift($modules, $modules[0]->title);
        array_unshift($modules, 'mod');
        return $modules;
    }
    
    /**
    *    @return       array of articles specified by category ID
    *    @called by    getTabsSelection($params)
    */
    public static function getArticleList(&$catId, &$params)
    {
        // array( 0 => 'cat', 1 => array() of articles )
        $number_of_article = $params->get('number_of_article', 4);
        $number_of_character = $params->get('number_of_character', 100);
        $show_link = $params->get('show_link', 1);
        $show_readmore = $params->get('show_readmore', 1);
        $show_date = $params->get('show_date', 0);
        $date_format = $params->get('date_format', 'd.m.Y');
        $show_thumbnail = $params->get('show_thumbnail', 1);
        $default_image = $params->get('default_image', 'modules/mod_otminitabs/images/sampledefault.jpg');
        $thumb_width = $params->get('thumb_width', 70);
        $thumb_height = $params->get('thumb_height', 50);
        $show_view_all = $params->get('show_view_all', 1);
        
        // Get the dbo
        $db = JFactory::getDbo();
        
        // Get an instance of the generic articles model
        $model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
        
        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);
        
        // Set the filters based on the module params
        $model->setState('list.start', 0);
        $model->setState('list.limit', (int) $number_of_article);
        $model->setState('filter.published', 1);
        
        // Access filter
        $access = !JComponentHelper::getParams('com_content')->get('show_noauth');
        $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
        $model->setState('filter.access', $access);
        
        // Category filter
        $model->setState('filter.category_id', $catId);
        
        // User filter
        $userId = JFactory::getUser()->get('id');
        switch ($params->get('user_id'))
        {
            case 'by_me':
                $model->setState('filter.author_id', (int) $userId);
                break;
            case 'not_me':
                $model->setState('filter.author_id', $userId);
                $model->setState('filter.author_id.include', false);
                break;
                
            case '0':
                break;
                
            default:
                $model->setState('filter.author_id', (int) $params->get('user_id'));
                break;
        }
        
        // Filter by language
        $model->setState('filter.language',$app->getLanguageFilter());
        
        //  Featured switch
        switch ($params->get('show_featured'))
        {
            case '1':
                $model->setState('filter.featured', 'only');
                break;
            case '0':
                $model->setState('filter.featured', 'hide');
                break;
            default:
                $model->setState('filter.featured', 'show');
                break;
        }
        
        // Set ordering
        $order_map = array(
            'm_dsc' => 'a.modified DESC, a.created',
            'mc_dsc' => 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END',
            'c_dsc' => 'a.created',
            'p_dsc' => 'a.publish_up',
            'h_dsc' => 'a.hits'
        );
        
        $ordering = JArrayHelper::getValue($order_map, $params->get('ordering'), 'a.publish_up');
        $dir = 'DESC';
        
        $model->setState('list.ordering', $ordering);
        $model->setState('list.direction', $dir);
        
        $items = $model->getItems();
        if (!is_array($items) || empty($items)) return false;
        
        $cateHtml = array();
        $itemsHtml = '<div class="ot-items-wrapper">';
        
        foreach ($items as &$item) {
            $item->slug = $item->id.':'.$item->alias;
            $item->catslug = $item->catid.':'.$item->category_alias;
            
            
            if ($access || in_array($item->access, $authorised))
            {
                $item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
            }
            else {
                $item->link = JRoute::_('index.php?option=com_user&view=login');
            }
            $itemsHtml .= '<div class="ot-item-wrapper">';
            if ($show_thumbnail == 1)
            {
                preg_match_all('/src="([^"]+)"/i', $item->introtext , $matches);
                $itemsHtml .= '<div class="ot-thumb-wrapper">';
                if(empty($matches[1][0])){
                    $itemsHtml .= JHTML::_('image', $default_image, $item->title, array('class' => 'ot-thumbnail', 'width' => $thumb_width, 'height' => $thumb_height));
                }else{
                    $itemsHtml .= JHTML::_('image', $matches[1][0], $item->title, array('class' => 'ot-thumbnail', 'width' => $thumb_width, 'height' => $thumb_height));
                }
                $itemsHtml .='</div>';
            }
            if($show_link == 1)
            {
                $itemsHtml .= '<h3 class="ot-title">'.
                                '<a href="'.$item->link.'" class="ot-title-link">'.$item->title.'</a>'.
                              '</h3>';
            }
            else
            {
                $itemsHtml .= '<h3 class="ot-title">'.
                                $item->title.
                              '</h3>';
            }
            
            if($show_date == 1)
            {
                $itemsHtml .=   '<span class="created_date">'.
                                JHTML::_('date', $item->created, $params->get( 'date_format' )).
                                '</span>';
            }
            
            $itemsHtml .=   '<div class="ot-article-introtext">'.
                            JString::substr(strip_tags(preg_replace('/<img([^>]+)>/i',"",JHtml::_('content.prepare', $item->introtext ))), 0, $number_of_character).'...'.
                            '</div>';
            
            if($show_readmore == 1)
            {
                $itemsHtml .= '<a href="'.$item->link.'" class="ot-readmore-link">'.JText::_('READMORE').'</a>';
            }
            
            $itemsHtml .= '</div>';
            $cate_title = $item->category_title;
        }
        
        if($show_view_all == 1)
        {
            $itemsHtml .= '<a class="view-all" href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($catId)).'" title="view all">'.JText::_('VIEW_ALL').'</a>';
        }
        $itemsHtml .= '</div>';
        
        $cateHtml[] = 'cat';
        $cateHtml[] = $cate_title;
        $cateHtml[] = $itemsHtml;
        
        return $cateHtml;
    }
}
