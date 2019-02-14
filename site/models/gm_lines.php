<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/

//-- No direct access
defined('_JEXEC') or die('Restricted access');


class GmapModelgm_lines extends JModelItem
{
	
	
	function getData()
	{	
	$user = JFactory::getUser();
    $groups = $user->getAuthorisedGroups();
	$groups = implode(",",$groups);
		$db = JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$query = "SELECT * FROM #__gm_line WHERE id_map= '$id' AND (access_group IN ($groups) OR access_group='') ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		
		}	
	 
	function getDataline()
	{	$db = JFactory::getDBO();
		$id = JRequest::getVar('id');
		
		$query = ' SELECT * '
				. ' FROM #__gm_line '
				. 'WHERE id='.$id;
		$db->setQuery( $query );
		$item = $db->loadObject();
		
		return $item;
		
		}	

}//class