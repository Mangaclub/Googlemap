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
?>
  <table border="0" class="admintable">
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('map_bike_layer'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_bike_layer'); ?></td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('map_traffic_layer'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_traffic_layer'); ?></td>
    </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('map_transit_layer'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_transit_layer'); ?></td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('map_overview_map'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_overview_map'); ?></td>
    </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('map_overview_map_open'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_overview_map_open'); ?></td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('map_language'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_language'); ?><?php echo $this->form->getInput('custom_map_language'); ?>
      
      </td>
      </tr>

    </table>
