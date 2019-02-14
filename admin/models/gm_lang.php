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

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * Gmaps Model
 */
class GmapModelgm_lang extends JModelAdmin
{

	public function getTable($type = 'gm_lang', $prefix = 'GmapTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_gmap.gm_lang', 'gm_lang', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form)){
			return false;
		};

		return $form;
	}

	public function getScript()
	{
		return 'administrator/components/com_gmap/models/forms/gmaps.js';
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_gmap.edit.gm_lang.data', array());

		if (empty($data)){
			$data = $this->getItem();
		};

	return $data;
	}
	
	public function update_lang_record() {
	$db = JFactory::getDbo();
	$jform = JRequest::getVar('jform');
	$id =JRequest::getVar('id');;
	$lang_title =$jform['lang_title'];
	$lang_short =$jform['lang_short'];
	$lang_map_view_roadmap =$jform['lang_map_view_roadmap'];
	$lang_map_view_terrain =$jform['lang_map_view_terrain'];
	$lang_map_view_satellite =$jform['lang_map_view_satellite'];
	$lang_map_view_hybrid =$jform['lang_map_view_hybrid'];
	$lang_layer_bike =$jform['lang_layer_bike'];
	$lang_layer_traffic =$jform['lang_layer_traffic'];
	$lang_layer_transit =$jform['lang_layer_transit'];
	$lang_layer_streetview =$jform['lang_layer_streetview'];

	if (empty($id)){
	$query = "INSERT INTO #__gm_lang VALUES (
			'',
			'$lang_title',
			'$lang_short',
			'$lang_map_view_roadmap',
			'$lang_map_view_terrain',
			'$lang_map_view_satellite',
			'$lang_map_view_hybrid',
			'$lang_layer_bike',
			'$lang_layer_traffic',
			'$lang_layer_transit',
			'$lang_layer_streetview'
			);";
	}else {
		$query = "UPDATE #__gm_lang SET
			lang_title = '$lang_title',
			lang_short = '$lang_short',
			lang_map_view_roadmap = '$lang_map_view_roadmap',
			lang_map_view_terrain = '$lang_map_view_terrain',
			lang_map_view_satellite = '$lang_map_view_satellite',
			lang_map_view_hybrid = '$lang_map_view_hybrid',
			lang_layer_bike = '$lang_layer_bike',
			lang_layer_traffic = '$lang_layer_traffic',
			lang_layer_transit = '$lang_layer_transit',
			lang_layer_streetview = '$lang_layer_streetview'
			WHERE id = '$id'";
	}
	$db->setQuery($query);
 	$db->Query();
}
	public function getAjaxData()
	{
		jimport( 'joomla.language.language' );
		$lang = JRequest::getVar('lang');
		if ($lang == 'auto'){
			$lang = JFactory::getLanguage();
			$teile = explode("-", $lang->getTag());
			$lang =$teile[0];
		}

		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__gm_lang WHERE lang_short = '$lang'";
		$db->setQuery( $query );
		$item = $db->loadObject();
		if (count($item) != '1'){
			$query = "SELECT * FROM #__gm_lang WHERE lang_short = 'en'";
			$db->setQuery( $query );
			$item = $db->loadObject();

		}
		return $item;
	}
}
?>