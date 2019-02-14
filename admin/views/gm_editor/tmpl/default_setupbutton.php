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
  <table id="setup_button" border="0" class="admintable">
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('map_setup_button'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_setup_button'); ?></td>
    </tr>
       <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('map_typ_control_button'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_typ_control_button'); ?></td>
    </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('map_layer_button'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_layer_button'); ?></td>
     </td>
    </tr>

    </table>
