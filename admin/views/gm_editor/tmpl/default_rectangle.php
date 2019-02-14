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
<div id="tab-3">
<div class="subhead">
<div id="toolbar" class="btn-toolbar">
<div id="toolbar-save" class="btn-wrapper">
	<a class="btn btn-small" onclick="rectanglenew()" href="#">
	<span class="icon-plus-2"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_NEW' ); ?>
    </a>
    <a class="btn btn-small" onclick="Rectangle.delete()" href="#">
	<span class="icon-delete"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_DELETE' ); ?>
    </a>
    <div class="btn-wrapper" style="width:170px"><?php echo $this->form->getInput('rectangle_access_level'); ?></div>
     </div>
<div id="toolbar-help" class="btn-wrapper">    
	<a class="modal-button btn btn-small" href=<?php echo $this->config->help_rectangle?>>
    <span class="icon-question-sign"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_BUTTON_HELP' ); ?>
    </a>
</div>
</div>
</div>
	<ul id="rectangle-tab" class="nav nav-tabs" role="tablist" style="margin-bottom: 5px;">
		<li class="active">
  			<a href="#rectangle-page-1" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUNTAB_RECTANGLEEDIT' ); ?></a>
		</li>
		<li>
  			<a href="#rectangle-page-2" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_LINEINFOWINDOWEDITOR' ); ?></a>
		</li>
		<li>
  			<a href="#rectangle-page-3" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_INFOWINDOW_OPTION' ); ?></a>
		</li>
		<li>
  			<a onClick="initrectangletabelle()" href="#rectangle-page-4" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_TABLERECTANGLE' ); ?></a>
		</li>
    </ul>
<div class="tab-content">
<div class="tab-pane active" id="rectangle-page-1">

   <div id="page-section"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_RECTANGLE_FIELDSET_LINE' ); ?></div>
   <table class="admintable">
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('rectangle_title'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('rectangle_title'); ?></td>
      <td></td>
    </tr>
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('rectangle_farbe_linie'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('rectangle_farbe_linie'); ?>
        <a id="color_button" class="btn btn-small" onclick="openPicker('jform_rectangle_farbe_linie', 'rectangle')" href="#">
		<img src="components/com_gmap/assets/images/color_wheel.png" />
		<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_LABEL_GET_COLOR' ); ?>
    	</a>
      </td>
	  <td></td>
	</tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('rectangle_line_width'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('rectangle_line_width'); ?></td>
      <td></td>
    </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('rectangle_line_opacity'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('rectangle_line_opacity'); ?></td>
      <td>&nbsp;</td>
	</tr>
		</table>
   <div id="page-section"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_RECTANGLE_FIELDSET_FILL' ); ?></div>
  <table class="admintable">
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('rectangle_farbe_fuellung'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('rectangle_farbe_fuellung'); ?>
        <a id="color_button" class="btn btn-small" onclick="openPicker('jform_rectangle_farbe_fuellung', 'rectangle')" href="#">
		<img src="components/com_gmap/assets/images/color_wheel.png" />
		<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_LABEL_GET_COLOR' ); ?>
    	</a>
      </td>
      <td></td>
	</tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('rectangle_fill_opacity'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('rectangle_fill_opacity'); ?></td>
      <td>&nbsp;</td>
	</tr>
		</table>
   
   </div>
<div class="tab-pane" id="rectangle-page-2">
<div class="btn-wrapper" >
    <a class="btn btn-small" onclick="Rectangle.setText()" href="#">
	<img class="assume" src="components/com_gmap/assets/images/assume_editor.png" width="16" height="16" />
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_ASSUME' ); ?>
    </a>
    <a class="btn btn-small" onclick="Rectangle.deleteText()" href="#">
	<img class="assume" src="components/com_gmap/assets/images/editor_new.png" width="16" height="16" />
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_DELETE' ); ?>
    </a>
    <a class="btn btn-small" onclick="Rectangle.deleteInfoWindowPosition()" href="#">
	<img class="assume" src="components/com_gmap/assets/images/no.png" width="16" height="16" />
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_DELETE_POSITION' ); ?>
    </a>
</div>
  <div class="controls"><?php echo $this->form->getInput('rectangle_beschreibung'); ?></div>
     <div id="gmfieldset_infowindow">
   </div>
</div>
   <div class="tab-pane" id="rectangle-page-3">
  <table class="admintable">
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('rectangle_infowindow_open'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('rectangle_infowindow_open'); ?></td>
	</tr>
    
    </table>
</div>
   <div class="tab-pane" id="rectangle-page-4">
  <div class="subtabelle" id="page_rectangletabelle"></div>
</div>
</div>
</div>
