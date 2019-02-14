var id;
var lang;
var marker= new Array();
var dummy_marker= new Array();
var box_dummy_marker= new Array();
var infowindow;
var oldmarker;
var oldline;
var rectangle= new Array();
var drawingManager;
var cmenue= new Array();
var circle= new Array();
var boxmarker= new Array();
var box= new Array();
var line= new Array();
var linedummy= new Array();
var first;
var linemarker = new Array();
var linepoints = new Array();
var elevator;
var chart;
var oldlinepoints = new Array();
var oldlinemarker = new Array();
var oldpoints = new Array();
var streetview_layer;
var bike_layer;
var traffic_layer;
var transit_layer;
var morebutton;
var map;
var maplang = new Array();
var map_default_option;
var map_saved_option;
var polygon= new Array();
var polygonmarker = new Array();
var kmllayer= new Array();
var markercluster;
var import_xml;
var import_line = new Array();
var import_polygon = new Array();
var import_marker_point = new Array();
var place;
var autocomplete;
var linestyle= new Array();

function save_map() {
  	   	var siteurl= URIBase + "administrator/index.php?option=com_gmap&task=gm_editor.save_map";
  	    var map_center_lat = jQuery('#jform_map_center_lat').val();
  	    var map_center_lng = jQuery('#jform_map_center_lng').val();
		var map_zoom = jQuery('#jform_map_zoom').val();
		var id = jQuery('#map_id').val();
		var map_parameter = 'map_minzoom:' + jQuery('#jform_map_minzoom').val();
			map_parameter +=',map_maxzoom:' + jQuery('#jform_map_maxzoom').val();
			map_parameter +=',map_maptype:' + getSelectedValue('adminForm', 'jform_map_maptype');
			map_parameter +=',map_satellite_view_45:' + radioGetCheckedValue('jform_map_satellite_view_45');
			map_parameter +=',map_satellite_view_45_heading:' + getSelectedValue('adminForm', 'jform_map_satellite_view_45_heading');
			map_parameter +=',map_draggable:' + radioGetCheckedValue('jform_map_draggable');
			map_parameter +=',map_DoubleClickZoom:' + radioGetCheckedValue('jform_map_DoubleClickZoom');
			map_parameter +=',map_scrollwheel:' + radioGetCheckedValue('jform_map_scrollwheel');
			map_parameter +=',map_panControl:' + radioGetCheckedValue('jform_map_panControl');
			map_parameter +=',map_zoomControl:' + radioGetCheckedValue('jform_map_zoomControl');
			map_parameter +=',map_ZoomControlStyle:' + getSelectedValue('adminForm', 'jform_map_ZoomControlStyle');
			map_parameter +=',map_scaleControl:' + radioGetCheckedValue('jform_map_scaleControl');
    		map_parameter +=',map_bike_layer:' + radioGetCheckedValue('jform_map_bike_layer');
    		map_parameter +=',map_traffic_layer:' + radioGetCheckedValue('jform_map_traffic_layer');
			map_parameter +=',map_transit_layer:' + radioGetCheckedValue('jform_map_transit_layer');
    		map_parameter +=',map_overview_map:' + radioGetCheckedValue('jform_map_overview_map');
    		map_parameter +=',map_overview_map_open:' + radioGetCheckedValue('jform_map_overview_map_open');
    		map_parameter +=',map_language:' + getSelectedValue('adminForm', 'jform_map_language');
    		map_parameter +=',custom_map_language:' + jQuery('#jform_custom_map_language').val();
    		map_parameter +=',map_setup_button:' + radioGetCheckedValue('jform_map_setup_button');
    		map_parameter +=',map_typ_control_button:' + radioGetCheckedValue('jform_map_typ_control_button');
    		map_parameter +=',map_layer_button:' + radioGetCheckedValue('jform_map_layer_button');
			map_parameter +=',map_width:' + jQuery('#map_container').width();
			map_parameter +=',map_height:' + jQuery('#map_container').height();
			map_parameter +=',marker_cluster_activ:' + radioGetCheckedValue('jform_marker_cluster_activ');
			map_parameter +=',marker_cluster_grid_size:' +getSelectedValue('adminForm', 'jform_marker_cluster_grid_size');
			map_parameter +=',map_folder_cluster_icon:' + map.folder_cluster_icon;
			map_parameter +=',map_cluster_icon:' + map.cluster_icon;
			map_parameter +=',marker_cluster_info_window:' + radioGetCheckedValue('jform_marker_cluster_info_window');
			map_parameter +=',kml_files:' + controlerKml.returnSelectedKmlFiles();
		var	street_view_parameter ='streetViewControl:' + radioGetCheckedValue('jform_streetViewControl');
			street_view_parameter +=',street_view_activ:' + radioGetCheckedValue('jform_street_view_activ');
			street_view_parameter +=',street_view_center_lat:' + jQuery('#jform_street_view_center_lat').val();
			street_view_parameter +=',street_view_center_lng:' + jQuery('#jform_street_view_center_lng').val();
			street_view_parameter +=',street_view_pitch:' + jQuery('#jform_street_view_pitch').val();
			street_view_parameter +=',street_view_heading:' + jQuery('#jform_street_view_heading').val();
			street_view_parameter +=',street_view_zoom:' + jQuery('#jform_street_view_zoom').val();
  	jQuery.ajax({
			url		: siteurl,
			type: "POST",
			data: { 'map_center_lat': map_center_lat,
					'map_center_lng': map_center_lng,
					'map_zoom': map_zoom,
					'map_parameter': map_parameter,
					'street_view_parameter': street_view_parameter,
					'id': id,
					},
			 success: function() {main.SaveProgress(14);}
        });
	
    }
