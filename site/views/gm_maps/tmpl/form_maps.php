<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/
//-- No direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.language.language' );

$a=1;

	
		$row = $this->maps;
			$teile = explode(",", $row->map_parameter);
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$parameter[0]] = $parameter[1];
			}
			$teile = explode(",", $row->street_view_parameter);
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$parameter[0]] = $parameter[1];
			}
		$response['map_id'] = $row->id;
		$response['map_center_lat'] = $row->map_center_lat;
		$response['map_center_lng'] = $row->map_center_lng;
		$response['map_zoom'] = $row->map_zoom;
		$lang = $response['map_language'];

		if ($response['map_language'] == 'auto'){
			$lang = JFactory::getLanguage();
			$teile = explode("-", $lang->getTag());
			$lang =$teile[0];
			}
			
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__gm_lang WHERE lang_short = '$lang'";
		$db->setQuery( $query );
		$lang_item = $db->loadObject();
		if ($lang_item == ''){
			$lang ='en';
			$query = "SELECT * FROM #__gm_lang WHERE lang_short = '$lang'";
			$db->setQuery( $query );
			$lang_item = $db->loadObject();
			}
		$id= $response['map_id'];
$html = "
<div id='map_option_list_1_".$id."' >
<ul class='map_option_list_1'>
<li class='button_option road option_off' id='map_option_roadmap_".$id."' onclick='setmapview.maptyp(\"roadmap\",".$id.")'><span class='option_text'>".$lang_item->lang_map_view_roadmap."</span></li>
<li class='button_option terrain option_off' id='map_option_terrain_".$id."' onclick='setmapview.maptyp(\"terrain\",".$id.")'><span class='option_text'>".$lang_item->lang_map_view_terrain."</span></li>
<li class='button_option satellite option_off' id='map_option_satellite_".$id."' onclick='setmapview.maptyp(\"satellite\",".$id.")'><span class='option_text'>".$lang_item->lang_map_view_satellite."</span></li>
<li class='button_option hybrid option_off' id='map_option_hybrid_".$id."' onclick='setmapview.maptyp(\"hybrid\",".$id.")'><span class='option_text'>".$lang_item->lang_map_view_hybrid."</span></li>
<li class='button_option osm option_off' id='map_option_osm_".$id."' onclick='setmapview.maptyp(\"osm\",".$id.")'><span class='option_text'>OpenStreetMap</span></li>
</ul>
</div>
<hr / class='option_list_teiler'>
<div id='map_option_list_2_".$id."' >
<ul class='map_option_list'>
<li class='button_option bike option_off' id='map_layer_bike_".$id."' onclick='setmapview.bike(".$id.")'><span class='option_text'>
".$lang_item->lang_layer_bike."</span></li>
<li class='button_option traffic option_off' id='map_layer_traffic_".$id."' onclick='setmapview.traffic(".$id.")'><span class='option_text'>
".$lang_item->lang_layer_traffic."</span></li>
<li class='button_option transit option_off' id='map_layer_transit_".$id."' onclick='setmapview.transit(".$id.")'><span class='option_text'>
".$lang_item->lang_layer_transit."</span></li>
<li class='button_option street_view option_off' id='map_layer_streetview_".$id."' onclick='setmapview.streetview(".$id.")'><span class='option_text'>".$lang_item->lang_layer_streetview."</span></li>
</ul>
</div>
</div>
<div class='mylogo'><a id='logo_button' target='new' href='http://www.joomla-24.de'>Powered by joomla-24.de</a></div>"
;

$response['setup_button_html'] = $html;
	
    require_once( JPATH_COMPONENT.'/helpers/json.php' );
   $json = new Services_JSON();
   echo $json->encode( $response );