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
class GmapModelgm_config extends JModelAdmin
{
protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return JFactory::getUser()->authorise('core.edit', 'com_gmap.message.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}
	
public function getTable($type = 'gm_config', $prefix = 'GmapTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_gmap.gm_config', 'gm_config', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form)){
			return false;
		};

		return $form;
	}

public function getScript()
	{
		$scripte = 'https://maps.google.com/maps/api/js?&sensor=false';
		return 'https://maps.google.com/maps/api/js?&sensor=false';
	}

protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_gmap.edit.gm_config.data', array());

		if (empty($data)){
			$data = $this->getItem();
			if (!empty($data->conf_parameter)){
			$teile = explode(";", $data->conf_parameter);
				if (count( $teile ) > '0'){
					for ($a=0, $b=count( $teile ); $a < $b; $a++){
						$parameter = explode("|", $teile[$a]);
						$data->{$parameter[0]} = $parameter[1];
					}
				}
			}
		};

	return $data;
	}
public function update_config() {
	$db = JFactory::getDbo();
	$jform = JRequest::getVar('jform');
	$conf_map_breite =$jform['conf_map_breite'];
	$conf_map_hoehe =$jform['conf_map_hoehe'];
	$conf_start_zoom =$jform['conf_start_zoom'];
	$conf_center_lat =$jform['conf_center_lat'];
	$conf_center_lng =$jform['conf_center_lng'];
	$conf_parameter = 'conf_api_key|'.$jform['conf_api_key'];
	$query = "UPDATE #__gm_config SET
			conf_map_breite = '$conf_map_breite',
			conf_map_hoehe = '$conf_map_hoehe',
			conf_start_zoom ='$conf_start_zoom',
			conf_center_lat = '$conf_center_lat',
			conf_center_lng = '$conf_center_lng',
			conf_parameter = '$conf_parameter'
			 WHERE id = '1'";
	$db->setQuery($query);
 	$db->Query();
}
  public function create_backup(){
		$db = JFactory::getDbo();
	  		/////////////Löschen aller Backup Tabellen/////////////////
		$array = array('gm_config',
						'gm_map',
						'gm_marker',
						'gm_lang',
						'gm_circle',
						'gm_rectangle',
						'gm_text',
						'gm_line',
						'gm_polygon',
						'gm_kml'
						);	
			foreach($array as $table){
			$query = "DROP TABLE IF EXISTS #__".$table."_bak";
			$db->setQuery($query);
 			$db->Query();
		}
		////////////Erstellen der neuen Lang Tabelle///////////////
			$query = "CREATE TABLE #__gm_lang_bak (
					  id int(11) NOT NULL AUTO_INCREMENT,
					  lang_title varchar(80) NOT NULL,
					  lang_short varchar(5) NOT NULL,
					  lang_map_view_roadmap varchar(100) NOT NULL,
					  lang_map_view_terrain varchar(100) NOT NULL,
					  lang_map_view_satellite varchar(100) NOT NULL,
					  lang_map_view_hybrid varchar(100) NOT NULL,
					  lang_layer_bike varchar(100) NOT NULL,
					  lang_layer_traffic varchar(100) NOT NULL,
					  lang_layer_transit varchar(100) NOT NULL,
					  lang_layer_weather varchar(100) NOT NULL,
					  lang_layer_streetview varchar(100) NOT NULL,
					  PRIMARY KEY id (id)
					) ";
			$db->setQuery($query);
 			$db->Query();
		////////////Erstellen der neuen map Tabelle///////////////	
			$query = "CREATE TABLE #__gm_map_bak (
					  id int(11) NOT NULL AUTO_INCREMENT,
					  map_titel varchar(255) NOT NULL,
					  map_beschreibung text NOT NULL,
					  map_center_lat varchar(30) NOT NULL,
					  map_center_lng varchar(30) NOT NULL,
					  map_zoom varchar(3) NOT NULL,
					  map_parameter text NOT NULL,
					  street_view_parameter text NOT NULL,
					  PRIMARY KEY (id)
					) ";
			$db->setQuery($query);
			$db->Query();
		/////////////Erstellen der neuen Marker Tabelle/////////////////
			$query = "CREATE TABLE #__gm_marker_bak (
					  id int(11) NOT NULL AUTO_INCREMENT,
					  id_map int(3) NOT NULL,
					  marker_titel varchar(100) NOT NULL,
					  marker_strasse varchar(150) NOT NULL,
					  marker_plz varchar(6) NOT NULL,
					  marker_ort varchar(50) NOT NULL,
					  marker_beschreibung text NOT NULL,
					  marker_icon varchar(60) NOT NULL,
					  marker_lng varchar(30) NOT NULL,
					  marker_lat varchar(30) NOT NULL,
					  marker_parameter text NOT NULL,
					  access_group int(2) NOT NULL,
					  PRIMARY KEY (id)
						)";
			$db->setQuery($query);
			$db->Query();
			$query = "CREATE TABLE #__gm_config_bak (
					  id int(5) NOT NULL DEFAULT '1',
					  conf_map_breite varchar(5) NOT NULL,
					  conf_map_hoehe varchar(5) NOT NULL,
					  conf_start_zoom varchar(5) NOT NULL,
					  conf_center_lat varchar(20) NOT NULL,
					  conf_center_lng varchar(20) NOT NULL,
					  conf_parameter text NOT NULL,
					  UNIQUE KEY id (id)
						)";
			$db->setQuery($query);
			$db->Query();
		/////////////Erstellen der neuen HTML Tabelle/////////////////
			$query = "CREATE TABLE #__gm_text_bak (
					  	id int( 5 ) NOT NULL AUTO_INCREMENT ,
						id_map int( 5 ) NOT NULL ,
						text_text text NOT NULL ,
						text_lat varchar( 20 ) NOT NULL ,
						text_lng varchar( 20 ) NOT NULL ,
						text_parameter text NOT NULL,
						access_group int(2) NOT NULL,
						PRIMARY KEY (id)
						)";
			$db->setQuery($query);
			$db->Query();
		/////////////Erstellen der neuen Kreis Tabelle/////////////////
			$query = "CREATE TABLE #__gm_circle_bak (
					id int( 11 ) NOT NULL AUTO_INCREMENT ,
					id_map int( 3 ) NOT NULL ,
					circle_position1_lat varchar( 20 ) NOT NULL ,
					circle_position1_lng varchar( 20 ) NOT NULL ,
					circle_radius int( 20 ) NOT NULL ,
					circle_farbe_linie varchar( 10 ) NOT NULL ,
					circle_linie_breite int( 2 ) NOT NULL ,
					circle_transparent_linie varchar( 5 ) NOT NULL ,
					circle_farbe_fuellung varchar( 10 ) NOT NULL ,
					circle_transparent_fuellung varchar( 5 ) NOT NULL ,
					circle_parameter text NOT NULL,
					circle_beschreibung text NOT NULL,
					access_group int(2) NOT NULL,
					PRIMARY KEY (id)
						)";
			$db->setQuery($query);
			$db->Query();
			$query = "CREATE TABLE #__gm_rectangle_bak (
					id int( 11 ) NOT NULL AUTO_INCREMENT ,
					id_map int( 3 ) NOT NULL ,
					rectangle_position1_lat varchar( 20 ) NOT NULL ,
					rectangle_position1_lng varchar( 20 ) NOT NULL ,
					rectangle_position2_lat varchar( 20 ) NOT NULL ,
					rectangle_position2_lng varchar( 20 ) NOT NULL ,
					rectangle_farbe_linie varchar( 10 ) NOT NULL ,
					rectangle_linie_breite int( 2 ) NOT NULL ,
					rectangle_transparent_linie varchar( 5 ) NOT NULL ,
					rectangle_farbe_fuellung varchar( 10 ) NOT NULL ,
					rectangle_transparent_fuellung varchar( 5 ) NOT NULL ,
					rectangle_parameter text NOT NULL,
					rectangle_beschreibung text NOT NULL,
					access_group int(2) NOT NULL,
					PRIMARY KEY (id)
						)";
			$db->setQuery($query);
			$db->Query();
		/////////////Erstellen der neuen Linien Tabelle/////////////////
			$query = "CREATE TABLE #__gm_line_bak (
					id int( 11 ) NOT NULL AUTO_INCREMENT ,
					id_map int( 3 ) NOT NULL ,
					line_titel varchar( 100 ) NOT NULL ,
					line_breite int( 2 ) NOT NULL ,
					line_farbe varchar( 10 ) NOT NULL ,
					line_transparent varchar( 3 ) NOT NULL ,
					line_punkte text NOT NULL ,
					line_parameter text NOT NULL,
					line_beschreibung text NOT NULL,
					access_group int(2) NOT NULL,
					PRIMARY KEY (id)
						)";
			$db->setQuery($query);
			$db->Query();
		/////////////Erstellen der neuen Polygon Tabelle/////////////////
			$query = "CREATE TABLE #__gm_polygon_bak (
					 id int(11) NOT NULL AUTO_INCREMENT,
					 id_map int(10) NOT NULL,
					 polygon_titel varchar(100) NOT NULL,
					 polygon_color_line varchar(10) NOT NULL,
					 polygon_width_line varchar(2) NOT NULL,
					 polygon_transparent_line varchar(5) NOT NULL,
					 polygon_color_fill varchar(10) NOT NULL,
					 polygon_transparent_fill varchar(5) NOT NULL,
					 polygon_path text NOT NULL,
					 polygon_parameter text NOT NULL,
					 polygon_beschreibung text NOT NULL,
					 access_group int(2) NOT NULL,
					PRIMARY KEY (id)
						)";
			$db->setQuery($query);
			$db->Query();
		/////////////Erstellen der neuen KML Tabelle/////////////////
			$query = "CREATE TABLE #__gm_kml_bak (
					id int(5) NOT NULL AUTO_INCREMENT,
					kml_title varchar(100) NOT NULL,
					kml_pfad varchar(200) NOT NULL,
					kml_beschreibung text NOT NULL,
					kml_parameter text NOT NULL,
					PRIMARY KEY (id)
						)";
			$db->setQuery($query);
			$db->Query();
		foreach($array as $table){
			$query = "INSERT INTO #__".$table."_bak SELECT * FROM #__".$table."";
			$db->setQuery($query);
 			$db->Query();
			}
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = '.$db->quote('com_gmap'));
		$manifest = json_decode( $db->loadResult(), true );
		$version= $manifest[ 'version' ];
		$backup_info = 'backup_info|'.JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_INFO_MSG_1' );	
		$backup_info .= $version;
		$backup_info .= JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_INFO_MSG_2' );
		$backup_info .= date("j F, Y, H:i:s a"); 	
		$query = "UPDATE #__gm_config_bak SET conf_parameter = CONCAT(conf_parameter, ';', '$backup_info') WHERE id='1'";
		$db->setQuery($query);
		$db->Query();
		$version_info .= 'version|'.$version; 	
		$query = "UPDATE #__gm_config_bak SET conf_parameter = CONCAT(conf_parameter, ';', '$version_info') WHERE id='1'";
		$db->setQuery($query);
		$db->Query();
   }

