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

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
//JHtml::_('behavior.tooltip');
//JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
$doc = JFactory::getDocument();
unset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-core.js']);
unset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-more.js']);

?>
<script type="text/javascript">
jQuery(document).ready(function()  {initialize(); });		
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="counter">
</div>
<div id="gm-toolbar">
<div class="subhead">
<div class="btn-toolbar">
<table width="100%" border="0">
  <tr>
    <td nowrap="nowrap" style="padding-left: 10px; padding-right: 10px;">
         <a class="btn btn-small" onclick="main.SaveAllElements()" href="#">
        <span class="icon-save"></span>
        <?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_SAVE' ); ?>
        </a>
        <a class="btn btn-small" href="<?php echo (JURI::root(true).'/administrator/index.php?option=com_gmap&view=gm_editors');?>">
        <span class="icon-cancel"></span>
        <?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_BUTTON_CLOSE' ); ?>
        </a>
        <a class="btn btn-small" onclick="toggle_screen()" href="#">
        <span class="icon-screen"></span>
        <?php echo JText::_( 'Browser Fullscreen' ); ?>
        </a>
    	<a class="modal-button btn btn-small" href=<?php echo $this->config->help_map_editor?>>
    <span class="icon-question-sign"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_BUTTON_HELP' ); ?>
    </a>
    </td>
    <td nowrap="nowrap" style="padding-left: 10px; padding-right: 10px;">
    <?php echo $this->form->getLabel('showelement'); ?>
    </td>
    <td  width="100%">
    <?php echo $this->form->getInput('showelement'); ?>
    </td>
  </tr>
  <tr>
    <td height="22" colspan="3">
      <div id="savebar"><div id="progress-label2" class="progress-label2"></div></div>
    </td>
    </tr>
</table>
</div>
</div>
</div>	

<ul  id="gmap-main-tab" class="nav nav-tabs" role="tablist">
  <li onClick="showtab(1)" class="active">
  	<a href="#map" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_TAB_MAP_SETUP' ); ?></a>
   </li>
  <li onClick="showtab(2)">
  	<a href="#marker" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_TAB_MARKER' ); ?></a>
   </li>
  <li onClick="showtab(3)">
  	<a href="#recangle" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_TAB_RECANGLE' ); ?></a>
   </li>
  <li onClick="showtab(4)">
  	<a href="#circle" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_TAB_CIRCLE' ); ?></a>
   </li>
  <li onClick="showtab(5)">
  	<a href="#line" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_TAB_LINE' ); ?></a>
   </li>
  <li onClick="showtab(6)">
  	<a href="#polygon" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_TAB_POLYGON' ); ?></a>
   </li>
  <li onClick="showtab(7)">
  	<a href="#htmlbox" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_TAB_HTMLBOX' ); ?></a>
   </li>
  <li onClick="showtab(8)">
  	<a href="#kml" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_TAB_KML' ); ?></a>
   </li>
</ul>
<div id="dialog-confirm" title="">
<p id="marker-dialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
</div>

<table style="margin-top:-20px;" border="0">
	<tr>
	  <td valign="top">
  <div id="map_container" class="ui-widget-content" style="width:<?php echo $this->config->conf_map_breite; ?>px; height:<?php echo $this->config->conf_map_hoehe; ?>px; position:relative; padding: 9px; ">
        <div id="loadbar"><div class="progress-label">Loading...</div></div>
        <div id="map" style="width:100%; height:100%"></div>
        <div id="map_elevation"></div>  
 </div>
        </td>
		<td valign="top">
        
	<div id="map">
          <?php echo $this->loadTemplate('map');?>    
	</div>
      
      <div id="marker">
          <?php echo $this->loadTemplate('marker');?>
      </div>	
      <div id="rectangle">
          <?php echo $this->loadTemplate('rectangle');?>
      </div>	
      <div id="circle">
          <?php echo $this->loadTemplate('circle');?>
      </div>
      <div id="line">
          <?php echo $this->loadTemplate('line');?>
      </div>	
      <div id="polygon">
          <?php echo $this->loadTemplate('polygon');?>
        </div>	
      <div id="htmlbox">
          <?php echo $this->loadTemplate('text');?>
        </div>	
      <div id="kml">
          <?php echo $this->loadTemplate('kml');?>
        </div>	
  <?php echo $this->form->getInput('map_width'); ?>
    <?php echo $this->form->getInput('map_height'); ?>
	<input type="hidden" id="map_lat" value="<?php echo $this->item->map_center_lat; ?>" />
	<input type="hidden" id="default_lat" value="<?php echo $this->config->conf_center_lat; ?>" />
	<input type="hidden" id="default_lng" value="<?php echo $this->config->conf_center_lng; ?> " />
	<input type="hidden" id="default_zoom" value="<?php echo $this->config->conf_start_zoom; ?> " />
    <input type="hidden" id="map_id" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="option" value="com_gmap" />
	<input type="hidden" name="task" value="save_map" />
   <input type="hidden" name="view" value="gm_editor" /> 
	<input type="hidden" name="controller" value="gm_editor" />
        </td>
	</tr>
</table>

</form>
