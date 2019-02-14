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
class GmapModelgm_map_style extends JModelAdmin
{

	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return JFactory::getUser()->authorise('core.edit', 'com_gmap.message.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}

	public function getTable($type = 'gm_map_style', $prefix = 'GmapTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_gmap.gm_map_style', 'gm_map_style', array('control' => 'jform', 'load_data' => $loadData));

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
		$data = JFactory::getApplication()->getUserState('com_gmap.edit.gm_map_style.data', array());

		if (empty($data)){
			$data = $this->getItem();
		};

	return $data;
	}
	public function getConfig ()
	{
		$item = $this->getTable('gm_config');
		$item->load(1);
		return $item;
	}
	public function update_map_style() {
	$db = JFactory::getDbo();
	$jform = JRequest::getVar('jform');
	$id =JRequest::getVar('id');;
	$title =$jform['title'];
	$pfad =$jform['style'];
	$parameter =$jform['parameter'];
	if (empty($id)){
	$query = "INSERT INTO #__gm_map_style VALUES (
			'',
			'$title',
			'$style',
			'$parameter',
			);";
	}else {
		$query = "UPDATE #__gm_map_style SET
			title = '$title',
			style = '$pfad',
			parameter = '$parameter'
			WHERE id = '$id'";
	}
	$db->setQuery($query);
 	$db->Query();
}
	
	public function map_style_delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row =& $this->getTable('gm_map_style');
    	$dba	=& JFactory::getDBO();
		if (count( $cids )) {
			foreach($cids as $cid) {
					$query1 = "delete from #__gm_map_style WHERE id='$cid' ";
	       	$dba->setQuery($query1);
			$dba->Query();
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}
	
}
?>