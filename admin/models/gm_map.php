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
class GmapModelgm_map extends JModelAdmin
{

	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return JFactory::getUser()->authorise('core.edit', 'com_gmap.message.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}

	public function getTable($type = 'gm_map', $prefix = 'GmapTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_gmap.gm_map', 'gm_map', array('control' => 'jform', 'load_data' => $loadData));

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
		$data = JFactory::getApplication()->getUserState('com_gmap.edit.gm_map.data', array());

		if (empty($data)){
			$data = $this->getItem();
		};

	return $data;
	}
	
	public function update_map_header() {
	$db = JFactory::getDbo();
	$jform = JRequest::getVar('jform');
	$id =JRequest::getVar('id');;
	$map_titel =$jform['map_titel'];
	$map_beschreibung =$jform['map_beschreibung'];
	if (empty($id)){
	$query = "INSERT INTO #__gm_map VALUES (
			'',
			'$map_titel',
			'$map_beschreibung',
			'','','','',''
			);";
	}else {
		$query = "UPDATE #__gm_map SET
			map_titel = '$map_titel',
			map_beschreibung = '$map_beschreibung'
			WHERE id = '$id'";
	}
	$db->setQuery($query);
 	$db->Query();
}
	
	public function duplicate()
		{
		$cids = JRequest::getVar( 'cid', array(0), 'jform', 'array' );
    	$dba	=& JFactory::getDBO();
		if (count( $cids )) {
			foreach($cids as $cid) {
					$query = "CREATE TABLE #__tmp4628 SELECT * FROM #__gm_map WHERE id = '$cid'";
	       			$dba->setQuery($query);
					$dba->Query();
					$query = "UPDATE #__tmp4628 SET id = NULL ";
					$dba->setQuery($query);
					$dba->Query();
					$query = "INSERT INTO #__gm_map SELECT * FROM #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
					$query = "DROP TABLE #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
					
					$query = "SELECT * FROM #__gm_map ORDER BY id DESC LIMIT 0,1";
	       			$dba->setQuery($query);
					$item = $dba->loadObject();
					$map_id = $item->id;
					$map_title = $item->map_titel;
					$map_title .=' (2)';
					$query = "UPDATE #__gm_map SET map_titel = '$map_title' WHERE id = '$map_id' ";
					$dba->setQuery($query);
					$dba->Query();
					
					$query = "CREATE TABLE #__tmp4628 SELECT * FROM #__gm_text WHERE id_map = '$cid'";
	       			$dba->setQuery($query);
					$dba->Query();
					$query = "UPDATE #__tmp4628 SET id = NULL, id_map = '$map_id' ";
					$dba->setQuery($query);
					$dba->Query();
					$query = "INSERT INTO #__gm_text SELECT * FROM #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
					$query = "DROP TABLE #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
					
					$query = "CREATE TABLE #__tmp4628 SELECT * FROM #__gm_marker WHERE id_map = '$cid'";
	       			$dba->setQuery($query);
					$dba->Query();
					$query = "UPDATE #__tmp4628 SET id = NULL, id_map = '$map_id' ";
					$dba->setQuery($query);
					$dba->Query();
					$query = "INSERT INTO #__gm_marker SELECT * FROM #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
					$query = "DROP TABLE #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();

					$query = "CREATE TABLE #__tmp4628 SELECT * FROM #__gm_circle WHERE id_map = '$cid'";
	       			$dba->setQuery($query);
					$dba->Query();
					$query = "UPDATE #__tmp4628 SET id = NULL, id_map = '$map_id' ";
					$dba->setQuery($query);
					$dba->Query();
					$query = "INSERT INTO #__gm_circle SELECT * FROM #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
					$query = "DROP TABLE #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();

					$query = "CREATE TABLE #__tmp4628 SELECT * FROM #__gm_rectangle WHERE id_map = '$cid'";
	       			$dba->setQuery($query);
					$dba->Query();
					$query = "UPDATE #__tmp4628 SET id = NULL, id_map = '$map_id' ";
					$dba->setQuery($query);
					$dba->Query();
					$query = "INSERT INTO #__gm_rectangle SELECT * FROM #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
					$query = "DROP TABLE #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();

					$query = "CREATE TABLE #__tmp4628 SELECT * FROM #__gm_line WHERE id_map = '$cid'";
	       			$dba->setQuery($query);
					$dba->Query();
					$query = "UPDATE #__tmp4628 SET id = NULL, id_map = '$map_id' ";
					$dba->setQuery($query);
					$dba->Query();
					$query = "INSERT INTO #__gm_line SELECT * FROM #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
					$query = "DROP TABLE #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();

					$query = "CREATE TABLE #__tmp4628 SELECT * FROM #__gm_polygon WHERE id_map = '$cid'";
	       			$dba->setQuery($query);
					$dba->Query();
					$query = "UPDATE #__tmp4628 SET id = NULL, id_map = '$map_id' ";
					$dba->setQuery($query);
					$dba->Query();
					$query = "INSERT INTO #__gm_polygon SELECT * FROM #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
					$query = "DROP TABLE #__tmp4628";
					$dba->setQuery($query);
					$dba->Query();
			}
		}
		return true;
	}
	public function mapdelete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row =& $this->getTable('gm_map');
    	$dba	=& JFactory::getDBO();
		if (count( $cids )) {
			foreach($cids as $cid) {
					$query1 = "delete from #__gm_text WHERE id_map='$cid' ";
					$query2 = "delete from #__gm_marker WHERE id_map='$cid'";
					$query3 = "delete from #__gm_circle WHERE id_map='$cid' ";
					$query4 = "delete from #__gm_rectangle WHERE id_map='$cid' ";
					$query5 = "delete from #__gm_line WHERE id_map='$cid' ";
					$query6 = "delete from #__gm_polygon WHERE id_map='$cid' ";
	       	$dba->setQuery($query1);
			$dba->Query();
	       	$dba->setQuery($query2);
			$dba->Query();
	       	$dba->setQuery($query3);
			$dba->Query();
	       	$dba->setQuery($query4);
			$dba->Query();
	       	$dba->setQuery($query5);
			$dba->Query();
	       	$dba->setQuery($query6);
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