function getlang (View, Layout, Format, Ziel, Lang) {
	var siteurl=URIBase+"administrator/index.php?option=com_gmap&view="+View+"&tmpl=component&layout="+Layout+"&format="+Format+"&lang="+Lang;	
	var cid = document.getElementById('map_id').value;
	var Id =document.getElementById('map_id').value;
	jQuery.ajax({
		   	url:	siteurl,
			type: "GET",
			async: false,
			cache:false, 
			data: { 'cid': cid,
					'id': Id
					},
			dataType:"json",
            success: function(response) {
					var resp=response;
					  maplang = new Array();
							maplang['lang_button_title'] 		= resp.lang_button_title;
							maplang['lang_slider_map_view'] 	= resp.lang_slider_map_view;
							maplang['lang_map_view_roadmap'] 	= resp.lang_map_view_roadmap;
							maplang['lang_map_view_terrain'] 	= resp.lang_map_view_terrain;
							maplang['lang_map_view_satellite']	= resp.lang_map_view_satellite;
							maplang['lang_map_view_hybrid'] 	= resp.lang_map_view_hybrid;
							maplang['lang_slider_layer'] 		= resp.lang_slider_layer;
							maplang['lang_layer_bike']			= resp.lang_layer_bike;
							maplang['lang_layer_traffic'] 		= resp.lang_layer_traffic;
							maplang['lang_layer_transit'] 		= resp.lang_layer_transit;
							maplang['lang_layer_streetview'] 	= resp.lang_layer_streetview;
							maplang['map_button_html'] 			= resp.map_button_html;
        
			}
		});
}
function getLineStyle (View, Layout, Format) {
	var siteurl=URIBase+"administrator/index.php?option=com_gmap&view="+View+"&tmpl=component&layout="+Layout+"&format="+Format;	
	jQuery.ajax({
		   	url:	siteurl,
			type: "GET",
			async: false,
			cache:false, 
			dataType:"json",
            success: function(style) {
					var style = style;
					linestyle = new Array();
					   if (style != null){
							for(var i = 0; i< style.length; i++) {
								linestyle[style[i].id] = {
								id:				style[i].id,
								title:			style[i].title,
								path:			style[i].path,
								anchor_x:		style[i].anchor_x,
								anchor_y :		style[i].anchor_y,
								fillColor :		style[i].fillColor,
								fillOpacity :	style[i].fillOpacity,
								strokeColor :	style[i].strokeColor,
								strokeWeight :	style[i].strokeWeight,
								strokeOpacity :	style[i].strokeOpacity,
								rotation :		style[i].rotation
								};
							
							}
					   }
			}
		});
}
function getdata (View, Layout, Format, Ziel, Lang) {
	var siteurl=URIBase+"administrator/index.php?option=com_gmap&view="+View+"&tmpl=component&layout="+Layout+"&format="+Format+"&lang="+Lang;	
	var cid = document.getElementById('map_id').value;
	var Id =document.getElementById('map_id').value;
	jQuery.ajax({
		   	url:	siteurl,
			type: "GET",
			async: true, 
			cache:false,
			data: { 'cid': cid,'id': Id},
			dataType:"json",
            success: function(response) {
				if (Ziel == 'getallrectangle') {
					 var resp=response;
					  rectangle = new Array();
					  if (response != null){
						for(var i = 0; i< resp.length; i++) {
							var posit1 =new google.maps.LatLng(resp[i].rectangle_position1_lat ,resp[i].rectangle_position1_lng );
							var posit2 =new google.maps.LatLng(resp[i].rectangle_position2_lat ,resp[i].rectangle_position2_lng );
							var posit3 = 'false';
							if (resp[i].firstinfofenster == null){
								resp[i].firstinfofenster = 'false';
							}
							if (resp[i].positinfowindowlat != '' && resp[i].positinfowindowlat != 'undefined' && resp[i].positinfowindowlat != null){
								posit3 =new google.maps.LatLng(resp[i].positinfowindowlat ,resp[i].positinfowindowlng );
							}
								var latLngBounds = new google.maps.LatLngBounds(posit2, posit1);
									rectangle[i] = new google.maps.Rectangle({
	      									  	map					:map,
												access_group		:resp[i].access_group,
												rectangle_id		:resp[i].rectangle_id,
												gmselected			:'false',
												status				:'standard',
												fillColor			:resp[i].rectangle_farbe_fuellung,
												fillOpacity			:resp[i].rectangle_transparent_fuellung,
												strokeColor			:resp[i].rectangle_farbe_linie,
												strokeOpacity		:resp[i].rectangle_transparent_linie,
												strokeWeight		:resp[i].rectangle_linie_breite,
												title				:resp[i].rectangle_title,
												rectangle_new		:'no',
												text				:resp[i].rectangle_beschreibung,
												firstinfofenster	:resp[i].firstinfofenster,
												positinfowindow		:posit3,
												positinfowindowlat	:resp[i].positinfowindowlat,
												positinfowindowlng	:resp[i].positinfowindowlng,
												oldtext				:resp[i].rectangle_beschreibung,
												oldBounds			:latLngBounds,
												oldfillColor		:resp[i].rectangle_farbe_fuellung,
												oldfillOpacity		:resp[i].rectangle_transparent_fuellung,
												oldstrokeColor		:resp[i].rectangle_farbe_linie,
												oldstrokeOpacity	:resp[i].rectangle_transparent_linie,
												oldstrokeWeight		:resp[i].rectangle_linie_breite,
											});
									rectangle[i].setBounds(latLngBounds);

						} //Ende for schleife
					  
					  initrectangle();
					  }progress(20,'#loadbar');
				}else if (Ziel == 'getallmarker') {//einlesen aller vorhandenen Marker für die entsp. Karte
					 var resp= response;
					  marker = new Array();
					   if (response != null){
					 	for(var i = 0; i< resp.length; i++) {
							if (resp[i].firstinfofenster == null){
								resp[i].firstinfofenster = 'false';
							}
							var geticon;
							var getshadow;
							if (resp[i].markericon != 'standard') {
								geticon = myicon(resp[i].markericon);
							}else{
								geticon = defaulticon();
							}
							var posit =new google.maps.LatLng(resp[i].markerlat ,resp[i].markerlng );
							 marker[i] = new google.maps.Marker({
											position		: posit,
											draggable		: true,
											map				: map,
											access_group		:resp[i].access_group,
											status 			: 'standard',
											gmselected 	: 'false',
											markernew 		: 'no',
											markerlat 		: resp[i].markerlat,
											marker_id 		: resp[i].markerid,
											markerlng 		: resp[i].markerlng,
											markerort 		: resp[i].markerort,
											markerplz 		: resp[i].markerplz,
											markericon 		: resp[i].markericon,
											markertitel 	: resp[i].markertitel,
											markerstrasse 	: resp[i].markerstrasse,
											text			 : resp[i].markerbeschreibung,
											firstinfofenster: resp[i].firstinfofenster,
											markermouseover	: resp[i].markermouseover,
											title			: resp[i].markermouseover,
											icon			: geticon,
											shadow			: getshadow, 
											oldmarkerposition: posit,
											oldtitle		: resp[i].markermouseover,
											oldmarkerlat 	: resp[i].markerlat,
											oldmarkerlng 	: resp[i].markerlng,
											oldmarkerort 	: resp[i].markerort,
											oldmarkerplz 	: resp[i].markerplz,
											oldmarkericon 	: resp[i].markericon,
											oldmarkertitel 	: resp[i].markertitel,
											oldmarkerstrasse : resp[i].markerstrasse,
											oldtext : resp[i].markerbeschreibung,
							});
							 dummy_marker[i] = new google.maps.Marker({
											position		: posit,
											draggable		: false,
											map				: map,
											icon		: mysystemicon('element_activ.png',15,26,7,7),
											visible: false,
							});
						} //Ende for schleife
					 initmarker();
					 controlerMarkerCluster.setClusterPassiv(); 
					 controlerMarkerCluster.setClusterActiv();
					   }progress(20,'#loadbar');
           		}else if (Ziel == 'getallcircle') {
					var resp=response;
					  circle = new Array();
					   if (response != null){
						for(var i = 0; i< resp.length; i++) {
							if (resp[i].firstinfofenster == null){
								resp[i].firstinfofenster = 'false';
							}
							var posit3 = 'false';
							if (resp[i].positinfowindowlat != '' && resp[i].positinfowindowlat != 'undefined' && resp[i].positinfowindowlat != null){
								posit3 =new google.maps.LatLng(resp[i].positinfowindowlat ,resp[i].positinfowindowlng );
							}
							var posit1 =new google.maps.LatLng(resp[i].circle_position1_lat ,resp[i].circle_position1_lng );
							circle[i] = new google.maps.Circle({
	      									  	map					:map,
												access_group		:resp[i].access_group,
												circle_id			:resp[i].circle_id,
												gmselected			:'false',
												status				:'standard',
												fillColor			:resp[i].circle_farbe_fuellung,
												fillOpacity			:resp[i].circle_transparent_fuellung,
												strokeColor			:resp[i].circle_farbe_linie,
												strokeOpacity		:resp[i].circle_transparent_linie,
												strokeWeight		:resp[i].circle_linie_breite,
												center				:posit1,
												text				:resp[i].circle_beschreibung,
												circlemarkerlat		:resp[i].circle_position1_lat,
												circlemarkerlng		:resp[i].circle_position1_lng,
												radius				:eval(resp[i].circle_radius),
												title				:resp[i].circle_title,
												circle_new			:'no',
												firstinfofenster	:resp[i].firstinfofenster,
												positinfowindow		:posit3,
												positinfowindowlat	:resp[i].positinfowindowlat,
												positinfowindowlng	:resp[i].positinfowindowlng,
												oldfillColor		:resp[i].circle_farbe_fuellung,
												oldfillOpacity		:resp[i].circle_transparent_fuellung,
												oldstrokeColor		:resp[i].circle_farbe_linie,
												oldstrokeOpacity	:resp[i].circle_transparent_linie,
												oldstrokeWeight		:resp[i].circle_linie_breite,
												oldcenter			:posit1,
												oldtext				:resp[i].circle_beschreibung,
												oldcirclemarkerlat	:resp[i].circle_position1_lat,
												oldcirclemarkerlng	:resp[i].circle_position1_lng,
												oldradius			:eval(resp[i].circle_radius),
											});
						} //Ende for schleife
					   
					   initcircle();
					   }progress(20,'#loadbar');
				}else if (Ziel == 'getallline') {
					var resp=response;
					  line = new Array();
					  linedummy = new Array();
					  linemarker = new Array();
					 
					   if (response != null){
						for(var i = 0; i< resp.length; i++) {
							if (resp[i].firstinfofenster == null){
								resp[i].firstinfofenster = 'false';
							}
							if (resp[i].chart_units == null){
								resp[i].chart_units = 'SI';
							}

							var posit3 = 'false';
							if (resp[i].positinfowindowlat != '' && resp[i].positinfowindowlat != 'undefined' && resp[i].positinfowindowlat != null){
								posit3 =new google.maps.LatLng(resp[i].positinfowindowlat ,resp[i].positinfowindowlng );
							}
							linemarker[i] = new Array();
							oldlinepoints[i] = new Array();
 							var points = new Array();
							for(var p = 0; p< resp[i].line_punkt_lat.length; p++) {
								var newpoint = new google.maps.LatLng(resp[i].line_punkt_lat[p] ,resp[i].line_punkt_lng[p] );
								linemarker[i][p] = new google.maps.Marker({
									position: newpoint,
									title: '#'+ p,
									map: map,
									visible: false,
									icon: mysystemicon('line_point_delete.png', 16, 16, 24, 8),
									});
							 points.push(newpoint);
							 oldlinepoints[i][p] = newpoint;	
							}
							resp[i].style = Core.checkVar(resp[i].style, 'default')
							resp[i].style_scale = Core.checkVar(resp[i].style_scale, '1')
							resp[i].style_offset = Core.checkVar(resp[i].style_offset, '0')
							resp[i].style_zindex = Core.checkVar(resp[i].style_zindex, '0')
							resp[i].style_repeat = Core.checkVar(resp[i].style_repeat, '5px')
							line[i] = new google.maps.Polyline({
										map					:map,
										access_group		:resp[i].access_group,
										line_id				:resp[i].line_id,
										gmselected			:'false',
										status				:'standard',
										linetitel			:resp[i].line_titel,
										strokeColor			:resp[i].line_farbe,
										strokeOpacity		:resp[i].line_transparent,
										strokeWeight		:resp[i].line_breite,
										chartonoff			:resp[i].chart_on_off,
										chartunits			:resp[i].chart_units,
										text				:resp[i].line_beschreibung,
										path				:points,
										firstinfofenster	:resp[i].firstinfofenster,
										positinfowindow		:posit3,
										positinfowindowlat	:resp[i].positinfowindowlat,
										positinfowindowlng	:resp[i].positinfowindowlng,
										line_new			:'no',
										geodesic			: true,
										zIndex				: resp[i].style_zindex,
										style				: resp[i].style,
										style_scale			: resp[i].style_scale,
										style_offset		: resp[i].style_offset,
										style_zindex		: resp[i].style_zindex,
										style_repeat		: resp[i].style_repeat,
									});
							linedummy[i] = new google.maps.Polyline({
										map					:map,
										strokeColor			:'#000000',
										strokeWeight		:1,
										strokeOpacity		:0,
										path				:points,
										geodesic			: true,
										zIndex				: 2
									});
							Line.setSaveStyle(resp[i].style, i);
						} //Ende for schleife
					  
					  initline();
					   }progress(20,'#loadbar');
				}else if (Ziel == 'getallpolygon') {
					var resp=response;
					  polygon = new Array();
					  polygonmarker = new Array();
					   if (response != null){
						for(var i = 0; i< resp.length; i++) {
							if (resp[i].firstinfofenster == null){
								resp[i].firstinfofenster = 'false';
							}
							var posit3 = 'false';
							if (resp[i].positinfowindowlat != '' && resp[i].positinfowindowlat != 'undefined' && resp[i].positinfowindowlat != null){
								posit3 =new google.maps.LatLng(resp[i].positinfowindowlat ,resp[i].positinfowindowlng );
							}
							polygonmarker[i] = new Array();
 							var points = new Array();
							for(var p = 0; p< resp[i].polygon_punkt_lat.length; p++) {
								var newpoint = new google.maps.LatLng(resp[i].polygon_punkt_lat[p] ,resp[i].polygon_punkt_lng[p] );
								polygonmarker[i][p] = new google.maps.Marker({
									position: newpoint,
									title: '#'+ p,
									map: map,
									visible: false,
									icon: mysystemicon('line_point_delete.png', 16, 16, 24, 8),
									});
								//polygonmarker[i][p].getButtonWindow = getbuttonwindow;	
							 points.push(newpoint);
							}
							polygon[i] = new google.maps.Polygon({
												map					:map,
												access_group		:resp[i].access_group,
												polygon_id			:resp[i].polygon_id,
												gmselected		:'false',
												status				:'standard',
												polygontitel		:resp[i].polygon_titel,
												strokeColor			:resp[i].polygon_color_line,
												strokeOpacity		:resp[i].polygon_transparent_line,
												strokeWeight		:resp[i].polygon_width_line,
												fillColor			:resp[i].polygon_color_fill,
												fillOpacity			:resp[i].polygon_transparent_fill,
												text				:resp[i].polygon_beschreibung,
												path				:points,
												firstinfofenster	: resp[i].firstinfofenster,
												positinfowindow		:posit3,
												positinfowindowlat	:resp[i].positinfowindowlat,
												positinfowindowlng	:resp[i].positinfowindowlng,
												polygon_new			:'no',
												geodesic			: true,
											});
						} //Ende for schleife
					  
					initpolygon();
					   }progress(20,'#loadbar');
				}else if (Ziel == 'getalltexte') {
					var resp=response;
					  boxmarker = new Array();
					   if (response != null){
					  	for(var i = 0; i< resp.length; i++) {
							var posit =new google.maps.LatLng(resp[i].text_lat ,resp[i].text_lng );
								boxmarker[i]= new google.maps.Marker({
									position	: posit,
									id			:resp[i].text_id,
									lat			:resp[i].text_lat,
									lng			:resp[i].text_lng,
									text		:resp[i].text_text,
									range_start	:Core.checkVar(resp[i].range_start,'0'),
									range_end	:Core.checkVar(resp[i].range_end,'21'),
									map			: map,
									gmselected	:'false',
									access_group:resp[i].access_group,
									text_new	: 'no',
									status		: 'standard',
									visible		: false,
									rotation	:Core.checkVar(resp[i].rotation,'0'),
									icon		: mysystemicon('element_activ.png',15,26,7,7),
									});
						} //Ende for schleife
					  
					  inittext();
					  }progress(20,'#loadbar');
				}else if (Ziel == 'getmap') {
					var resp=response;
					    if (response != null){
						   var posit =new google.maps.LatLng(resp.map_lat,resp.map_lng );
							 map_saved_option = {
									zoom								: parseInt(resp.map_zoom),
									center								: posit,
									minZoom								: resp.map_minzoom,
									maxZoom								: resp.map_maxzoom,
									mapTypeId							: resp.map_typeId,
									disableDoubleClickZoom				: resp.map_DoubleClickZoom,
									mapTypeControl						: false,
									draggable							: resp.map_draggable,
									scrollwheel							: resp.map_scrollwheel,
									panControl							: resp.map_panControl,
									zoomControl							: resp.map_zoomControl,
									ZoomControlOptions					: {style: eval(resp.map_ZoomControlStyle)},
									scaleControl						: resp.map_scaleControl,
									streetViewControl					: resp.streetViewControl,
									overviewMapControl	 				: resp.map_overview_map,
									overviewMapControlOptions			:{ opened : resp.map_overview_map_open},
									map_layer_button					: resp.map_layer_button,
									map_bike_layer						: resp.map_bike_layer,
									map_traffic_layer					: resp.map_traffic_layer,
									map_transit_layer					: resp.map_transit_layer,
									street_view_activ					: resp.street_view_activ,
									street_view_center_lat				: resp.street_view_center_lat,
									street_view_center_lng				: resp.street_view_center_lng,
									street_view_heading					: resp.street_view_heading,
									street_view_zoom					: resp.street_view_zoom,
									street_view_pitch					: resp.street_view_pitch,
									map_setup_button					: resp.map_setup_button,
									map_typ_control_button				: resp.map_typ_control_button,
									map_language						: resp.map_language,
									custom_map_language					: resp.custom_map_language,
									map_overview_map					: resp.map_overview_map,
									map_overview_map_open				: resp.map_overview_map_open,
							};
					   }//Ende for schleife
				}
				}//Ende if abfrage
        });
}

