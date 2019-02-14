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
<div id="tab-7">
<div class="subhead">
<div id="toolbar" class="btn-toolbar">
<div id="toolbar-save" class="btn-wrapper">
	<a class="btn btn-small" onclick="textnew()" href="#">
	<span class="icon-plus-2"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_NEW' ); ?>
    </a>
    <a class="btn btn-small" onclick="Box.delete()" href="#">
	<span class="icon-delete"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_DELETE' ); ?>
    </a>
    <div class="btn-wrapper" style="width:170px"><?php echo $this->form->getInput('htmlbox_access_level'); ?></div>
     </div>
<div id="toolbar-help" class="btn-wrapper">    
	<a class="modal-button btn btn-small" href=<?php echo $this->config->help_html_box?>>
    <span class="icon-question-sign"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_BUTTON_HELP' ); ?>
    </a>
</div>
</div>
</div>
	<ul id="htmlbox-tab" class="nav nav-tabs" role="tablist" style="margin-bottom: 5px;">
		<li class="active">
  			<a href="#htmlbox-page-1" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_HTMLBOXEDIT' ); ?></a>
		</li>
		<li>
  			<a onClick="inittexttabelle()" href="#htmlbox-page-2" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_TABLE_HTMLBOX' ); ?></a>
		</li>
    </ul>

<div class="tab-content">
<div class="tab-pane active" id="htmlbox-page-1">
<div id="page-section"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_HTMLBOX_FIELDSET_POSITION' ); ?></div>
	<div class="form-horizontal">
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('htmlbox_rotation'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('htmlbox_rotation'); ?></div>
		</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('htmlbox_range_view'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('htmlbox_range_view'); ?></div>
		</div>
    </div>
<div id="page-section"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_HTMLBOX_FIELDSET_EDITOR' ); ?></div>
    <div class="btn-wrapper" >
        <a class="btn btn-small" onclick="Box.setContent()" href="#">
        <img class="assume" src="components/com_gmap/assets/images/assume_editor.png" width="16" height="16" />
        <?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_ASSUME' ); ?>
        </a>
    </div>

<?php echo $this->form->getInput('text_box_beschreibung'); ?>
        </div>
<div class="tab-pane" id="htmlbox-page-2">
  <div class="subtabelle" id="page_texttabelle"></div>
</div>
<input type="hidden" id ="activtext" name="activtext" value="" />		
 
</div>	
</div>
