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

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * Gmap Controller Gmaps
 */
class GmapControllergm_map_style extends JControllerForm
{
	public function __construct($config = array())
	{
		$this->view_list = 'gm_map_styles'; // safeguard for setting the return view listing to the main view.
		parent::__construct($config);
	}

	protected function postSaveHook(JModelLegacy &$model, $validData = array())
	{
		// Get a handle to the Joomla! application object

	}

	public function update_map_style()
	{
		$model = $this->getModel( 'gm_map_style' );
		$ergebnis=$model->update_map_style();
		$link = 'index.php?option=com_gmap&view=gm_map_styles';
		JFactory::getApplication()->enqueueMessage(JText::_('COM_GMAP_MSG_RECORD_SAVE'));
		//JError::raiseNotice(403, JText::_('COM_GMAP_MSG_CANCEL'));
        $this->setRedirect($link);

	}

}
?>