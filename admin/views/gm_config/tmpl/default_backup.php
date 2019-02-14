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
?>
<div id="tab-3">
<table  border="0">
  <tr>
    <td colspan="2"><div id="msg_backup_1"></div>
    </td>
  </tr>
  <tr>
    <td colspan="2"><div id="msg_backup_2"></div>
    </td>
  </tr>
  <tr>
    <td>
<?php
	if ($this->backup_info['backup_import'] == '1'){
		echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_BUTTON_DATA_IMPORT_INFO' );
	};
?>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="" type="button" onClick="create_backup();" value="<?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_BUTTON_NEW' ); ?>">
    
    <input name="" type="button" onClick="restore_backup();" value="<?php 
	if ($this->backup_info['backup_import'] == '1'){
		echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_BUTTON_DATA_IMPORT' );
	}else {
		echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_BUTTON_RESTORE' ); 
	};
		?>"></td>
    <td></td>
  </tr>
</table>
  
</div>