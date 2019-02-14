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



class GmapVieweditor extends JViewLegacy
{
    
	public function display($tpl = null)
	{
		$eName		= JRequest::getVar('e_name');
		$eName		= preg_replace( '#[^A-Z0-9\-\_\[\]]#i', '', $eName );
		$this->assignRef('eName', $eName);

    	$db = JFactory::getDBO();
		$query = 'SELECT id AS value, map_titel AS text'
		. ' FROM #__gm_map';
		$db->setQuery( $query );
		$types[] = JHTML::_('select.option',  0, '- '. JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_MAP_LIST_FIRST_OPTION' ) .' -' );
		$types 			= array_merge( $types, $db->loadObjectList() );
		$lists	= JHTML::_('select.genericlist',   $types, 'as_map', 'class="inputbox" size="7"', 'value', 'text' );
    $lists2	= JHTML::_('select.genericlist',   $types, 'as_link_map', 'class="inputbox" size="7"', 'value', 'text' );
		$this->assignRef('map', $lists);
    $this->assignRef('link_map', $lists2);
		parent::display($tpl);
    }// function
}// class
