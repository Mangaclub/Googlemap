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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$params = $this->form->getFieldsets('params');

?>
<form action="<?php echo JRoute::_('index.php?option=com_gmap&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<div class="row-fluid">
		<div class="span12 form-horizontal">
      <fieldset class="adminform">
    <legend><?php echo JText::_( 'COM_GMAP_VIEW_LANG_EDIT_FIELDSET_SETUP_LANGSET' ); ?></legend>
	<table class="admintable">
			<tr>
			<td width="50" align="right" nowrap="nowrap" class="control-label">
			<?php echo $this->form->getLabel('lang_title'); ?>
            </td>
			<td class="controls">
			<?php echo $this->form->getInput('lang_title'); ?>
            </td>
		</tr>
			<tr>
			  <td align="right" nowrap="nowrap" class="control-label">
			  <?php echo $this->form->getLabel('lang_short'); ?>
              </td>
			  <td class="controls">
              <?php echo $this->form->getInput('lang_short'); ?>
              </td>
	  </tr>
      </table>
      </fieldset>
      <fieldset class="adminform">
    <legend><?php echo JText::_( 'COM_GMAP_VIEW_LANG_EDIT_FIELDSET_MAP_VIEW' ); ?></legend>
	<table class="admintable">
			<tr>
			  <td align="right" nowrap="nowrap" class="control-label">
			  <?php echo $this->form->getLabel('lang_map_view_roadmap'); ?>
              </td>
			  <td class="controls">
              <?php echo $this->form->getInput('lang_map_view_roadmap'); ?>
              </td>
	  	</tr>
  		<tr>
    		<td align="right" nowrap="nowrap" class="control-label">
			  <?php echo $this->form->getLabel('lang_map_view_terrain'); ?>
              </td>
    		<td class="controls">
              <?php echo $this->form->getInput('lang_map_view_terrain'); ?>
           	</td>
	  	</tr>
  		<tr>
    		<td align="right" nowrap="nowrap" class="control-label">
			  <?php echo $this->form->getLabel('lang_map_view_satellite'); ?>
              </td>
    		<td class="controls">
              <?php echo $this->form->getInput('lang_map_view_satellite'); ?>
           	</td>
	  	</tr>
  		<tr>
    		<td align="right" nowrap="nowrap" class="control-label">
			  <?php echo $this->form->getLabel('lang_map_view_hybrid'); ?>
              </td>
    		<td class="controls">
              <?php echo $this->form->getInput('lang_map_view_hybrid'); ?>
           	</td>
	  	</tr>
      </table>
      </fieldset>
      <fieldset class="adminform">
    <legend><?php echo JText::_( 'COM_GMAP_VIEW_LANG_EDIT_FIELDSET_MAP_LAYER' ); ?></legend>
	<table class="admintable">
			<tr>
			  <td align="right" nowrap="nowrap" class="control-label">
			  <?php echo $this->form->getLabel('lang_layer_bike'); ?>
              </td>
			  <td class="controls">
              <?php echo $this->form->getInput('lang_layer_bike'); ?>
              </td>
	  	</tr>
  		<tr>
    		<td align="right" nowrap="nowrap" class="control-label">
			  <?php echo $this->form->getLabel('lang_layer_traffic'); ?>
              </td>
    		<td class="controls">
              <?php echo $this->form->getInput('lang_layer_traffic'); ?>
           	</td>
	  	</tr>
  		<tr>
    		<td align="right" nowrap="nowrap" class="control-label">
			  <?php echo $this->form->getLabel('lang_layer_transit'); ?>
              </td>
    		<td class="controls">
              <?php echo $this->form->getInput('lang_layer_transit'); ?>
           	</td>
	  	</tr>

  		<tr>
    		<td align="right" nowrap="nowrap" class="control-label">
			  <?php echo $this->form->getLabel('lang_layer_streetview'); ?>
              </td>
    		<td class="controls">
              <?php echo $this->form->getInput('lang_layer_streetview'); ?>
           	</td>
	  	</tr>
      </table>
      </fieldset>
  <input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />

	  <input type="hidden" name="task" value="lang.edit" />
      <input type="hidden" name="controller" value="gm_lang" />
		<?php echo JHtml::_('form.token'); ?>
</form>