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
<div id="tab-5">
<div class="subhead">
<div id="toolbar" class="btn-toolbar">
<div id="toolbar-save" class="btn-wrapper">
	<a class="btn btn-small" onclick="linenew()" href="#">
	<span class="icon-plus-2"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_NEW' ); ?>
    </a>
    <a class="btn btn-small" onclick="Line.delete()" href="#">
	<span class="icon-delete"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_DELETE' ); ?>
    </a>
    <div class="btn-wrapper" style="width:170px"><?php echo $this->form->getInput('line_access_level'); ?></div>
     </div>
<div id="toolbar-help" class="btn-wrapper">    
	<a class="modal-button btn btn-small" href=<?php echo $this->config->help_line?>>
    <span class="icon-question-sign"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_BUTTON_HELP' ); ?>
    </a>
</div>
</div>
</div>
	<ul id="line-tab" class="nav nav-tabs" role="tablist" style="margin-bottom: 5px;">
		<li class="active">
  			<a href="#line-page-1" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_LINEEDIT' ); ?></a>
		</li>
		<li>
  			<a href="#line-page-2" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_LINEINFOWINDOWEDITOR' ); ?></a>
		</li>
		<li>
  			<a href="#line-page-3" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_INFOWINDOW_OPTION' ); ?></a>
		</li>
		<li>
  			<a href="#line-page-4" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_FIELDSET_CHART' ); ?></a>
		</li>
		<li>
  			<a onClick="initlinetabelle()" href="#line-page-5" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_TABLE_LINE' ); ?></a>
		</li>
    </ul>

<div class="tab-content">
<div class="tab-pane active" id="line-page-1">
<div id="page-section"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_FIELDSET_LINE' ); ?></div>
  <table border="0" class="admintable">
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('line_title'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('line_title'); ?></td>
      <td class="controls"><?php echo $this->form->getLabel('line_length'); ?></td>
      <td class="controls"><div id="line_length"></div></td>
      <td class="controls"><?php echo $this->form->getInput('line_length'); ?></td>
      </tr>
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('line_farbe_linie'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('line_farbe_linie'); ?>
        <a id="color_button" class="btn btn-small" onclick="openPicker('jform_line_farbe_linie', 'line')" href="#">
		<img src="components/com_gmap/assets/images/color_wheel.png" />
		<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_LABEL_GET_COLOR' ); ?>
    	</a>
        </td>
      <td></td>
      <td></td>
      <td></td>
	</tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('line_width'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('line_width'); ?></td>
      <td></td>
      <td></td>
      <td></td>
        </tr>
        <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('line_opacity'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('line_opacity'); ?></td>
      <td></td>
      <td></td>
      <td></td>
		  </tr>
	</table>
<div id="page-section"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_STYLE_OPTION' ); ?></div>
        <div class="form-horizontal">
			<div class="control-group gm-control-group">
				<div class="control-label"><?php echo $this->form->getLabel('line_style'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('line_style'); ?></div>
			</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('opt_line_scale'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('opt_line_scale'); ?></div>
		</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('opt_line_zindex'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('opt_line_zindex'); ?></div>
		</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('opt_line_svg_offset'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('opt_line_svg_offset'); ?></div>
		</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('opt_line_svg_repeat'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('opt_line_svg_repeat'); ?></div>
		</div>
      
        </div>
 </div>
<div class="tab-pane" id="line-page-2">
<div class="btn-wrapper" >
    <a class="btn btn-small" onclick="Line.setText()" href="#">
	<img class="assume" src="components/com_gmap/assets/images/assume_editor.png" width="16" height="16" />
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_ASSUME' ); ?>
    </a>
    <a class="btn btn-small" onclick="Line.deleteText()" href="#">
	<img class="assume" src="components/com_gmap/assets/images/editor_new.png" width="16" height="16" />
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_DELETE' ); ?>
    </a>
    <a class="btn btn-small" onclick="Line.deleteInfoWindowPosition()" href="#">
	<img class="assume" src="components/com_gmap/assets/images/no.png" width="16" height="16" />
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_DELETE_POSITION' ); ?>
    </a>
</div>
  <div class="controls"><?php echo $this->form->getInput('line_beschreibung'); ?></div>
</div>
<div class="tab-pane" id="line-page-3">
  <table class="admintable">
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('line_infowindow_open'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('line_infowindow_open'); ?></td>
	</tr>
    
    </table>
</div>
<div class="tab-pane" id="line-page-4">    
  <table border="0" class="admintable">
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('chart_on_off'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('chart_on_off'); ?></td>
      <td class="control-label"><?php echo $this->form->getLabel('chart_units'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('chart_units'); ?></td>

      </tr>
	</table>
       
</div>      
<div class="tab-pane" id="line-page-5">
  <div class="subtabelle" id="page_linetabelle"></div>
  </div>

</div>	
</div>
