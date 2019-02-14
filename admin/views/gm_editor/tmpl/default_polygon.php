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
<div id="tab-6">
<div class="subhead">
<div id="toolbar" class="btn-toolbar">
<div id="toolbar-save" class="btn-wrapper">
	<a class="btn btn-small" onclick="polygonnew()" href="#">
	<span class="icon-plus-2"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_NEW' ); ?>
    </a>
    <a class="btn btn-small" onclick="Polygon.delete()" href="#">
	<span class="icon-delete"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_DELETE' ); ?>
    </a>
    <div class="btn-wrapper" style="width:170px"><?php echo $this->form->getInput('polygon_access_level'); ?></div>
     </div>
<div id="toolbar-help" class="btn-wrapper">    
	<a class="modal-button btn btn-small" href=<?php echo $this->config->help_polygon?>>
    <span class="icon-question-sign"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_BUTTON_HELP' ); ?>
    </a>
</div>
</div>
</div>
	<ul id="polygon-tab" class="nav nav-tabs" role="tablist" style="margin-bottom: 5px;">
		<li class="active">
  			<a href="#polygon-page-1" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_POLYGONEDIT' ); ?></a>
		</li>
		<li>
  			<a href="#polygon-page-2" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_LINEINFOWINDOWEDITOR' ); ?></a>
		</li>
		<li>
  			<a href="#polygon-page-3" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_INFOWINDOW_OPTION' ); ?></a>
		</li>
		<li>
  			<a onClick="initpolygontabelle()" href="#polygon-page-4" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_TABLE_POLYGON' ); ?></a>
		</li>
    </ul>

<div class="tab-content">
<div class="tab-pane active" id="polygon-page-1">
<div id="page-section"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_POLYGON_FIELDSET_POLYGON' ); ?></div>
  <table border="0" class="admintable">
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('polygon_title'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('polygon_title'); ?></td>
      <td class="controls"><?php echo $this->form->getLabel('polygon_line_length'); ?></td>
       <td class="controls"><div id="polygon_line_length"></div></td>
      <td class="controls"><?php echo $this->form->getInput('polygon_line_length'); ?></td>
      </tr>
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('polygon_line_color'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('polygon_line_color'); ?>
        <a id="color_button" class="btn btn-small" onclick="openPicker('jform_polygon_line_color', 'polygon')" href="#">
		<img src="components/com_gmap/assets/images/color_wheel.png" />
		<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_LABEL_GET_COLOR' ); ?>
    	</a>
      <td><?php echo $this->form->getLabel('polygon_area'); ?></td>
      <td><div id="polygon_area"></div></td>
      <td><?php echo $this->form->getInput('polygon_area'); ?></td>
	</tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('polygon_line_width'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('polygon_line_width'); ?></td>
      <td></td>
      <td></td>
      <td></td>
        </tr>
        <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('polygon_line_opacity'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('polygon_line_opacity'); ?></td>
      <td></td>

      <td></td>
      <td></td>
		  </tr>
	</table>
   <div id="page-section"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_POLYGON_FIELDSET_FILL' ); ?></div>
  <table class="admintable">
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('polygon_fill_color'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('polygon_fill_color'); ?>
        <a id="color_button" class="btn btn-small" onclick="openPicker('jform_polygon_fill_color', 'polygon')" href="#">
		<img src="components/com_gmap/assets/images/color_wheel.png" />
		<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_LABEL_GET_COLOR' ); ?>
    	</a>
	</tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('polygon_fill_opacity'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('polygon_fill_opacity'); ?></td>
      <td>&nbsp;</td>
	</tr>
		</table>

        </div>
<div class="tab-pane" id="polygon-page-2">
<div class="btn-wrapper" >
    <a class="btn btn-small" onclick="Polygon.setText()" href="#">
	<img class="assume" src="components/com_gmap/assets/images/assume_editor.png" width="16" height="16" />
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_ASSUME' ); ?>
    </a>
    <a class="btn btn-small" onclick="Polygon.deleteText()" href="#">
	<img class="assume" src="components/com_gmap/assets/images/editor_new.png" width="16" height="16" />
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_DELETE' ); ?>
    </a>
    <a class="btn btn-small" onclick="Polygon.deletePosition()" href="#">
	<img class="assume" src="components/com_gmap/assets/images/no.png" width="16" height="16" />
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_DELETE_POSITION' ); ?>
    </a>
</div>
  <div class="controls"><?php echo $this->form->getInput('polygon_beschreibung'); ?></div>
</div>
<div class="tab-pane" id="polygon-page-3">
  <table class="admintable">
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('polygon_infowindow_open'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('polygon_infowindow_open'); ?></td>
	</tr>
    
    </table>
</div>

<div class="tab-pane" id="polygon-page-4">
  <div class="subtabelle" id="page_polygontabelle"></div>
  </div>
	
</div>
</div>
