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

?>
<ul class="nav nav-tabs hidden" >
	<li class="active"><a data-toggle="tab" href="#home">tab</a></li>
</ul>
<form action="<?php echo JRoute::_('index.php?option=com_gmap&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" >
	<div class="row-fluid">
		<div class="span12 form-horizontal">
	<fieldset class="adminform">
    <legend><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_TITLE' ); ?></legend>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this->form->getLabel('map_titel'); ?>
			</div>
			<div class="controls">
				<?php echo $this->form->getInput('map_titel'); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this->form->getLabel('map_beschreibung'); ?>
			</div>
			<div class="controls">
				<?php echo $this->form->getInput('map_beschreibung'); ?>
			</div>
		</div>
	</fieldset>
		</div>
	</div>
	<div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>