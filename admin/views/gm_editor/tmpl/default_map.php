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
<div id="tab-1">
<div class="subhead">
<div id="toolbar" class="btn-toolbar">
<div id="toolbar-save" class="btn-wrapper"></div>
<div id="toolbar-help" class="btn-wrapper">
	<a class="modal-button btn btn-small" href=<?php echo $this->config->help_map_setup?>>
    <span class="icon-question-sign"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_BUTTON_HELP' ); ?>
    </a>
</div>
</div>
</div>

	<ul id="map-tab" class="nav nav-tabs" role="tablist" style="margin-bottom: 5px;">
		<li class="active">
  			<a href="#map-page-1" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_MAP_GENERAL' ); ?></a>
		</li>
		<li>
  			<a href="#map-page-2" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_MAP_ADDITIONAL' ); ?></a>
		</li>
		<li>
  			<a href="#map-page-3" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_MAP_SETUPBUTTON' ); ?></a>
		</li>
		<li>
  			<a href="#map-page-4" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_MAP_STREET_VIEW' ); ?></a>
		</li>
    </ul>
<div class="tab-content">
	<div class="tab-pane active" id="map-page-1">
  <table border="0" >
    <tr class="gm_row1">
      <td width="180" class="control-label"><?php echo $this->form->getLabel('map_center_lat'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_center_lat'); ?><?php echo $this->form->getInput('map_center_lng'); ?>  
      <a href="javascript:void(0)" onClick="getmapcenter()" ><img class="assume" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MAP_BUTTON_SET_LAT_LNG' ); ?>"src="components/com_gmap/assets/images/assume.png" width="11" height="11" /></a>
<a href="javascript:void(0)" onClick="setmapcenter()" ></a>

      </td>
      <td width="12" class="line_waagerecht_oben">&nbsp;</td>
      <td rowspan="2" nowrap="nowrap" class="line_senkrecht">-<a href="javascript:void(0)" onclick="setmapcenter()" ><img src="components/com_gmap/assets/images/refresh.png" alt="" width="16" height="16" class="assume" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MAP_BUTTON_RESET_VIEW_MAP' ); ?>"/></a></td>
      </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('map_zoom'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_zoom'); ?>
<a href="javascript:void(0)" onClick="setzoom.map_zoom()" ><img class="assume" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MAP_BUTTON_ZOOM_START' ); ?>" src="components/com_gmap/assets/images/assume.png" width="11" height="11" /></a>
<?php echo $this->form->getInput('map_minzoom'); ?>
<a href="javascript:void(0)" onClick="setzoom.map_minzoom()" ><img class="assume" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MAP_BUTTON_ZOOM_MIN' ); ?>" src="components/com_gmap/assets/images/assume.png" width="11" height="11" /></a>
<?php echo $this->form->getInput('map_maxzoom'); ?>
<a href="javascript:void(0)" onClick="setzoom.map_maxzoom()" ><img class="assume" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MAP_BUTTON_ZOOM_MAX' ); ?>" src="components/com_gmap/assets/images/assume.png" width="11" height="11" /></a>
<a href="javascript:void(0)" onClick="setzoom.reset_zoom()" ><img class="assume" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MAP_BUTTON_ZOOM_RESET' ); ?>" src="components/com_gmap/assets/images/reset.png" width="16" height="16" /></a>
</td>
      <td class="line_waagerecht_unten">&nbsp;</td>
      </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('map_maptype'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_maptype'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </table>
    <div id="satellite_view_45">
    <table border="0" >
    <tr class="gm_row1">
      <td width="180"class="control-label"><?php echo $this->form->getLabel('map_satellite_view_45'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_satellite_view_45'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('map_satellite_view_45_heading'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_satellite_view_45_heading'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </table>
    </div>
    <table border="0" >
    <tr class="gm_row1">
      <td width="180" class="control-label"><?php echo $this->form->getLabel('map_draggable'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_draggable'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('map_DoubleClickZoom'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_DoubleClickZoom'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('map_scrollwheel'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_scrollwheel'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('map_panControl'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_panControl'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('map_zoomControl'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_zoomControl'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('map_ZoomControlStyle'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_ZoomControlStyle'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('map_scaleControl'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('map_scaleControl'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </table>
          </div>
    <div class="tab-pane" id="map-page-2">
        <?php echo $this->loadTemplate('moreview');?>
    </div>
    <div class="tab-pane" id="map-page-3">
        <?php echo $this->loadTemplate('setupbutton');?>
    </div>
    <div class="tab-pane" id="map-page-4">
        <?php echo $this->loadTemplate('streetview');?>
    </div>
</div>
</div>