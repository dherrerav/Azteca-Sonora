<?php
/**
 * SEF component for Joomla! 1.5
 *
 * @author      ARTIO s.r.o.
 * @copyright   ARTIO s.r.o., http://www.artio.cz
 * @package     JoomSEF
 * @version     3.1.0
 * @license     GNU/GPLv3 http://www.gnu.org/copyleft/gpl.html
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access.');

class SefExt
{
    
    var $params;
    var $metadesc;
    
    function SefExt()
    {
        // get extension params
        $className = get_class($this);
        if (substr($className, 0, 7) == 'SefExt_') $className = substr($className, 7);    
        $this->params = SEFTools::getExtParams($className);        
    }    

    function beforeCreate(&$uri)
    {
        return;
    }

    function afterCreate(&$uri)
    {
        return;
    }
    
    /**
     * Returns the nonSef vars and ignore vars
     *
     * @param JURI $uri
     * @return array
     */
    function getNonSefVars(&$uri)
    {
        return array(array(), array());
    }

    function getSefUrlFromDatabase(&$uri)
    {
        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();

        // David (284): ignore Itemid if set to
        $where = '';

        // Get the extension's ignoreSource parameter
        $option = $uri->getVar('option');
        if( !is_null($option) ) {
            $params = SEFTools::getExtParams($option);
            $extIgnore = $params->get('ignoreSource', 2);
        } else {
            $extIgnore = 2;
        }
        $ignoreSource = ($extIgnore == 2 ? $sefConfig->ignoreSource : $extIgnore);
        $Itemid = $uri->getVar('Itemid');
        
        // If Itemid is set as ignored for the component, set ignoreSource to 1
        if (!is_null($Itemid) && !is_null($option)) {
            if (SEFTools::isItemidIgnored($option, $Itemid)) {
                $ignoreSource = 1;
            }
        }
        
        if (!$ignoreSource && !is_null($Itemid)) {
            $where = " AND (`Itemid` = '".$Itemid."' OR `Itemid` IS NULL)";
        }

        $origurl = $db->Quote(html_entity_decode(urldecode(JoomSEF::_uriToUrl($uri, 'Itemid'))));
        $query = "SELECT * FROM `#__sefurls` WHERE `origurl` = {$origurl}" . $where . " AND (`trashed` = '0') LIMIT 2";
        $db->setQuery($query);
        $sefurls = $db->loadObjectList('Itemid');
        
        if (!$ignoreSource && !is_null($Itemid)) {
            if (isset($sefurls[$Itemid])) {
                $result = $sefurls[$Itemid];
            }
            else if (isset($sefurls[''])) {
                // We've found one of the ignored Itemids, update it with the current and return
                $result = $sefurls[''];
                $result->Itemid = $Itemid;
                $query = "UPDATE `#__sefurls` SET `Itemid` = '{$Itemid}' WHERE `id` = '{$result->id}' LIMIT 1";
                $db->setQuery($query);
                $db->query();
            }
            else {
                $result = reset($sefurls);
            }
        }
        else {
            $result = reset($sefurls);
        }
            
        return is_object($result) ? $result : false;
        
        /*
        // removed - was causing problems
        $sefurls = $db->loadObjectList('Itemid');
        // test if current Itemid record exists, if YES, use it, if NO, use first found
        if (isset($sefurls[$Itemid])) $active = $sefurls[$Itemid]; 
        elseif ($ignoreSource) $active = reset($sefurls);
        //if (isset($active)) $result = $active->sefurl;

        return isset($active) ? $active : false;
        */
    }

    function create(&$uri)
    {
        $vars = $uri->getQuery(true);
        extract($vars);
        
        $title = array();
        $title[] = JoomSEF::_getMenuTitle(@$option, null, @$Itemid);

        $newUri = $uri;
        if (count($title) > 0) {
            $newUri = JoomSEF::_sefGetLocation($uri, $title, null, null, null, @$lang);
        }
        
        return $newUri;
    }
    
    function revert($route, &$disabled)
    {
        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();
        $cache =& SEFCache::getInstance();
        $vars = array();

        $route = html_entity_decode(urldecode($route));
        $route = str_replace(' ', $sefConfig->replacement, $route);
        $routeNoSlash = rtrim($route, '/');
        
        // try to use cache
        if ($sefConfig->useCache) {
            $row = $cache->getNonSefUrl($route);
        }
        else $row = null;

        // cache worked
        if ($row) $fromCache = true;
        else {
            // URL isn't in cache or cache disabled
            $fromCache = false;
            
            if ($sefConfig->transitSlash) {
                $where = "(`sefurl` = ".$db->Quote($routeNoSlash).") OR (`sefurl` = ".$db->Quote($routeNoSlash.'/').")";
            } else {
                $where = "`sefurl` = ".$db->Quote($route);
            }
            $sql = "SELECT * FROM `#__sefurls` WHERE ($where) AND (`origurl` != '') AND (`trashed` = '0') ORDER BY `priority` LIMIT 1";
            $db->setQuery($sql);
            $row = $db->loadObject();
        }

        if ($row) {
            // Set the disabled flag (old cache records don't need to have enabled set)
            if (!isset($row->enabled)) {
                $row->enabled = 1;
            }
            if ($row->enabled) {
                $disabled = false;
            } else {
                $disabled = true;
            }
            
            // Use the already created URL
            $string = $row->origurl;
            if (isset($row->Itemid) && ($row->Itemid != '')) {
                $string .= (strpos($string, '?') ? '&' : '?') . 'Itemid=' . $row->Itemid;
            }

            // update the hits count if needed
            if (!$fromCache || $sefConfig->cacheRecordHits) {
                $where = '';
                if (!empty($row->id)) {
                    $where = " WHERE `id` = '{$row->id}'";
                } else {
                    $where = " WHERE `sefurl` = ".$db->Quote($row->sefurl)." AND `origurl` != '' AND `trashed` = '0'";
                }
            
                $db->setQuery("UPDATE `#__sefurls` SET `cpt` = (`cpt` + 1)".$where);
                $db->query();
            }
            
            $string = str_replace( '&amp;', '&', $string );
            $QUERY_STRING = str_replace('index.php?', '', $string);
            parse_str($QUERY_STRING, $vars);
            
            // Moved to JoomSEF::_parseSefUrl()
            /*
            if ($sefConfig->setQueryString) {
                $_SERVER['QUERY_STRING'] = $QUERY_STRING;
            }
            */

            // prepare the meta tags array for MetaBot
            // only if URL is not disabled
            if (!$disabled) {
                $mainframe =& JFactory::getApplication();
                if (!empty($row->metatitle))  JoomSEF::set('sef.meta.title',  $row->metatitle);
                if (!empty($row->metadesc))   JoomSEF::set('sef.meta.desc',   $row->metadesc);
                if (!empty($row->metakey))    JoomSEF::set('sef.meta.key',    $row->metakey);
                if (!empty($row->metalang))   JoomSEF::set('sef.meta.lang',   $row->metalang);
                if (!empty($row->metarobots)) JoomSEF::set('sef.meta.robots', $row->metarobots);
                if (!empty($row->metagoogle)) JoomSEF::set('sef.meta.google', $row->metagoogle);
                if (!empty($row->canonicallink)) JoomSEF::set('sef.link.canonical', $row->canonicallink);
                if (!empty($row->metacustom)) {
                    $metacustom = @unserialize($row->metacustom);
                    if (!empty($metacustom)) {
                        JoomSEF::set('sef.meta.custom', $metacustom);
                    }
                }
            }

            // If cache is enabled but URL isn't in cache yet, add it
            if ($sefConfig->useCache && !$fromCache) {
                $cache->addUrl($row->origurl, $row->sefurl, $row->cpt + 1, $row->Itemid, $row->metatitle, $row->metadesc, $row->metakey, $row->metalang, $row->metarobots, $row->metagoogle, $row->canonicallink, $row->metacustom, $row->enabled, $row->sef);
            }
        } elseif ($sefConfig->useMoved) {
            // URL not found, let's try the Moved Permanently table
            $where = '';
            if( $sefConfig->transitSlash ) {
                $where = '(`old` = '.$db->Quote($routeNoSlash).') OR (`old` = '.$db->Quote($routeNoSlash.'/').')';
            }
            else {
                $where = '`old` = '.$db->Quote($route);
            }
            $db->setQuery("SELECT * FROM `#__sefmoved` WHERE {$where}");
            $row = $db->loadObject();

            if($row) {
                // URL found, let's update the lastHit in table and redirect
                $db->setQuery("UPDATE `#__sefmoved` SET `lastHit` = NOW() WHERE `id` = '$row->id'");
                $db->query();

                $root = JURI::root();
                $f = $l = '';
                if (!headers_sent($f, $l)) {
                    // Let's build absolute URL from our link
                    if( strstr($row->new, $root) === false ) {
                        $url = $root;
                        if (substr($url, -1) != '/') $url .= '/';
                        if (substr($row->new, 0, 1) == '/') $row->new = substr($row->new, 1);
                        $url .= $row->new;
                    } else {
                        $url = $row->new;
                    }

                    // Use the link to redirect
                    header('HTTP/1.1 301 Moved Permanently');
                    header('Location: ' . $url);
                    header('Connection: close');
                    exit();
                } else {
                    JoomSEF::_headers_sent_error($f, $l, __FILE__, __LINE__);
                }
            }
        }

        return $vars;
    }

    function getMetaTags()
    {
        $metatags = array();
        if (!empty($this->metadesc)) {
            $cleanDesc = SEFTools::cleanDesc($this->metadesc);
        }
        if( $this->params->get('meta_desc', '1') && isset($cleanDesc)) {
            $maxLen = $this->params->get('desc_len', '250');
            $metatags['metadesc'] = SEFTools::clipDesc($cleanDesc, $maxLen);
        }
        if( $this->params->get('meta_keys', '1') && isset($cleanDesc) ) {
            $minLen = $this->params->get('keys_minlen', '3');
            $count = $this->params->get('keys_count', '15');
            $blacklist = $this->params->get('blacklist', null);
            $metatags['metakey'] = SEFTools::generateKeywords($cleanDesc, $blacklist, $count, $minLen);
        }
        
        return $metatags;
    }
}

/**
 * JoomSEF basic rewriting
 *
 */
class SefExt_Basic extends SefExt
{
    function _addValue(&$title, $value)
    {
        if (!is_array($value)) {
            $title[] = $value;
        }
        else {
            foreach ($value as $val) {
                $this->_addValue($title, $val);
            }
        }
    }
    
    function create(&$uri)
    {
        $vars = $uri->getQuery(true);
        
        $title = array();
        
        if ($this->params->get('showMenuTitle', '1') == '1') {
            $title[] = JoomSEF::_getMenuTitle($uri->getVar('option'), null, $uri->getVar('Itemid'));
        }
        else {
            $title[] = substr($uri->getVar('option'), 4);
        }
        
        $noAdd = array('option', 'lang', 'Itemid');
        foreach($vars as $name => $value) {
            if (in_array($name, $noAdd)) {
                continue;
            }
            
            $this->_addValue($title, $value);
        }

        $newUri = $uri;
        if (count($title) > 0) {
            $newUri = JoomSEF::_sefGetLocation($uri, $title, null, null, null, $uri->getVar('lang'));
        }
        
        return $newUri;
    }
}

?>