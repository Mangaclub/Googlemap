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
class GmapViewgm_config extends JViewLegacy
{

	public function display($tpl = null)
	{
		$form = $this->get('Form');
		$item = $this->get('Item');
		$backup_info = $this->get('BackupInfo');
				// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		};
		// Assign the variables
		$this->form = $form;
		$this->item = $item;
		$this->backup_info = $backup_info;
		$this->item->conf_api_key ='';
		if (!empty($this->item->conf_parameter)){
			$teile = explode(";", $this->item->conf_parameter);
			if (count( $teile ) > '0'){
				for ($a=0, $b=count( $teile ); $a < $b; $a++){
					$parameter = explode("|", $teile[$a]);
					$this->item->{$parameter[0]} = $parameter[1];
				}
			}
		}
		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	protected function addToolBar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId	= $user->id;
		$canDo = GmapHelper::getActions($this->item->id);
		// Built the actions for existing records.
			if ($canDo->get('core.edit')){
				// We can save the record
				JToolBarHelper::save('gm_config.update_config', 'JTOOLBAR_SAVE');
			};
		if($canDo->get('core.admin')){
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_gmap');
		};
			JToolBarHelper::cancel('gm_config.cancel', 'JTOOLBAR_CLOSE');
	}
	protected function setDocument() 
	{
		$apikey = '';
		if ( $this->item->conf_api_key >''){
			$apikey = 'key='.$this->item->conf_api_key;
		}

		JToolBarHelper::title(JText::_('COM_GMAP_VIEW_CONFIG_TITLE_CONFIG'), 'gm_config');
		$document = JFactory::getDocument();
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/jquery-ui.min.js' );
		$document->addStyleSheet('components/com_gmap/assets/css/tab.css');
		
		$document->setTitle(JText::_('COM_GMAP_VIEW_CONFIG_TITLE_CONFIG'));
		$document->addScript('https://maps.google.com/maps/api/js?&'.$apikey);
		JHtml::_('bootstrap.framework');
		JHtml::_('jquery.framework');
		JHtml::_('jquery.ui');


	}
}
?>