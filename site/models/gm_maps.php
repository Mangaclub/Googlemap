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


class GmapModelgm_maps extends JModelItem
{
	
	
	function getData()
	{	$db = JFactory::getDBO();
		$id = JRequest::getVar('cid');
		
		$query = "SELECT * FROM #__gm_map WHERE id= '$id' ";
		$db->setQuery( $query );
		$items = $db->loadObject();
		return $items;
		
		}	
	 

}//class