function getkml (View, Layout, Format) {
	var siteurl=URIBase+"administrator/index.php?option=com_gmap&view="+View+"&tmpl=component&layout="+Layout+"&format="+Format;	
	var cid = document.getElementById('map_id').value;
	var Id =document.getElementById('map_id').value;
	jQuery.ajax({
		   	url:	siteurl,
			type: "GET",
			async: true,
			cache:false, 
			data: { 'cid': cid,
					'id': Id
					},
			dataType:"json",
            success: function(response) {
					var resp=response;
					  kmllayer = new Array();
					   if (response != null){
					  	for(var i = 0; i< resp.length; i++) {
							kmllayer[i] = new google.maps.KmlLayer({
								kml_id: resp[i].kml_id,
								url: resp[i].kml_pfad,
								kml_beschreibung: resp[i].kml_beschreibung,
								show_kml: 'off',
								setZIndex:i,
								preserveViewport:true
								});
						}
					   }
					   initkml();
					  
			}
		});
}

function removedata (task, Id) {
	 var siteurl= URIBase + "administrator/index.php?option=com_gmap&task=gm_editor."+task+"&id=" + Id ;
	   jQuery.ajax({
            url	: siteurl,
			method:"post",
			cache:false,
			async: true
			});
}

function savemarker(mid, last) {
	
		var siteurl= URIBase + "administrator/index.php?option=com_gmap&task=gm_editor.save_marker";
		var marker_parameter = 'firstinfofenster:' + marker[mid].firstinfofenster;
			marker_parameter +=',markermouseover:' + marker[mid].title;
  	   jQuery.ajax({
			url	: siteurl,
			type: "POST",
			cache:false,
			async: false,
			data: { 'marker_titel' : marker[mid].markertitel,
					'marker_strasse': marker[mid].markerstrasse,
					'marker_ort': marker[mid].markerort,
					'marker_plz': marker[mid].markerplz,
					'marker_beschreibung': marker[mid].text,
					'marker_icon': marker[mid].markericon,
					'marker_lng': marker[mid].markerlng,
					'marker_lat': marker[mid].markerlat,
					'marker_id': marker[mid].marker_id,
					'marker_status': marker[mid].markerstatus,
					'marker_new': marker[mid].markernew,
					'id_map': document.getElementById('map_id').value,
					'marker_parameter': marker_parameter,
					'access_group': marker[mid].access_group
					},
			 success: function() {
				 if (last=='true'){
					 main.SaveProgress(14);
					 getdata('gm_editor', 'form_ajax_marker', 'raw', 'getallmarker','');//View, Layout, Format, Ziel, Lang
					 }}
        });
    }
