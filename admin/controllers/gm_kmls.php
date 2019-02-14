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

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Gmap Controller
 */
class GmapControllergm_kmls extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'gm_kml', $prefix = 'GmapModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		
		return $model;
	}
	public function kmldelete()
		{
		$application = JFactory::getApplication();
		$model = $this->getModel('gm_kml');
		if(!$model->kmldelete()) {
			$application->enqueueMessage('COM_GMAP_MSG_ERROR_RECORD_DELETE', 'error');
		} else {
			$cids = JRequest::getVar( 'cid', array(0), 'jform', 'array' );
			foreach($cids as $cid) {
				$msg .= JText::_( 'COM_GMAP_MSG_RECORD_DELETE' ). ' : '.$cid.' | ';
			}
			$application->enqueueMessage($msg, 'notice');
		}

		$this->setRedirect( 'index.php?option=com_gmap&view=gm_kmls' );
	}
}
?>