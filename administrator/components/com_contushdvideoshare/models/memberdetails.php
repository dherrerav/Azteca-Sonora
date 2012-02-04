<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class contushdvideoshareModelmemberdetails extends JModel {

	function getmemberdetails()
    {
        global $option, $mainframe;
         $mainframe = JFactory::getApplication();
		$db = $this->getDBO();
		$db->setQuery('SELECT a.*,b.allowupload from #__users a left join #__hdflv_user b on a.id = b.member_id where a.usertype <> "Super Administrator"');
	
      $option = 'com_contushdvideoshare';
		$memberdetails = $db->loadObjectList();
		
		if ($memberdetails === null)
		JError::raiseError(500, 'Error reading db');

        $filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'Id', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'desc', 'word' );
        $search=$mainframe->getUserStateFromRequest( $option.'search','search','','string' );
        $limit = $mainframe->getUserStateFromRequest($option.'.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
        $query = "SELECT count(*) FROM #__users where usertype <> 'Super Administrator'";
            $db->setQuery( $query );
            $total = $db->loadResult();

            jimport('joomla.html.pagination');
            $pageNav = new JPagination($total, $limitstart, $limit);
       
          if($filter_order!='ordering')
            {
              $query = "SELECT a.*,b.allowupload from #__users a left join #__hdflv_user b on a.id = b.member_id where usertype <> 'Super Administrator' order by $filter_order LIMIT $limitstart,$limit";
			 
              $db->setQuery( $query );
              $memberdetails = $db->loadObjectList();
            }

                $lists['order_Dir']= $filter_order_Dir;
                $lists['order']= $filter_order;

            
               $query = "SELECT allowupload from #__hdflv_site_settings";
              $db->setQuery( $query );
              $settingupload = $db->loadObjectList();

             $memberdetails = array('pageNav' => $pageNav,'limitstart'=>$limitstart,'lists'=>$lists,'memberdetails'=>$memberdetails,'settingupload'=>$settingupload);

        return $memberdetails;
	}



    function pubcategary($arrayIDs)
	{
        
        //echo $arrayIDs['task'];
		if($arrayIDs['task']=="publish")
        {
            $publish=0;
        }
        else
        {
            $publish=1;
        }
        $n= count($arrayIDs['cid']);
        for($i=0;$i<$n;$i++)
        {
        $query = "UPDATE #__users set block=".$publish." WHERE usertype <> 'Super Administrator' and id=".$arrayIDs['cid'][$i];
		$db = $this->getDBO();
		$db->setQuery($query);
        $db->query();
        }

	}
    function pubupload($arrayIDs)
	{

        //echo $arrayIDs['task'];
		if($arrayIDs['task']=="allowupload")
        {
            $publish=1;
        }
        else
        {
            $publish=0;
        }
        $n= count($arrayIDs['cid']);
        for($i=0;$i<$n;$i++)
        {
        $query = "SELECT count(*) FROM #__hdflv_user where member_id=".$arrayIDs['cid'][$i];
       
       $db = $this->getDBO();
        $db->setQuery( $query );
        $total = $db->loadResult();

        if($total!=0)
        {
        $query = "UPDATE #__hdflv_user set allowupload=".$publish." WHERE member_id=".$arrayIDs['cid'][$i];
		$db = $this->getDBO();
		$db->setQuery($query);
        $db->query();
        }
        else
        {
            $idval=$arrayIDs['cid'][$i];

		$query = " insert into #__hdflv_user (member_id,allowupload) values ('$idval','$publish')";
        $db = $this->getDBO();
            $db->setQuery( $query );
            $db->query();
        }


        }

	}

   
}
?>