function saverectangle(rid, last) {
	var currentBounds = rectangle[rid].getBounds();
		var siteurl= URIBase + "administrator/index.php?option=com_gmap&task=gm_editor.save_rectangle";
		var rectangle_parameter = 'firstinfofenster:' + rectangle[rid].firstinfofenster;
			rectangle_parameter += '|positinfowindowlat:' + rectangle[rid].positinfowindowlat;
			rectangle_parameter += '|positinfowindowlng:' + rectangle[rid].positinfowindowlng;
			rectangle_parameter += '|rectangle_title:' + rectangle[rid].title;
  	     jQuery.ajax({
			url	: siteurl,
			type: "POST",
			cache:false,
			async: false,
			data: { 'rectangle_position1_lat' : currentBounds.getNorthEast().lat(),
					'rectangle_position1_lng': currentBounds.getNorthEast().lng(),
					'rectangle_position2_lat' : currentBounds.getSouthWest().lat(),
					'rectangle_position2_lng' : currentBounds.getSouthWest().lng(),
					'rectangle_farbe_linie': rectangle[rid].strokeColor,
					'rectangle_linie_breite': rectangle[rid].strokeWeight,
					'rectangle_transparent_linie': rectangle[rid].strokeOpacity,
					'rectangle_farbe_fuellung': rectangle[rid].fillColor,
					'rectangle_transparent_fuellung': rectangle[rid].fillOpacity,
					'rectangle_id': rectangle[rid].rectangle_id,
					'rectangle_new': rectangle[rid].rectangle_new,
					'rectangle_beschreibung':rectangle[rid].text,
					'id_map': $('map_id').value,
					'rectangle_parameter': rectangle_parameter,
					'access_group': rectangle[rid].access_group
					},
			 success: function() {if (last=='true'){
				getdata('gm_editor', 'form_ajax_rectangle', 'raw', 'getallrectangle', '');//View, Layout, Format, Ziel, Lang
				main.SaveProgress(14);
				 }}
        });
	
    }
