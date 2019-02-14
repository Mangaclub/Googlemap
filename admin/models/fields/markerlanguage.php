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
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * editortextbox Form Field class for the Gmap component
 */
class JFormFieldmarkerlanguage extends JFormFieldList
{

	protected $type = 'markerlanguage';

	protected function getOptions()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('#__languages.sef as id, #__languages.title as title');
		$query->from('#__languages');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if($items){
			foreach($items as $item){
				$options[] = JHtml::_('select.option', $item->id, ucwords($item->title));
			};
			$options[] = JHtml::_('select.option', '0', JText::_('COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_LANGUAGE'));
		};
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
?>