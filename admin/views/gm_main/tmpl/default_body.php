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
?>
Google&trade; is a trademark of Google Inc.<br />
Google Maps&trade; is a trademark of Google Inc.<br />
<a target="_blank" href="<?php echo JText::_( 'COM_GMAP_VIEW_GMAP_DOCUMENTATION_LINK' )?>"><?php echo JText::_( 'COM_GMAP_VIEW_GMAP_DOCUMENTATION' )?></a><br />
Programm Version: <?php echo getParam('version'); ?><br />
Lizenz: GPLv2<br />
Copyrigth &copy; 2016 Andy Thielke

<?php
		function getParam( $name ) {
		$db = JFactory::getDbo();
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE element = '.$db->quote('com_gmap'));
		$manifest = json_decode( $db->loadResult(), true );
		return $manifest[ $name ];
		}
?>

