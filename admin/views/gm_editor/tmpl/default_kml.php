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
<div id="tab-8">
<div class="subhead">
<div id="toolbar" class="btn-toolbar">
<div id="toolbar-save" class="btn-wrapper">
     </div>
<div id="toolbar-help" class="btn-wrapper">    
	<a class="modal-button btn btn-small" href=<?php echo $this->config->help_kml?>>
    <span class="icon-question-sign"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_BUTTON_HELP' ); ?>
    </a>
</div>
</div>
</div>
	<ul id="kml-tab" class="nav nav-tabs" role="tablist" style="margin-bottom: 5px;">
		<li class="active">
  			<a href="#kml-page-1" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_KML_FILE' ); ?></a>
		</li>
<!-- 
		<li>
  			//<a href="#kml-page-2" role="tab" data-toggle="tab">
			//<?php //echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_KML_IMPORT' );?></a>
		</li>
     -->   
    </ul>

<div class="tab-content">
<div class="tab-pane active" id="kml-page-1">
<table border="0">
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('kml_file'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('kml_file'); ?></td>
    </tr>
 </table>
	<?php echo $this->form->getInput('kml_files'); ?>
</div>
<!-- 
<div class="tab-pane" id="kml-page-2">
<table border="0">
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('import_url'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('import_url'); ?>
        <a class="btn btn-small" onclick="controlerLine.setLineText()" href="#">
        <img class="assume" src="components/com_gmap/assets/images/assume_editor.png" width="16" height="16" />
        <?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_KML_BUTTON_ASSUME' ); ?>
        </a>
      </td>
    </tr>
 </table>
  <div class="subtabelle" id="kmlimporttabelle"></div>
</div>	
-->
</div>	
</div>