function savecircle(cid, last) {
		var siteurl= URIBase + "administrator/index.php?option=com_gmap&task=gm_editor.save_circle";
		var circle_parameter = 'firstinfofenster:' + circle[cid].firstinfofenster;
			circle_parameter += '|positinfowindowlat:' + circle[cid].positinfowindowlat;
			circle_parameter += '|positinfowindowlng:' + circle[cid].positinfowindowlng;
			circle_parameter += '|circle_title:' + circle[cid].title;
  	    jQuery.ajax({
			url	: siteurl,
			type: "POST",
			cache:false,
			async: false,
			data: { 'circle_marker_lat' 		: circle[cid].circlemarkerlat,
					'circle_marker_lng'			: circle[cid].circlemarkerlng,
					'circle_radius' 			: circle[cid].radius,
					'circle_beschreibung' 		: circle[cid].text,
					'circle_farbe_linie'		: circle[cid].strokeColor,
					'circle_linie_breite'		: circle[cid].strokeWeight,
					'circle_transparent_linie'	: circle[cid].strokeOpacity,
					'circle_farbe_fuellung'		: circle[cid].fillColor,
					'circle_transparent_fuellung': circle[cid].fillOpacity,
					'circle_id'					: circle[cid].circle_id,
					'circle_new'				: circle[cid].circle_new,
					'id_map'					: document.getElementById('map_id').value,
					'circle_parameter'			:circle_parameter,
					'access_group'				: circle[cid].access_group
					},
			 success: function() {if (last=='true'){
				getdata('gm_editor', 'form_ajax_circle', 'raw', 'getallcircle','');//View, Layout, Format, Ziel, Lang
				 main.SaveProgress(14);
				 }}
        });
	
    }
