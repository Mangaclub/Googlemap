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
$a=1;

	
$response = $this->lang;
$html = "
<div id='map_option_list_1' >
<ul class='map_option_list_1'>
<li class='button_option road option_off' id='map_option_roadmap' onclick='setmapview.maptyp(\"roadmap\")'><span class='option_text'>".$response->lang_map_view_roadmap."</span></li>
<li class='button_option terrain option_off' id='map_option_terrain' onclick='setmapview.maptyp(\"terrain\")'><span class='option_text'>".$response->lang_map_view_terrain."</span></li>
<li class='button_option satellite option_off' id='map_option_satellite' onclick='setmapview.maptyp(\"satellite\")'><span class='option_text'>".$response->lang_map_view_satellite."</span></li>
<li class='button_option hybrid option_off' id='map_option_hybrid' onclick='setmapview.maptyp(\"hybrid\")'><span class='option_text'>".$response->lang_map_view_hybrid."</span></li>
<li class='button_option osm option_off' id='map_option_osm' onclick='setmapview.maptyp(\"osm\")'><span class='option_text'>OpenStreetMap</span></li>
</ul>
</div>
<hr / class='option_list_teiler'>
<div id='map_option_list_2' >
<ul class='map_option_list'>
<li class='button_option bike option_off' id='map_layer_bike' onclick='setmapview.map_bike_layer()'><span class='option_text'>
".$response->lang_layer_bike."</span></li>
<li class='button_option traffic option_off' id='map_layer_traffic' onclick='setmapview.map_traffic_layer()'><span class='option_text'>
".$response->lang_layer_traffic."</span></li>
<li class='button_option transit option_off' id='map_layer_transit' onclick='setmapview.map_transit_layer()'><span class='option_text'>
".$response->lang_layer_transit."</span></li>
<li class='button_option street_view option_off' id='map_layer_streetview' onclick='setmapview.map_streetview_layer()'><span class='option_text'>".$response->lang_layer_streetview."</span></li>
</ul>
</div>
<div class='mylogo'><a id='logo_button' target='new' href='http://www.joomla-24.de'>Powered by joomla-24.de</a></div>

"
;
$response->map_button_html = $html;


    require_once( JPATH_COMPONENT.DS.'helpers'.DS.'json.php' );
   $json = new Services_JSON();
   echo $json->encode( $response );