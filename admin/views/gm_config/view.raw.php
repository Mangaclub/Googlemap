<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/

//-- No direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');
 
class GmapViewgm_config extends JViewLegacy
{
function display($tpl = null)
	{
	$layout = JRequest::getVar('layout');
	if ($layout == 'form_backup'){
		$backup_info = $this->get('BackupInfo');
		$this->assignRef('backup_info', $backup_info);
		$this->setLayout($layout);
	}
	if ($layout == 'form_restore_backup'){
		$action = JRequest::getVar('backup_import');
		if ($action == '0'){
			$restore_backup_info = $this->get('RestoreBackup');
			$this->assignRef('restore_backup_info', $restore_backup_info);
			$this->setLayout($layout);
		}
		if ($action == '1'){
			$restore_backup_info = $this->get('ImportBackup');
			$this->assignRef('restore_backup_info', $restore_backup_info);
			$this->setLayout($layout);
		}
	}
      parent::display($tpl);
 	}
	

}//class