var id;
var map= new Array();
var mapoptions= new Array();;
var marker = new Array();
var rectangle= new Array();
var circle= new Array();
var textmarker;
var line = new Array();
var polygon = new Array();
var linedummy = new Array();
var linepoints = new Array();
var infowindow = new Array();
var bikelayer = new Array();
var trafficlayer = new Array();
var transitlayer = new Array();
var streetviewlayer = new Array();
var elevator= new Array();
var chart= new Array();
var kmllayer= new Array();
var markercluster= new Array();
var linestyle= new Array();
var text=new Array();

function gettruefalse(werte) {
	var check = (werte =='true'	) ?
		werte = true :
		werte = false;
		return werte; 
}
var Core = {
	checkVar: function (gm_var, gm_default){
		return (typeof gm_var == 'undefined' ? gm_default : gm_var);
	},
}

function getLineStyle (View, Layout, Format) {
	var siteurl=URIBase+"index.php?option=com_gmap&view="+View+"&tmpl=component&layout="+Layout+"&format="+Format;	
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
function getdata (View, Layout, Format, Ziel, Mapid, lang) {
	
	var siteurl=URIBase+"index.php?option=com_gmap&view="+View+"&tmpl=component&layout="+Layout+"&format="+Format;	
	var cid = Mapid;
	var Id =Mapid;
	if (Ziel == 'getallmaps'){
		var asyncload = false;
	}else{
		var asyncload = true;
	}
	jQuery.ajax({
			url:	siteurl,
          	type: "GET",
			cache:false,
			dataType:"json",
			async: asyncload, 
			data: { 'cid': cid,
					'id': Id
					},
            success: function(response) {
				if (Ziel == 'getallrectangle') {
					 var resp=response;
					 if (response > ''){
					  rectangle[Mapid] = new Array();
						for(var i = 0; i< resp.length; i++) {
							var posit3 = 'false';
							if (resp[i].positinfowindowlat != '' && resp[i].positinfowindowlat != 'undefined' && resp[i].positinfowindowlat != null){
								posit3 =new google.maps.LatLng(resp[i].positinfowindowlat ,resp[i].positinfowindowlng );
							}
							var posit1 =new google.maps.LatLng(resp[i].rectangle_position1_lat ,resp[i].rectangle_position1_lng );
							var posit2 =new google.maps.LatLng(resp[i].rectangle_position2_lat ,resp[i].rectangle_position2_lng );
							var latLngBounds = new google.maps.LatLngBounds(posit2, posit1);
							rectangle[Mapid][i] = new google.maps.Rectangle({
	      									  	map					:map[Mapid],
												fillColor			:resp[i].rectangle_farbe_fuellung,
												fillOpacity			:resp[i].rectangle_transparent_fuellung,
												strokeColor			:resp[i].rectangle_farbe_linie,
												strokeOpacity		:resp[i].rectangle_transparent_linie,
												strokeWeight		:resp[i].rectangle_linie_breite,
												rectanglebeschreibung: resp[i].rectangle_beschreibung,
												firstinfofenster	:resp[i].firstinfofenster,
												positinfowindow		:posit3,
												clickable			: false
											});
							rectangle[Mapid][i].setBounds(latLngBounds);
							if (rectangle[Mapid][i].rectanglebeschreibung !=''){
							rectangle[Mapid][i].clickable = true;			
							addrectangleevent (Mapid, i);
							}
						} //Ende for schleife
					 }
				}else if (Ziel == 'getallmarker') {//einlesen aller vorhandenen Marker für die entsp. Karte
					 var resp=response;
					 if (response > ''){
					  marker[Mapid] = new Array();
						for(var i = 0; i< resp.length; i++) {
							var posit =new google.maps.LatLng(resp[i].markerlat ,resp[i].markerlng );
							 marker[Mapid][i] = new google.maps.Marker({
											position: posit,
											map					: map[Mapid],
											id					: resp[i].markerid,
											markericon 			: resp[i].markericon,
											markerbeschreibung	: resp[i].markerbeschreibung,
											icon				: myicon(resp[i].markericon),
											opacity				: 0.85,
											title				: resp[i].markermouseover,
											markertitel			: resp[i].markertitel,
											firstinfofenster	: resp[i].firstinfofenster,
							});
							addmarkerevent (Mapid, i);
						} //Ende for schleife
						mod_search_refresh (Mapid);
					if (map[Mapid].marker_cluster_activ == 'true'){
						 initMarkerCluster(Mapid);
					
					}
					
					 }
				}else if (Ziel == 'getallcircle') {
					var resp=response;
					if (response > ''){
					  circle[Mapid] = new Array();
						for(var i = 0; i< resp.length; i++) {
							var posit3 = 'false';
							if (resp[i].positinfowindowlat != '' && resp[i].positinfowindowlat != 'undefined' && resp[i].positinfowindowlat != null){
								posit3 =new google.maps.LatLng(resp[i].positinfowindowlat ,resp[i].positinfowindowlng );
							}
							var posit1 =new google.maps.LatLng(resp[i].circle_position1_lat ,resp[i].circle_position1_lng );
							circle[Mapid][i] = new google.maps.Circle({
	      									  	map					:map[Mapid],
												fillColor			:resp[i].circle_farbe_fuellung,
												fillOpacity			:resp[i].circle_transparent_fuellung,
												strokeColor			:resp[i].circle_farbe_linie,
												strokeOpacity		:resp[i].circle_transparent_linie,
												strokeWeight		:resp[i].circle_linie_breite,
												circlebeschreibung	: resp[i].circle_beschreibung,
												firstinfofenster	:resp[i].firstinfofenster,
												positinfowindow		:posit3,
												center				:posit1,
												clickable			:false,
												radius				:parseInt(resp[i].circle_radius),
											});
							if (circle[Mapid][i].circlebeschreibung !=''){
							circle[Mapid][i].clickable = true;			
							addcircleevent (Mapid, i);
							}
						} //Ende for schleife
					}
				}else if (Ziel == 'getallline') {
					var resp=response;
					if (response > ''){
					  line[Mapid] = new Array();
					  linedummy[Mapid] = new Array();
					  linepoints = new Array();
						for(var i = 0; i< resp.length; i++) {
							var posit3 = 'false';
							if (resp[i].positinfowindowlat != '' && resp[i].positinfowindowlat != 'undefined' && resp[i].positinfowindowlat != null){
								posit3 =new google.maps.LatLng(resp[i].positinfowindowlat ,resp[i].positinfowindowlng );
							}
							linepoints[i] = new Array();
							for(var p = 0; p< resp[i].line_punkt_lat.length; p++) {
								var newpoint = new google.maps.LatLng(resp[i].line_punkt_lat[p] ,resp[i].line_punkt_lng[p] );
								linepoints[i][p] = newpoint;
							}
							resp[i].style = Core.checkVar(resp[i].style, 'default')
							resp[i].style_scale = Core.checkVar(resp[i].style_scale, '1')
							resp[i].style_offset = Core.checkVar(resp[i].style_offset, '0')
							resp[i].style_zindex = Core.checkVar(resp[i].style_zindex, '0')
							resp[i].style_repeat = Core.checkVar(resp[i].style_repeat, '5px')
							line[Mapid][i] = new google.maps.Polyline({
												map					:map[Mapid],
												linetitel			:resp[i].line_titel,
												strokeColor			:resp[i].line_farbe,
												strokeOpacity		:resp[i].line_transparent,
												strokeWeight		:resp[i].line_breite,
												path				:linepoints[i],
												geodesic			: true,
												clickable			:false,
												linebeschreibung	: resp[i].line_beschreibung,
												firstinfofenster	:resp[i].firstinfofenster,
												positinfowindow		:posit3,
												chartonoff			:resp[i].chart_on_off,
												chartunits			:resp[i].chart_units,
												zIndex				: resp[i].style_zindex,
												style				: resp[i].style,
												style_scale			: resp[i].style_scale,
												style_offset		: resp[i].style_offset,
												style_zindex		: resp[i].style_zindex,
												style_repeat		: resp[i].style_repeat,
											});
							linedummy[Mapid][i] = new google.maps.Polyline({
											map					:map[Mapid],
											strokeColor			:'#000000',
											strokeOpacity		:0.0,
											strokeWeight		:7,
											clickable			:false,
											path				:linepoints[i],
											geodesic			: true,
											zIndex				: 1
										});
							if (line[Mapid][i].linebeschreibung != '' || line[Mapid][i].chartonoff =='true'){	
								addlineevent (Mapid, i);
								linedummy[Mapid][i].setOptions({clickable:true});		
							}
						Line.setSaveStyle(resp[i].style, Mapid, i);
							
						} //Ende for schleife
					}
				}else if (Ziel == 'getallpolygon') {
					var resp=response;
					if (response > ''){
					  polygon[Mapid] = new Array();
						for(var i = 0; i< resp.length; i++) {
							var posit3 = 'false';
							if (resp[i].positinfowindowlat != '' && resp[i].positinfowindowlat != 'undefined' && resp[i].positinfowindowlat != null){
								posit3 =new google.maps.LatLng(resp[i].positinfowindowlat ,resp[i].positinfowindowlng );
							}
 							var points = new Array();
							for(var p = 0; p< resp[i].polygon_punkt_lat.length; p++) {
								var newpoint = new google.maps.LatLng(resp[i].polygon_punkt_lat[p] ,resp[i].polygon_punkt_lng[p] );
							 points.push(newpoint);
							}
							polygon[Mapid][i] = new google.maps.Polygon({
	      									  	map					:map[Mapid],
												strokeColor			:resp[i].polygon_color_line,
												strokeOpacity		:resp[i].polygon_transparent_line,
												strokeWeight		:resp[i].polygon_width_line,
												fillColor			:resp[i].polygon_color_fill,
												fillOpacity			:resp[i].polygon_transparent_fill,
												polygonbeschreibung	: resp[i].polygon_beschreibung,
												firstinfofenster	:resp[i].firstinfofenster,
												positinfowindow		:posit3,
												clickable			:false,
												path				:points,
												geodesic			: true,
											});
							if (polygon[Mapid][i].polygonbeschreibung !=''){
							polygon[Mapid][i].clickable = true;			
							addpolygonevent (Mapid, i);
							}
						} //Ende for schleife
					}
				}else if (Ziel == 'getalltexte') {
					var resp=response;
					if (response > ''){
					  text[Mapid] = new Array();
					  var breite = 'min';
					  var hoehe = 'auto';
					  	for(var i = 0; i< resp.length; i++) {
							var rotation = resp[i].rotation;
							var posit =new google.maps.LatLng(resp[i].text_lat ,resp[i].text_lng );
							text[Mapid][i] = new ToolTip(breite, hoehe, map[Mapid], posit, resp[i].text_text, i,rotation);
							text[Mapid][i].range_start = resp[i].range_start;
							text[Mapid][i].range_end = resp[i].range_end;

						}//Ende for schleife	
					}
				}else if (Ziel == 'getallmaps') {//einlesen aller vorhandenen Marker für die entsp. Karte
					 var resp=response;
						if (response > '') {
							infowindow[Mapid] = new google.maps.InfoWindow();
							var posit =new google.maps.LatLng(resp.map_center_lat,resp.map_center_lng );
							mapoptions[Mapid] = new Array();
							 mapoptions[Mapid] = {
									zoom								: parseInt(resp.map_zoom),
									center								: posit,
									minZoom								: parseInt(resp.map_minzoom),
									maxZoom								: parseInt(resp.map_maxzoom),
									mapTypeId							: resp.map_maptype,
									disableDoubleClickZoom				: eval(resp.map_DoubleClickZoom),
									mapTypeControl						: false,
									draggable							: eval(resp.map_draggable),
									scrollwheel							: eval(resp.map_scrollwheel),
									panControl							: eval(resp.map_panControl),
									zoomControl							: eval(resp.map_zoomControl),
									ZoomControlOptions					: {style: eval(resp.map_ZoomControlStyle)},
									scaleControl						: eval(resp.map_scaleControl),
									streetViewControl					: eval(resp.streetViewControl),
									overviewMapControl	 				: eval(resp.map_overview_map),
									overviewMapControlOptions			:{ opened : eval(resp.map_overview_map_open)},
									setup_button_html					: resp.setup_button_html,
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
									kml_files							: resp.kml_files,
									marker_cluster_activ				: resp.marker_cluster_activ,
									marker_cluster_grid_size			: resp.marker_cluster_grid_size,
									map_folder_cluster_icon				: resp.map_folder_cluster_icon,
									map_cluster_icon					: resp.map_cluster_icon,
									marker_cluster_info_window			: resp.marker_cluster_info_window,
							};
					map[resp.map_id] =	new google.maps.Map(document.getElementById(''+resp.map_id+''), mapoptions[Mapid]);
					if (resp.map_satellite_view_45 == 'true'){
					map[resp.map_id].setTilt(45);
					map[resp.map_id].setHeading(eval(resp.map_satellite_view_45_heading));
					}else{
					map[resp.map_id].setTilt(0);	
					}
					maploadevent(resp.map_id);
						} //Ende for schleife
				}
			}
        });
    }

function getkml (View, Layout, Format,Mapid) {
	var siteurl=URIBase+"index.php?option=com_gmap&view="+View+"&tmpl=component&layout="+Layout+"&format="+Format;	
	var kmlids = map[Mapid].kml_files;
	jQuery.ajax({
		   	url:	siteurl,
			type: "GET",
			async: true,
			cache:false, 
			data: { 'kmlids': kmlids,
					},
			dataType:"json",
            success: function(response) {
					var resp=response;
					  kmllayer[Mapid] = new Array();
					   if (response != null){
					  	for(var i = 0; i< resp.length; i++) {
							kmllayer[Mapid][i] = new google.maps.KmlLayer({
								kml_id: resp[i].kml_id,
								url: resp[i].kml_pfad,
								kml_beschreibung: resp[i].kml_beschreibung,
								show_kml: 'on',
								setZIndex:i,
								preserveViewport:true
								});
								kmllayer[Mapid][i].setMap(map[Mapid]);
								addkmlevent(Mapid, i);
						}
					   }
					  
					  
			}
		});
}
