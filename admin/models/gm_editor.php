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
class GmapModelgm_editor extends JModelAdmin
{

	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return JFactory::getUser()->authorise('core.edit', 'com_gmap.message.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}

	public function getTable($type = 'gm_editor', $prefix = 'GmapTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_gmap.gm_editor', 'gm_editor', array('control' => 'jform', 'load_data' => $loadData));

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
		$data = JFactory::getApplication()->getUserState('com_gmap.edit.gm_editor.data', array());

		if (empty($data)){
			$data = $this->getItem();
			$teile = explode(",", $data->map_parameter);
			if (count( $teile ) > '1'){
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$data->{$parameter[0]} = $parameter[1];
			}}
			
			$teile = explode(",", $data->street_view_parameter);
			if (count( $teile ) > '1'){
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$data->{$parameter[0]} = $parameter[1];
			}}
			
		};

	return $data;
	}
	
	public function getConfig ()
	{
		$item = $this->getTable('gm_config');
		$item->load(1);
		return $item;
	}
	public function getAjaxData()
	{
		$id = JRequest::getVar('id');
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__gm_map WHERE id = '$id'";
		$db->setQuery( $query );
		$item = $db->loadObject();
		return $item;
	}
	public function getAjaxDataMarker()
	{	$db = JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$query = "SELECT * FROM #__gm_marker WHERE id_map= '$id' ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		}
	public function getAjaxDataRectangle()
	{	$db = JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$query = "SELECT * FROM #__gm_rectangle WHERE id_map= '$id' ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		}
	public function getAjaxDataCircle()
	{	$db = JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$query = "SELECT * FROM #__gm_circle WHERE id_map= '$id' ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		}
	public function getAjaxDataLine()
	{	$db = JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$query = "SELECT * FROM #__gm_line WHERE id_map= '$id' ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		}
	public function getAjaxDataPolygon()
	{	$db = JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$query = "SELECT * FROM #__gm_polygon WHERE id_map= '$id' ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		}
	public function getAjaxDataHtmlbox()
	{	$db = JFactory::getDBO();
		$id = JRequest::getVar('cid');
		$query = "SELECT * FROM #__gm_text WHERE id_map= '$id' ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		
		}	
	public function getAjaxDataKml()
	{	$db = JFactory::getDBO();
		$query = "SELECT * FROM #__gm_kml ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		
		}	
		
	public function getAjaxLineStyle()
	{	$db = JFactory::getDBO();
		$query = "SELECT * FROM #__gm_line_style ORDER BY id ASC";
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		}	
		
	public function getAjaxDataImportKml()
	{	$xmlfile= JPATH_SITE .'/administrator/components/com_gmap/assets/js/sample.xml';
		$xml = JFactory::getXML($xmlfile);
		if ($xml) {
			$coordinates = (string)$xml->Document->Placemark->MultiGeometry->LineString->coordinates;
			$coordinates = str_replace("\n", "|", $coordinates);
			$teile = explode("|", $coordinates);
				for ($a=0, $b=count( $teile ); $a < $b; $a++){
					$coordinate = explode(",", $teile[$a]);
					$coordinaten['coordinaten'] .=$coordinate[0].','.$coordinate[1].'|';
				}
				$data = (object)$coordinaten;
		   return $data;
		   
		 }
		 else {
		   $error_msg = "File Open Error: file " . $xmlfile;
		   echo $error_msg;
		}
	}	


	public function save_map() {
		$db	= JFactory::getDBO();
		$map_center_lat = JRequest::getVar('map_center_lat');
		$map_center_lng = JRequest::getVar('map_center_lng');
		$map_zoom=JRequest::getVar('map_zoom');
		$map_parameter=JRequest::getVar('map_parameter');
		$street_view_parameter=JRequest::getVar('street_view_parameter');
		$id=JRequest::getVar('id');
		if ($id > '0'){
		$query = "UPDATE #__gm_map SET map_center_lat='$map_center_lat',map_center_lng='$map_center_lng',map_zoom='$map_zoom',map_parameter='$map_parameter',street_view_parameter='$street_view_parameter' WHERE id='$id'";
		}
		$db->setQuery($query);
		$db->Query();
		return true;
	}
	 function save_marker() {	
		$dba	= JFactory::getDBO();
		$marker_titel= str_replace("'","''",JRequest::getVar('marker_titel'));
		$marker_strasse=str_replace("'","''",JRequest::getVar('marker_strasse'));
		$marker_ort=str_replace("'","''",JRequest::getVar('marker_ort'));
		$marker_plz=str_replace("'","''",JRequest::getVar('marker_plz'));
		$marker_beschreibung = str_replace("'","''",JRequest::getVar( 'marker_beschreibung', '', 'text', 'string', JREQUEST_ALLOWRAW ));
		$marker_icon=JRequest::getVar('marker_icon');
		$marker_lng=JRequest::getVar('marker_lng');
		$marker_lat=JRequest::getVar('marker_lat');
		$marker_id=JRequest::getVar('marker_id');
		$marker_status=JRequest::getVar('marker_status');
		$marker_new=JRequest::getVar('marker_new');
		$id_map=JRequest::getVar('id_map');
		$marker_parameter=str_replace("'","''",JRequest::getVar('marker_parameter'));
		$access_group=JRequest::getVar('access_group');
		$query = "update #__gm_marker SET 
										marker_titel='$marker_titel', 
										marker_strasse='$marker_strasse', 
										marker_ort='$marker_ort',
										marker_plz='$marker_plz',
										marker_beschreibung='$marker_beschreibung',
										marker_icon='$marker_icon',
										marker_lng='$marker_lng', 
										marker_lat='$marker_lat',
										marker_parameter='$marker_parameter',
										access_group='$access_group' 
										WHERE id='$marker_id'  ";
		//}
		if ($marker_new == 'yes'){
		$query = "insert into #__gm_marker (id, id_map, marker_titel, marker_strasse, marker_ort, marker_plz, marker_beschreibung, marker_icon, marker_lng, marker_lat, marker_parameter, access_group) VALUES ('','$id_map','$marker_titel','$marker_strasse','$marker_ort','$marker_plz','$marker_beschreibung','$marker_icon','$marker_lng','$marker_lat','$marker_parameter','$access_group') ";
		};
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}	
	public function save_rectangle() {
		$dba	= JFactory::getDBO();
		$rectangle_position1_lat=JRequest::getVar('rectangle_position1_lat');
		$rectangle_position1_lng=JRequest::getVar('rectangle_position1_lng');
		$rectangle_position2_lat=JRequest::getVar('rectangle_position2_lat');
		$rectangle_position2_lng=JRequest::getVar('rectangle_position2_lng');
		$rectangle_farbe_linie=JRequest::getVar('rectangle_farbe_linie');
		$rectangle_linie_breite=JRequest::getVar('rectangle_linie_breite');
		$rectangle_transparent_linie=JRequest::getVar('rectangle_transparent_linie');
		$rectangle_beschreibung = str_replace("'","''",JRequest::getVar( 'rectangle_beschreibung', '', 'text', 'string', JREQUEST_ALLOWRAW ));
		$rectangle_farbe_fuellung=JRequest::getVar('rectangle_farbe_fuellung');
		$rectangle_transparent_fuellung=JRequest::getVar('rectangle_transparent_fuellung');
		$rectangle_id=JRequest::getVar('rectangle_id');
		$rectangle_new=JRequest::getVar('rectangle_new');
		$rectangle_parameter=str_replace("'","''",JRequest::getVar('rectangle_parameter'));
		$access_group=JRequest::getVar('access_group');
		$id_map=JRequest::getVar('id_map');
		$query = "update #__gm_rectangle SET 
										rectangle_position1_lat='$rectangle_position1_lat', 
										rectangle_position1_lng='$rectangle_position1_lng', 
										rectangle_position2_lat='$rectangle_position2_lat', 
										rectangle_position2_lng='$rectangle_position2_lng', 
										rectangle_farbe_linie='$rectangle_farbe_linie',
										rectangle_linie_breite='$rectangle_linie_breite',
										rectangle_transparent_linie='$rectangle_transparent_linie',
										rectangle_farbe_fuellung='$rectangle_farbe_fuellung',
										rectangle_transparent_fuellung='$rectangle_transparent_fuellung',
										rectangle_parameter='$rectangle_parameter',
										rectangle_beschreibung='$rectangle_beschreibung',
										access_group='$access_group' 
										WHERE id='$rectangle_id'  ";
		//}
		if ($rectangle_new == 'yes'){
		
		$query = "insert into #__gm_rectangle (id, id_map, rectangle_position1_lat, rectangle_position1_lng, rectangle_position2_lat, rectangle_position2_lng, rectangle_farbe_linie, rectangle_linie_breite, rectangle_transparent_linie, rectangle_farbe_fuellung, rectangle_transparent_fuellung, rectangle_parameter, rectangle_beschreibung, access_group) VALUES ('','$id_map','$rectangle_position1_lat','$rectangle_position1_lng','$rectangle_position2_lat','$rectangle_position2_lng','$rectangle_farbe_linie','$rectangle_linie_breite','$rectangle_transparent_linie','$rectangle_farbe_fuellung','$rectangle_transparent_fuellung','$rectangle_parameter','$rectangle_beschreibung','$access_group') ";
		};
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}	

	 public function save_circle() {	
		$dba	= JFactory::getDBO();
		$circle_marker_lat=JRequest::getVar('circle_marker_lat');
		$circle_marker_lng=JRequest::getVar('circle_marker_lng');
		$circle_radius=JRequest::getVar('circle_radius');
		$circle_farbe_linie=JRequest::getVar('circle_farbe_linie');
		$circle_linie_breite=JRequest::getVar('circle_linie_breite');
		$circle_transparent_linie=JRequest::getVar('circle_transparent_linie');
		$circle_farbe_fuellung=JRequest::getVar('circle_farbe_fuellung');
		$circle_transparent_fuellung=JRequest::getVar('circle_transparent_fuellung');
		$circle_beschreibung = str_replace("'","''",JRequest::getVar( 'circle_beschreibung', '', 'text', 'string', JREQUEST_ALLOWRAW ));
		$circle_id=JRequest::getVar('circle_id');
		$circle_new=JRequest::getVar('circle_new');
		$id_map=JRequest::getVar('id_map');
		$circle_parameter=str_replace("'","''",JRequest::getVar('circle_parameter'));
		$access_group=JRequest::getVar('access_group');
		$query = "update #__gm_circle SET 
										circle_position1_lat='$circle_marker_lat', 
										circle_position1_lng='$circle_marker_lng', 
										circle_radius='$circle_radius', 
										circle_farbe_linie='$circle_farbe_linie',
										circle_linie_breite='$circle_linie_breite',
										circle_transparent_linie='$circle_transparent_linie',
										circle_farbe_fuellung='$circle_farbe_fuellung',
										circle_transparent_fuellung='$circle_transparent_fuellung',
										circle_parameter='$circle_parameter',
										circle_beschreibung='$circle_beschreibung',
										access_group='$access_group' 
										WHERE id='$circle_id'  ";
		//}
		if ($circle_new == 'yes'){
		
		$query = "insert into #__gm_circle (id, id_map, circle_position1_lat, circle_position1_lng, circle_radius, circle_farbe_linie, circle_linie_breite, circle_transparent_linie, circle_farbe_fuellung, circle_transparent_fuellung, circle_parameter, circle_beschreibung, access_group) VALUES ('','$id_map','$circle_marker_lat','$circle_marker_lng','$circle_radius','$circle_farbe_linie','$circle_linie_breite','$circle_transparent_linie','$circle_farbe_fuellung','$circle_transparent_fuellung','$circle_parameter','$circle_beschreibung','$access_group') ";
		};
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}
	public  function save_line() {	
		$dba	= JFactory::getDBO();
		$line_titel=str_replace("'","''",JRequest::getVar('line_titel'));
		$line_farbe=JRequest::getVar('line_farbe');
		$line_breite=JRequest::getVar('line_breite');
		$line_transparent=JRequest::getVar('line_transparent');
		$line_punkte=JRequest::getVar('line_punkte');
		$line_parameter=JRequest::getVar('line_parameter');
		$line_id=JRequest::getVar('line_id');
		$line_new=JRequest::getVar('line_new');
		$id_map=JRequest::getVar('id_map');
		$access_group=JRequest::getVar('access_group');
		$line_beschreibung = str_replace("'","''",JRequest::getVar( 'line_beschreibung', '', 'text', 'string', JREQUEST_ALLOWRAW ));
		$query = "update #__gm_line SET 
										line_titel='$line_titel', 
										line_farbe='$line_farbe', 
										line_breite='$line_breite', 
										line_transparent='$line_transparent',
										line_punkte='$line_punkte',
										line_parameter='$line_parameter',
										line_beschreibung='$line_beschreibung',
										access_group='$access_group' 
										WHERE id='$line_id'  ";
		//}
		if ($line_new == 'yes'){
		
		$query = "insert into #__gm_line (id, id_map, line_titel, line_farbe, line_breite, line_transparent, line_punkte, line_parameter, line_beschreibung, access_group) VALUES ('','$id_map','$line_titel','$line_farbe','$line_breite','$line_transparent','$line_punkte', '$line_parameter', '$line_beschreibung','$access_group') ";
		};
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}	
	public  function save_polygon() {	
		$dba	= JFactory::getDBO();
		$polygon_titel=str_replace("'","''",JRequest::getVar('polygon_titel'));
		$polygon_color_line=JRequest::getVar('polygon_color_line');
		$polygon_width_line=JRequest::getVar('polygon_width_line');
		$polygon_transparent_line=JRequest::getVar('polygon_transparent_line');
		$polygon_color_fill=JRequest::getVar('polygon_color_fill');
		$polygon_transparent_fill=JRequest::getVar('polygon_transparent_fill');
		$polygon_path=JRequest::getVar('polygon_path');
		$polygon_parameter=JRequest::getVar('polygon_parameter');
		$polygon_new=JRequest::getVar('polygon_new');
		$polygon_id=JRequest::getVar('polygon_id');
		$id_map=JRequest::getVar('id_map');
		$access_group=JRequest::getVar('access_group');
		$polygon_beschreibung = str_replace("'","''",JRequest::getVar( 'polygon_beschreibung', '', 'text', 'string', JREQUEST_ALLOWRAW ));
		$query = "update #__gm_polygon SET 
										polygon_titel='$polygon_titel', 
										polygon_color_line='$polygon_color_line', 
										polygon_width_line='$polygon_width_line', 
										polygon_transparent_line='$polygon_transparent_line',
										polygon_color_fill='$polygon_color_fill',
										polygon_transparent_fill='$polygon_transparent_fill',
										polygon_path='$polygon_path',
										polygon_parameter='$polygon_parameter',
										polygon_beschreibung='$polygon_beschreibung',
										access_group='$access_group'
										WHERE id='$polygon_id'  ";
		//}
		if ($polygon_new == 'yes'){
		
		$query = "insert into #__gm_polygon (id, id_map, polygon_titel, polygon_color_line, polygon_width_line, polygon_transparent_line, polygon_color_fill, polygon_transparent_fill, polygon_path, polygon_parameter, polygon_beschreibung, access_group) VALUES ('','$id_map','$polygon_titel','$polygon_color_line','$polygon_width_line','$polygon_transparent_line','$polygon_color_fill', '$polygon_transparent_fill', '$polygon_path', '$polygon_parameter', '$polygon_beschreibung','$access_group') ";
		};
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}	
	
	 public function save_htmlbox() {	
		$dba	= JFactory::getDBO();
		$text_text=str_replace("'","''",JRequest::getVar( 'text_text', '', 'text', 'string', JREQUEST_ALLOWRAW ));
		$text_lat=JRequest::getVar('text_lat');
		$text_lng=JRequest::getVar('text_lng');
		$text_id=JRequest::getVar('text_id');
		$text_new=JRequest::getVar('text_new');
		$id_map=JRequest::getVar('id_map');
		$text_parameter=JRequest::getVar('text_parameter');
		$access_group=JRequest::getVar('access_group');
		$query = "update #__gm_text SET 
										text_text='$text_text', 
										text_lat='$text_lat', 
										text_lng='$text_lng',
										text_parameter='$text_parameter',
										access_group='$access_group'
										WHERE id='$text_id'  ";
		//}
		if ($text_new == 'yes'){
		
		$query = "insert into #__gm_text (id, id_map, text_text, text_lat, text_lng, text_parameter,access_group) VALUES ('','$id_map','$text_text','$text_lat','$text_lng','$text_parameter','$access_group') ";
		};
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}	
	public function remove_marker ()
	{
		$dba	= JFactory::getDBO();
		$id=JRequest::getVar('id');
		$query = "delete from #__gm_marker WHERE id='$id' ";
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}
	public function remove_circle ()
	{
		$dba	= JFactory::getDBO();
		$id=JRequest::getVar('id');
		$query = "delete from #__gm_circle WHERE id='$id' ";
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}
	public function remove_rectangle ()
	{
		$dba	= JFactory::getDBO();
		$id=JRequest::getVar('id');
		$query = "delete from #__gm_rectangle WHERE id='$id' ";
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}
	public function remove_line ()
	{
		$dba	= JFactory::getDBO();
		$id=JRequest::getVar('id');
		$query = "delete from #__gm_line WHERE id='$id' ";
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}
	public function remove_polygon ()
	{
		$dba	= JFactory::getDBO();
		$id=JRequest::getVar('id');
		$query = "delete from #__gm_polygon WHERE id='$id' ";
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}
	public function remove_htmlbox ()
	{
		$dba	= JFactory::getDBO();
		$id=JRequest::getVar('id');
		$query = "delete from #__gm_text WHERE id='$id' ";
		$dba->setQuery($query);
		$dba->Query();
		return true;
	}
}

?>