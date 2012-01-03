<?php
/**
 * @version		1.6.0.52 helpers/xmlrpcj2xml.php
 * @package		J2XMLImporter
 * @subpackage	com_j2xmlimporter
 * @since		1.5.3
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2011 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'j2xmlimporter.php');

/**
 * Joomla! J2XML XML-RPC Plugin
 *
 * @package J2XML
 * @since 1.5
 */
class plgXMLRPCJ2XMLServices
{
	/**
	 * Import articles from xml file
	 *
	 * @param base64 $xml
	 * @param string $username Username
	 * @param string $password Password
	 * @return string
	 * @since 1.5
	 */
	function import($xml, $username='', $password='')
	{
		global $xmlrpcerruser, $xmlrpcI4, $xmlrpcInt, $xmlrpcBoolean, $xmlrpcDouble, $xmlrpcString, $xmlrpcDateTime, $xmlrpcBase64, $xmlrpcArray, $xmlrpcStruct, $xmlrpcValue;
		$app =& JFactory::getApplication();
		$options = array();
		$result = $app->login(array('username'=>$username, 'password'=>$password), $options);

		if (JError::isError($result)) {
			return new xmlrpcresp(0, $xmlrpcerruser+1, 'COM_J2XML_MSG_SETCREDENTIALSFROMREQUEST_FAILED');
		}
		
		$canDo	= J2XMLImporterHelper::getActions();
		if (!$canDo->get('core.create') &&
				!$canDo->get('core.edit') &&
				!$canDo->get('core.edit.own')) {
			return new xmlrpcresp(0, $xmlrpcerruser+2, 'COM_J2XML_MSG_ALERTNOTAUTH');
		}
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'importer.php');
		
		$xml = base64_decode($xml);

		$data = gzdecode($xml);
		if (!$data)
			$data = $xml;
			
		$xml = simplexml_load_string($data);

		if (!$xml)
		{
			$errors = libxml_get_errors();
			foreach ($errors as $error) {
				$msg = $error->code.' - '.JText::_($error->message);
			    switch ($error->level) {
		    	default:
		        case LIBXML_ERR_WARNING:
					return new xmlrpcresp(0, $xmlrpcerruser+3, JText::_($msg));
		            break;
		         case LIBXML_ERR_ERROR:
					return new xmlrpcresp(0, $xmlrpcerruser+4, JText::_($msg));
		         	break;
		        case LIBXML_ERR_FATAL:
					return new xmlrpcresp(0, $xmlrpcerruser+5, JText::_($msg));
		        	break;
			    }
			}
			libxml_clear_errors();
		}
		
		if(!isset($xml['version']))
			return new xmlrpcresp(0, $xmlrpcerruser+6, JText::_('COM_J2XML_MSG_FILE_FORMAT_UNKNOWN'));
   		else 
		{
			require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'importer.php');
			
			$xmlVersion = $xml['version'];
			$version = explode(".", $xmlVersion);
			$xmlVersionNumber = $version[0].$version[1].substr('0'.$version[2], strlen($version[2])-1); 
			
			if (($xmlVersionNumber == 1505) || ($xmlVersionNumber == 1506))
			return new xmlrpcresp(j2xmlImporter::import($xml,$xmlVersionNumber,true));
			else
				return new xmlrpcresp(0, $xmlrpcerruser+7, JText::sprintf('COM_J2XML_MSG_FILE_FORMAT_NOT_SUPPORTED', $xmlVersion));
		}	
	}
}

function gzdecode($data,&$filename='',&$error='',$maxlength=null)
{
    $len = strlen($data);
    if ($len < 18 || strcmp(substr($data,0,2),"\x1f\x8b")) {
        $error = "Not in GZIP format.";
        return null;  // Not GZIP format (See RFC 1952)
    }
    $method = ord(substr($data,2,1));  // Compression method
    $flags  = ord(substr($data,3,1));  // Flags
    if ($flags & 31 != $flags) {
        $error = "Reserved bits not allowed.";
        return null;
    }
    // NOTE: $mtime may be negative (PHP integer limitations)
    $mtime = unpack("V", substr($data,4,4));
    $mtime = $mtime[1];
    $xfl   = substr($data,8,1);
    $os    = substr($data,8,1);
    $headerlen = 10;
    $extralen  = 0;
    $extra     = "";
    if ($flags & 4) {
        // 2-byte length prefixed EXTRA data in header
        if ($len - $headerlen - 2 < 8) {
            return false;  // invalid
        }
        $extralen = unpack("v",substr($data,8,2));
        $extralen = $extralen[1];
        if ($len - $headerlen - 2 - $extralen < 8) {
            return false;  // invalid
        }
        $extra = substr($data,10,$extralen);
        $headerlen += 2 + $extralen;
    }
    $filenamelen = 0;
    $filename = "";
    if ($flags & 8) {
        // C-style string
        if ($len - $headerlen - 1 < 8) {
            return false; // invalid
        }
        $filenamelen = strpos(substr($data,$headerlen),chr(0));
        if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
            return false; // invalid
        }
        $filename = substr($data,$headerlen,$filenamelen);
        $headerlen += $filenamelen + 1;
    }
    $commentlen = 0;
    $comment = "";
    if ($flags & 16) {
        // C-style string COMMENT data in header
        if ($len - $headerlen - 1 < 8) {
            return false;    // invalid
        }
        $commentlen = strpos(substr($data,$headerlen),chr(0));
        if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
            return false;    // Invalid header format
        }
        $comment = substr($data,$headerlen,$commentlen);
        $headerlen += $commentlen + 1;
    }
    $headercrc = "";
    if ($flags & 2) {
        // 2-bytes (lowest order) of CRC32 on header present
        if ($len - $headerlen - 2 < 8) {
            return false;    // invalid
        }
        $calccrc = crc32(substr($data,0,$headerlen)) & 0xffff;
        $headercrc = unpack("v", substr($data,$headerlen,2));
        $headercrc = $headercrc[1];
        if ($headercrc != $calccrc) {
            $error = "Header checksum failed.";
            return false;    // Bad header CRC
        }
        $headerlen += 2;
    }
    // GZIP FOOTER
    $datacrc = unpack("V",substr($data,-8,4));
    $datacrc = sprintf('%u',$datacrc[1] & 0xFFFFFFFF);
    $isize = unpack("V",substr($data,-4));
    $isize = $isize[1];
    // decompression:
    $bodylen = $len-$headerlen-8;
    if ($bodylen < 1) {
        // IMPLEMENTATION BUG!
        return null;
    }
    $body = substr($data,$headerlen,$bodylen);
    $data = "";
    if ($bodylen > 0) {
        switch ($method) {
        case 8:
            // Currently the only supported compression method:
            $data = gzinflate($body,$maxlength);
            break;
        default:
            $error = "Unknown compression method.";
            return false;
        }
    }  // zero-byte body content is allowed
    // Verifiy CRC32
    $crc   = sprintf("%u",crc32($data));
    $crcOK = $crc == $datacrc;
    $lenOK = $isize == strlen($data);
    if (!$lenOK || !$crcOK) {
        $error = ( $lenOK ? '' : 'Length check FAILED. ') . ( $crcOK ? '' : 'Checksum FAILED.');
        return false;
    }
    return $data;
}