function saveline(cid, punkte, last) {
		var siteurl= URIBase + "administrator/index.php?option=com_gmap&task=gm_editor.save_line";
		var line_parameter = 'chart_on_off:' + line[cid].chartonoff;
			line_parameter += '|chart_units:' + Core.checkVar(line[cid].chartunits,'SI');
			line_parameter += '|firstinfofenster:' + Core.checkVar(line[cid].firstinfofenster, '');
			line_parameter += '|positinfowindowlat:' + line[cid].positinfowindowlat;
			line_parameter += '|positinfowindowlng:' + line[cid].positinfowindowlng;
			line_parameter += '|style:' + Core.checkVar(line[cid].style, 'default');
			line_parameter += '|style_scale:' + Core.checkVar(line[cid].style_scale, '1');
			line_parameter += '|style_zindex:' + Core.checkVar(line[cid].style_zindex, '0');
			line_parameter += '|style_offset:' + Core.checkVar(line[cid].style_offset, '0');
			line_parameter += '|style_repeat:' + Core.checkVar(line[cid].style_repeat, '10px');
  	    jQuery.ajax({
			url	: siteurl,
			type: "POST",
			cache:false,
			async: false,
			data: { 'line_titel' 				: line[cid].linetitel,
					'line_farbe'				: line[cid].strokeColor,
					'line_breite'				: line[cid].strokeWeight,
					'line_transparent'			: line[cid].strokeOpacity,
					'line_punkte'				: punkte,
					'line_parameter'			: line_parameter,
					'line_beschreibung'			: line[cid].text,
					'line_id'					: line[cid].line_id,
					'line_new'					: line[cid].line_new,
					'id_map'					: document.getElementById('map_id').value,
					'access_group'				: line[cid].access_group
					},
			 success: function() {if (last=='true'){
				 getdata('gm_editor', 'form_ajax_line', 'raw', 'getallline','');//View, Layout, Format, Ziel, Lang
				 main.SaveProgress(14);
				 }}
        });
	
    }
