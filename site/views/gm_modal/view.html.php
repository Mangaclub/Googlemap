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

jimport( 'joomla.application.component.view');
 
class GmapViewgm_modal extends JViewLegacy
{
	function display($tpl = null)
	{	
		
		$db =& JFactory::getDBO();
		$id = JRequest::getVar('map');
		$query = "SELECT * FROM #__gm_map WHERE id= '$id' ORDER BY id ASC";
		$db->setQuery( $query );
		$row = $db->loadObject();
		$map_parameter = array();
		$teile = explode(",", $row->map_parameter);
			for ($i=0, $n=count( $teile ); $i < $n; $i++){
				$parameter = explode(":", $teile[$i]);
				$map_parameter[$parameter[0]] = $parameter[1];
			}

		$this->assignRef('map_parameter', $map_parameter);
		parent::display($tpl);
	}
	

}//class