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

/**
 * Gmap component helper.
 */
abstract class GmapHelper
{
	/**
	 *	Configure the Linkbar.
	 */
	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(JText::_('COM_GMAP_SUBMENU_UEBERSICHT'), 'index.php?option=com_gmap&view=gm_main', $submenu == 'gm_main');
		JHtmlSidebar::addEntry(JText::_('COM_GMAP_SUBMENU_MAP_NEW'), 'index.php?option=com_gmap&view=gm_maps', $submenu == 'gm_maps');
		JHtmlSidebar::addEntry(JText::_('COM_GMAP_SUBMENU_MAP_EDITOR'), 'index.php?option=com_gmap&view=gm_editors', $submenu == 'gm_editors');
		JHtmlSidebar::addEntry(JText::_('COM_GMAP_SUBMENU_KML_NEW'), 'index.php?option=com_gmap&view=gm_kmls', $submenu == 'gm_kmls');
		JHtmlSidebar::addEntry(JText::_('COM_GMAP_SUBMENU_LINE_STYLE'), 'index.php?option=com_gmap&view=gm_line_styles', $submenu == 'gm_line_styles');
		JHtmlSidebar::addEntry(JText::_('COM_GMAP_SUBMENU_LANG_NEW'), 'index.php?option=com_gmap&view=gm_langs', $submenu == 'gm_langs');
		JHtmlSidebar::addEntry(JText::_('COM_GMAP_SUBMENU_CONFIG'), 'index.php?option=com_gmap&view=gm_config&layout=edit&id=1', $submenu == 'gm_config');
		// set some global property
		$document = JFactory::getDocument();
		if ($submenu == 'categories'){
			$document->setTitle(JText::_('Categories - Gmap'));
		};
	}

	/**
	 *	Get the actions
	 */
	public static function getActions($Id = 0)
	{
		jimport('joomla.access.access');

		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($Id)){
			$assetName = 'com_gmap';
		} else {
			$assetName = 'com_gmap.message.'.(int) $Id;
		};

		$actions = JAccess::getActions('com_gmap', 'component');

		foreach ($actions as $action){
			$result->set($action->name, $user->authorise($action->name, $assetName));
		};

		return $result;
	}
}
?>