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
 * Gmaps View
 */
class GmapViewgm_main extends JViewLegacy
{
	/**
	 * display method of Gmaps view
	 * @return void
	 */
	public function display($tpl = null)
	{
		GmapHelper::addSubmenu('gm_main');

		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		};
		// Show sidebar
		$this->sidebar = JHtmlSidebar::render();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}


	protected function setDocument() 
	{
		JToolBarHelper::title(JText::_('COM_GMAP_EXTENSION_TITLE'), 'gm_main');
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_GMAP_EXTENSION_TITLE'));
	}
}
?>