function savepolygon(cid, punkte, last) {
		var siteurl= URIBase + "administrator/index.php?option=com_gmap&task=gm_editor.save_polygon";
		var polygon_parameter = 'firstinfofenster:' + polygon[cid].firstinfofenster;
			polygon_parameter += '|positinfowindowlat:' + polygon[cid].positinfowindowlat;
			polygon_parameter += '|positinfowindowlng:' + polygon[cid].positinfowindowlng;
  	    jQuery.ajax({
			url	: siteurl,
			type: "POST",
			cache:false,
			async: false,
			data: { 'polygon_titel' 				: polygon[cid].polygontitel,
					'polygon_color_line'			: polygon[cid].strokeColor,
					'polygon_width_line'			: polygon[cid].strokeWeight,
					'polygon_transparent_line'		: polygon[cid].strokeOpacity,
					'polygon_color_fill'			: polygon[cid].fillColor,
					'polygon_transparent_fill'		: polygon[cid].fillOpacity,
					'polygon_path'					: punkte,
					'polygon_parameter'				: polygon_parameter,
					'polygon_beschreibung'			: polygon[cid].text,
					'polygon_id'					: polygon[cid].polygon_id,
					'polygon_new'					: polygon[cid].polygon_new,
					'id_map'						: document.getElementById('map_id').value,
					'access_group'					: polygon[cid].access_group
					},
			 success: function() {if (last=='true'){
				 getdata('gm_editor', 'form_ajax_polygon', 'raw', 'getallpolygon','');//View, Layout, Format, Ziel, Lang
				 main.SaveProgress(14);
				 }}
        });
	
    }
function savebox(cid, last) {
		var siteurl= URIBase + "administrator/index.php?option=com_gmap&task=gm_editor.save_htmlbox";
		var htmlbox_parameter = 'rotation:' + boxmarker[cid].rotation;
			htmlbox_parameter += '|range_start:' + Core.checkVar(boxmarker[cid].range_start,'0');
			htmlbox_parameter += '|range_end:' + Core.checkVar(boxmarker[cid].range_end,'21');
  	    jQuery.ajax({
			url	: siteurl,
			type: "POST",
			cache:false,
			async: false,
			data: { 'text_text' 				: boxmarker[cid].text,
					'text_lat'					: boxmarker[cid].lat,
					'text_lng'					: boxmarker[cid].lng,
					'text_id'					: boxmarker[cid].id,
					'text_new'					: boxmarker[cid].text_new,
					'id_map'					: document.getElementById('map_id').value,
					'text_parameter'			: htmlbox_parameter,
					'access_group'				: boxmarker[cid].access_group
					},
			 success: function() {if (last=='true'){
				 getdata('gm_editor', 'form_ajax_htmlbox', 'raw', 'getalltexte','');//View, Layout, Format, Ziel, Lang
				 main.SaveProgress(16);
				 }}
        });
	
    }