public function getRestoreBackup(){
	
		$db = JFactory::getDbo();
		$array = array('gm_config',
						'gm_map',
						'gm_marker',
						'gm_lang',
						'gm_circle',
						'gm_rectangle',
						'gm_text',
						'gm_line',
						'gm_polygon',
						'gm_kml'
						);	

		foreach($array as $table){
			$query = "TRUNCATE #__".$table."";
			$db->setQuery($query);
 			$db->Query();
			
			$query = "INSERT INTO #__".$table." SELECT * FROM #__".$table."_bak";
			$db->setQuery($query);
 			$db->Query();
			}
		$query = "UPDATE #__gm_config SET conf_parameter = '' WHERE id='1'";
		$db->setQuery($query);
		$db->Query();
		
}

public function getBackupInfo()
{
	$db = JFactory::getDBO();
	$tables = JFactory::getDbo()->getTableList();
	$backup_table = $db->getPrefix().'gm_config_bak';
	for ($i=0, $n=count( $tables ); $i < $n; $i++){
		$item = $tables[$i];
		if ($item == $backup_table){
			$query = "SELECT * FROM #__gm_config_bak WHERE id = '1'";
			$db->setQuery($query);
			$item = $db->loadObject();
			$teile = explode(";", $item->conf_parameter);
				for ($a=0, $b=count( $teile ); $a < $b; $a++){
					$parameter = explode("|", $teile[$a]);
					@$array[$parameter[0]] = $parameter[1];
				}
			$array['backup_import'] = '0';	
			if (version_compare($array['version'], '4.2', '>=')){
				(object) $array;
				return $array;
			}
			unset ($array['backup_info']);
			(object) $array;
			return $array;
			}
	}
	return false;
}

	
}
?>