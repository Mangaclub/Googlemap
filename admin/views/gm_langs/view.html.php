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

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * gmap View
 */
class GmapViewgm_langs extends JViewLegacy
{
	/**
	 * Gmap view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Include helper submenu
		GmapHelper::addSubmenu('gm_langs');

		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		};

		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;

		// Set the toolbar
		$this->addToolBar();
		// Show sidebar
		$this->sidebar = JHtmlSidebar::render();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$canDo = GmapHelper::getActions();
		JToolBarHelper::title(JText::_('COM_GMAP_SUBMENU_LANG_NEW'), 'gm_map_list');
		if($canDo->get('core.create')){
			JToolBarHelper::addNew('gm_lang.add', 'JTOOLBAR_NEW');
		};
		if($canDo->get('core.edit')){
			JToolBarHelper::editList('gm_lang.edit', 'JTOOLBAR_EDIT');
		};
		if($canDo->get('core.delete')){
			JToolBarHelper::deleteList('', 'gm_langs.delete', 'JTOOLBAR_DELETE');
		};
		if($canDo->get('core.admin')){
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_gmap');
		};
	}

	/**
	 * Method to set up the document properties
	 *
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_GMAP_EXTENSION_TITLE'));
	}
}
?>