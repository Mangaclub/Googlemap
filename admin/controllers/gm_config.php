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

class GmapControllergm_config extends JControllerForm
{
	public function __construct($config = array())
	{
		$this->view_list = 'gm_main'; // safeguard for setting the return view listing to the main view.
		parent::__construct($config);
	}

	protected function postSaveHook(JModelLegacy &$model, $validData = array())
	{

	}
	public function update_config()
	{
		$model = $this->getModel( 'gm_config' );
		$ergebnis=$model->update_config();
		$link = 'index.php?option=com_gmap';
		JError::raiseNotice(403, JText::_('COM_GMAP_MSG_CANCEL'));
        $this->setRedirect($link);

	}

   public function create_backup()
    {
        $model = $this->getModel('gm_config');
        $ergebnis=$model->create_backup();
    }// function
	

   public function restore_backup()
    {
        $model = $this->getModel('gm_config');
        $ergebnis=$model->getRestoreBackup();
    }// function

}
?>