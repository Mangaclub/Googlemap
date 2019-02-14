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
class GmapViewgm_line_style extends JViewLegacy
{
	/**
	 * display method of Gmaps view
	 * @return void
	 */
	public function display($tpl = null)
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
		$config	= $this->get('Config');
			if ($item->fillOpacity == ''){
				$item->fillOpacity = '0';
			}
			if ($item->strokeWeight == ''){
				$item->strokeWeight = '0';
			}
			if ($item->strokeOpacity == ''){
				$item->strokeOpacity = '0';
			}
			if ($item->rotation == ''){
				$item->rotation = '0';
			}
			if ($item->scale == ''){
				$item->scale = '0';
			}

		$script = $this->get('Script');

		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		};

		// Assign the variables
		$this->form = $form;
		$this->item = $item;
		$this->script = $script;
		$this->config = $config;

		// Set the toolbar
		$this->addToolBar();

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
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId	= $user->id;
		$isNew = $this->item->id == 0;
		$canDo = GmapHelper::getActions($this->item->id);
		JToolBarHelper::title($isNew ? JText::_('COM_GMAP_VIEW_GM_LINE_STYLE_TITLE') : JText::_('COM_GMAP_VIEW_GM_LINE_STYLE_TITLE'), 'gm_line_style_new');
		// Built the actions for new and existing records.
		if ($isNew){
			// For new records, check the create permission.
			if ($canDo->get('core.create')){
				JToolBarHelper::apply('gm_line_style.apply_line_style', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('gm_line_style.update_line_style', 'JTOOLBAR_SAVE');
			};
			JToolBarHelper::cancel('gm_line_style.cancel', 'JTOOLBAR_CANCEL');
		} else {
			if ($canDo->get('core.edit')){
				// We can save the new record
				JToolBarHelper::apply('gm_line_style.apply_line_style', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('gm_line_style.update_line_style', 'JTOOLBAR_SAVE');
			};
			JToolBarHelper::cancel('gm_line_style.cancel', 'JTOOLBAR_CLOSE');
		};
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_GMAP_VIEW_GM_LINE_STYLE_TITLE') : JText::_('COM_GMAP_VIEW_GM_LINE_STYLE_EDIT_TITLE'));
		$document->addScript(JURI::root() . $this->script);
		JText::script('gmaps not acceptable. Error');
			$lang = JFactory::getLanguage();
			$teile = explode("-", $lang->getTag());
		$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.9&sensor=false&language='.$teile[0]);
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/jquery-ui.min.js' );
		$document->addScript(JURI::root() . "administrator/components/com_gmap/assets/js/svg.js");
		$document->addScript(JURI::root() . "administrator/components/com_gmap/views/gm_line_style/js/line_style.js");
		$document->addStyleSheet('components/com_gmap/assets/css/line_style.css');
		$document->addStyleSheet('components/com_gmap/assets/css/jquery-ui.structure.min.css');
		$document->addStyleSheet('components/com_gmap/assets/css/jquery-ui.theme.min.css');
		$document->addStyleSheet('components/com_gmap/assets/css/jquery-ui.css');

	}
}
?>