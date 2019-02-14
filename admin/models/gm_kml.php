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
class GmapModelgm_kml extends JModelAdmin
{

	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return JFactory::getUser()->authorise('core.edit', 'com_gmap.message.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}

	public function getTable($type = 'gm_kml', $prefix = 'GmapTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_gmap.gm_kml', 'gm_kml', array('control' => 'jform', 'load_data' => $loadData));

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
		$data = JFactory::getApplication()->getUserState('com_gmap.edit.gm_kml.data', array());

		if (empty($data)){
			$data = $this->getItem();
		};

	return $data;
	}
	
	public function update_kml() {
	$db = JFactory::getDbo();
	$jform = JRequest::getVar('jform');
	$id =JRequest::getVar('id');;
	$kml_title =$jform['kml_title'];
	$kml_pfad =$jform['kml_pfad'];
	$kml_beschreibung =$jform['kml_beschreibung'];
	if (empty($id)){
	$query = "INSERT INTO #__gm_kml VALUES (
			'',
			'$kml_title',
			'$kml_pfad',
			'$kml_beschreibung',
			''
			);";
	}else {
		$query = "UPDATE #__gm_kml SET
			kml_title = '$kml_title',
			kml_pfad = '$kml_pfad',
			kml_beschreibung = '$kml_beschreibung'
			WHERE id = '$id'";
	}
	$db->setQuery($query);
 	$db->Query();
}
	
	public function kmldelete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row =& $this->getTable('gm_kml');
    	$dba	=& JFactory::getDBO();
		if (count( $cids )) {
			foreach($cids as $cid) {
					$query1 = "delete from #__gm_kml WHERE id='$cid' ";
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