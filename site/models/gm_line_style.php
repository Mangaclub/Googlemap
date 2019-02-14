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


class GmapModelgm_line_style extends JModelItem
{
	
	
	function getData()
	{	$db = JFactory::getDBO();
		$query = "SELECT * FROM #__gm_line_style ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		
		}	
	 

}//class