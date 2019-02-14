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

$edit = "index.php?option=com_gmap&view=gm_editor&layout=fc_default";
$fullscreenedit = "index.php?option=com_gmap&tmpl=component&view=gm_editor&layout=fc_default";
$user = JFactory::getUser();
$userId = $user->get('id');
?>
<?php foreach($this->items as $i => $item){
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->map_titel; ?> - (<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo 'Edit'; ?></a>)
			 - (<a href="<?php echo $fullscreenedit; ?>&id=<?php echo $item->id; ?>"><?php echo 'Full Screen Edit'; ?></a>)
            
		</td>
		<td>
			<?php echo $item->map_beschreibung; ?>
		</td>
	</tr>
<?php } ?>