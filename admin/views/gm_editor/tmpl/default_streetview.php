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
      <td class="control-label"><?php echo $this->form->getLabel('streetViewControl'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('streetViewControl'); ?></td>
      <td >&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('street_view_activ'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('street_view_activ'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('street_view_center_lat'); ?></td>
      <td class="controls">	<?php echo $this->form->getInput('street_view_center_lat'); ?>
      						<?php echo $this->form->getInput('street_view_center_lng'); ?>
      </td>
      <td class="line_waagerecht_oben">&nbsp;</td>
      <td rowspan="4" nowrap="nowrap" class="line_senkrecht">-<a href="javascript:void(0)" onclick="map_streetview.getfrommap()" ><img src="components/com_gmap/assets/images/assume.png" alt="" width="11" height="11" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MAP_BUTTON_SET_STREETVIEW' ); ?>" class="assume" /></a> 
<a href="javascript:void(0)" onClick="map_streetview.delete_view()" ><img class="assume" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MAP_BUTTON_DELETE_STREETVIEW' ); ?>" src="components/com_gmap/assets/images/reset.png" width="16" height="16" /></a> 
<a href="javascript:void(0)" onclick="map_streetview.refresh_view()" ><img title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MAP_BUTTON_RESET_STREETVIEW' ); ?>" src="components/com_gmap/assets/images/refresh.png" alt="" width="16" height="16" class="assume" /></a>
     
     </td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('street_view_pitch'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('street_view_pitch'); ?></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('street_view_heading'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('street_view_heading'); ?></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('street_view_zoom'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('street_view_zoom'); ?></td>
      <td class="line_waagerecht_unten">&nbsp;</td>
    </tr>
  </table>
