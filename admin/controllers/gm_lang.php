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
class GmapControllergm_lang extends JControllerForm
{
	public function __construct($config = array())
	{
		$this->view_list = 'gm_langs'; // safeguard for setting the return view listing to the main view.
		parent::__construct($config);
	}
	public function update_lang_record()
	{
		$model = $this->getModel( 'gm_lang' );
		$ergebnis=$model->update_lang_record();
		$link = 'index.php?option=com_gmap&view=gm_langs';
		JFactory::getApplication()->enqueueMessage(JText::_('COM_GMAP_MSG_RECORD_SAVE'));
        $this->setRedirect($link);

	}


}
?>