<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla-24.de
-------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
class plgButtonplg_editors_xtd_gmap extends JPlugin {
	
	
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	function onDisplay($name)
	{
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$template = $app->getTemplate();

		
		$link = 'index.php?option=com_gmap&amp;view=editor&amp;tmpl=component&amp;layout=default&amp;e_name='.$name;

		JHTML::_('behavior.modal');
		$button = new JObject();
		$button->set('modal', true);
		$button->class = 'btn';
		$button->set('link', $link);
		$button->set('text', JText::_('Google Map einfügen'));
		$button->set('name', 'pin');
		$button->set('options', "{handler: 'iframe', size: {x: 600, y: 600}}");

		return $button;
	}
}