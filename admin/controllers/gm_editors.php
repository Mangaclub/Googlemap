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
class GmapControllergm_editors extends JControllerForm
{
	public function __construct($config = array())
	{
		$this->view_list = 'gm_editors'; // safeguard for setting the return view listing to the main view.
		parent::__construct($config);
	}

	protected function postSaveHook(JModelLegacy &$model, $validData = array())
	{
		// Get a handle to the Joomla! application object
		$application = JFactory::getApplication();

		$date = date('Y-m-d H:i:s');
		if($validData['date_created'] == '0000-00-00 00:00:00'){
			$data['date_created'] = $date;
		}
		$data['date_modified'] = $date;

		$user = JFactory::getUser();
		if($validData['user_created'] == 0){
			$data['user_created'] = $user->id;
		}
		$data['user_modified'] = $user->id;

		$model->save($data);

	}
		public function cancel()
		{
		JError::raiseNotice(403, JText::_('COM_GMAP_MSG_CANCEL'));
		$this->setRedirect( 'index.php?option=com_gmap&view=gm_editors' );
		}


}
?>