<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * Gmap Table Gmaps class
 */
class GmapTablegm_config extends JTable
{

	function __construct(&$db) 
	{
		parent::__construct('#__gm_config', 'id', $db);
	}

	 	public function bind($array, $ignore = '')
	{
		return parent::bind($array, $ignore);
	}

}
?>