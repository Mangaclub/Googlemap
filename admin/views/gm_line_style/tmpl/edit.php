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
JHtml::_('behavior.formvalidation');
$doc = JFactory::getDocument();
unset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-core.js']);
unset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-more.js']);

?>
<script type="text/javascript">

jQuery(document).ready(function() {
	
});

</script>
<form action="<?php echo JRoute::_('index.php?option=com_gmap&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" >
<div class="span12 ">
	<div class="row-fluid">
		<div class="span4 form-horizontal">
        <legend><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_LINE_STYLE_GROUP_SETUP' ); ?></legend>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
		</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('path'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('path'); ?></div>
		</div>
		<div class="control-group gm-control-group gm-border-top">
			<div class="control-label"><?php echo $this->form->getLabel('anchor_x'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('anchor_x'); ?></div>
		</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('anchor_y'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('anchor_y'); ?></div>
		</div>
		<div class="control-group gm-control-group gm-border-top">
			<div class="control-label"><?php echo $this->form->getLabel('fillColor'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('fillColor'); ?></div>
		</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('fillOpacity'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('fillOpacity'); ?></div>
		</div>
		<div class="control-group gm-control-group gm-border-top">
			<div class="control-label"><?php echo $this->form->getLabel('strokeColor'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('strokeColor'); ?></div>
		</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('strokeWeight'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('strokeWeight'); ?></div>
		</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('strokeOpacity'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('strokeOpacity'); ?></div>
		</div>
		<div class="control-group gm-control-group gm-border-top">
			<div class="control-label"><?php echo $this->form->getLabel('rotation'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('rotation'); ?></div>
		</div>
		</div>
	
	<div class="span5">
<legend><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_LINE_STYLE_GROUP_PREVIEW_ELEMENT' ); ?></legend>
    <div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('svg_zoom'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('svg_zoom'); ?></div>
		</div>

    <div id="svgContainer" ></div>

<legend><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_LINE_STYLE_GROUP_PREVIEW_MAP' ); ?></legend> 
<div id="accordion">
    <h6><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_LINE_STYLE_PREVIEW_MAP_OPTION' ); ?></h6>
        <div class="form-horizontal">
			<div class="control-group gm-control-group">
				<div class="control-label"><?php echo $this->form->getLabel('opt_line_visible'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('opt_line_visible'); ?></div>
			</div>
		<div class="control-group gm-control-group">
			<div class="control-label"><?php echo $this->form->getLabel('scale'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('scale'); ?></div>
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
	<div id="map_container" class="ui-widget-content" style="width:<?php echo $this->config->conf_map_breite; ?>px; height:<?php echo $this->config->conf_map_hoehe; ?>px; position:relative; padding: 9px; ">
        <div id="map" style="width:100%; height:100%"></div>
 </div>    
    </div>
    </div>
 </div> 
		<input type="hidden" name="task" value="" />
        <?php echo $this->form->getInput('parameter'); ?>
		<?php echo JHtml::_('form.token'); ?>

</form>