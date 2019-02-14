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
<div id="tab-2">
	<div class="row-fluid">
		<div class="span12 form-horizontal">
	<fieldset class="adminform">
    <legend><?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_TITLE_CONFIG' ); ?></legend>
    <table style="float: left;"  border="0">
  <tr>
    <td class="control-label"><?php echo $this->form->getLabel('conf_map_breite'); ?></td>
    <td class="controls"><?php echo $this->form->getInput('conf_map_breite'); ?></td>
    </tr>
  <tr>
    <td class="control-label"><?php echo $this->form->getLabel('conf_map_hoehe'); ?></td>
    <td class="controls"><?php echo $this->form->getInput('conf_map_hoehe'); ?></td>
    </tr>
  <tr>
    <td class="control-label"><?php echo $this->form->getLabel('conf_center_lat'); ?></td>
    <td class="controls"><?php echo $this->form->getInput('conf_center_lat'); ?></td>
    </tr>
  <tr>
    <td class="control-label"><?php echo $this->form->getLabel('conf_center_lng'); ?></td>
    <td class="controls"><?php echo $this->form->getInput('conf_center_lng'); ?></td>
    </tr>
  <tr>
    <td class="control-label"><?php echo $this->form->getLabel('conf_start_zoom'); ?></td>
    <td class="controls"><?php echo $this->form->getInput('conf_start_zoom'); ?></td>
    </tr>
  <tr>
    <td class="control-label"></td>
    <td class="controls"><input type="button" value="<?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_LABEL_MAP_LAT_LNG' ); ?>" onClick="kartenwerte()"></td>
  </tr>
  </table>
<div id="map" style="width:400px; height:400px;"></div>
	</fieldset>
		</div>
	</div>
</div>