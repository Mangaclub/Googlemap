// JavaScript Document
function gm_element(ele){
var my_gm_element = document.getElementById(ele);
return my_gm_element;
}

function myicon(icon){
if (icon != 'standard'){
  var geticon = new google.maps.MarkerImage(URIBase+'images/stories/com_gmap/' + icon);
  }
if (icon == 'standard'){
  var geticon = new google.maps.MarkerImage(URIBase+'components/com_gmap/assets/images/pin_rot.png');
  }
  return geticon;
  }

function gm_initialize(mapid, iframe) {
	var lang ='';
		google.maps.controlStyle = 'azteca';
		getdata('gm_maps','form_maps', 'raw', 'getallmaps',mapid);
		getLineStyle('gm_line_style', 'form_line_style', 'raw');//View, Layout, Format
		bikelayer[mapid] = new google.maps.BicyclingLayer();
		trafficlayer[mapid] = new google.maps.TrafficLayer();
		transitlayer[mapid] = new google.maps.TransitLayer();
		elevator[mapid] = new google.maps.ElevationService();
		markercluster[mapid] = new MarkerClusterer(map[mapid]);
		streetviewlayer[mapid] = map[mapid].getStreetView();
		map[mapid].mapTypes.set("osm", new google.maps.ImageMapType({
			getTileUrl: function(coord, zoom) {
				return "https://a.tile.osm.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
			},
			tileSize: new google.maps.Size(256, 256),
			name: "OpenStreetMap",
			maxZoom: 18
		}));
			if (map[mapid].street_view_center_lat != ''){	
				  var mapcenter = new google.maps.LatLng(map[mapid].street_view_center_lat,map[mapid].street_view_center_lng);
				streetviewlayer[mapid].setPosition(mapcenter);
				streetviewlayer[mapid].setPov({
								heading:parseFloat(map[mapid].street_view_heading),
								zoom:	parseInt(map[mapid].street_view_zoom),
								pitch:	parseFloat(map[mapid].street_view_pitch)
								});
		}
				//init all markers
			getdata('gm_markers','form_markers', 'raw', 'getallmarker',mapid);
			//init all circle					
			getdata('gm_circles','form_circles', 'raw', 'getallcircle',mapid);
			//init all rectangles
			getdata('gm_rectangles','form_rectangles', 'raw', 'getallrectangle',mapid);
			//init all line
			getdata('gm_lines','form_lines', 'raw', 'getallline',mapid);
			//init all polygon
			getdata('gm_polygon','form_polygon', 'raw', 'getallpolygon',mapid);
			//init all text 
			getdata('gm_texte','form_texte', 'raw', 'getalltexte',mapid);
			//init all KML
			if (map[mapid].kml_files != ''){
				getkml('gm_kml', 'form_kml', 'raw',mapid);//View, Layout, Format
			}
			Map.addFullScreenButton(mapid);
		if (iframe == 'true'){
			jQuery('#map_full_screen_button_'+mapid).addClass('display_off');
		};
		google.maps.event.addListener(map[mapid], 'zoom_changed', function() {
			Box.visibilityOnOff(mapid);
		});
		google.maps.event.addListener(streetviewlayer[mapid], 'closeclick', function() {
			jQuery('#map_setup_button_'+mapid).removeClass('msb_street_view').addClass('msb_default');
			jQuery('#map_full_screen_button_'+mapid).removeClass('mfsb_street_view').addClass('mfsb_default');
		});
		map[mapid].currentMapCenter = map[mapid].getCenter();
		google.maps.event.addListener(map[mapid], 'bounds_changed', function() {
			map[mapid].currentMapCenter = map[mapid].getCenter();
		});
	new ResizeSensor(jQuery('#'+mapid), function(el){
		mapsize (mapid);
		google.maps.event.trigger(map[mapid], 'resize');
		map[mapid].setCenter(map[mapid].currentMapCenter);
	});
}

var Map = {
	addFullScreenButton: function(mapid){
		var $wrapper = jQuery("<div>", {id: "map_full_screen_button_"+mapid, class: "map_full_screen_button mfsb_default"});
		jQuery("#"+mapid).append($wrapper);
		jQuery("#map_full_screen_button_"+mapid).click(function() {
			Map.toggleFullScreen(mapid);
			jQuery( "#map_elevation_wrapper"+mapid ).removeClass( "mec_show");
		});
	},
	toggleFullScreen: function(mapid){
		screenfull.toggle(jQuery('#'+ mapid)[0]);
	},
	addSetupButton: function(mapid){
		var $wrapper = jQuery("<div>", {id: "map_setup_button_"+mapid, class: "map_setup_button msb_default"});
			jQuery("#"+mapid).append($wrapper);
		var $wrapper = jQuery("<div>", {id: "map_setup_wrapper_"+mapid, class: "map_setup_wrapper msw_hidden"});
			jQuery("#"+mapid).append($wrapper);
		var $wrapper = jQuery("<div>", {id: "map_setup_"+mapid, class: "map_setup ms_hidden"});
			jQuery("#"+mapid).append($wrapper);
			jQuery("#map_setup_"+mapid).html(mapoptions[mapid].setup_button_html);
		jQuery("#map_setup_button_"+mapid).click(function() {
			jQuery("#map_setup_wrapper_"+mapid).toggleClass( "msw_show");
			jQuery("#map_setup_"+mapid).toggleClass( "ms_show");
		});
		jQuery("#map_setup_wrapper_"+mapid).click(function() {
			jQuery("#map_setup_wrapper_"+mapid).toggleClass( "msw_show");
			jQuery("#map_setup_"+mapid).toggleClass( "ms_show");
		});
	},
	setSetupButtonOption: function(mapid){
		var check = (map[mapid].map_typ_control_button =='block') ?
			jQuery('#map_option_list_1_'+mapid).addClass('display_on'):
			jQuery('#map_option_list_1_'+mapid).addClass('display_off');
		var check = (map[mapid].map_layer_button =='block') ?
			jQuery('#map_option_list_2_'+mapid).addClass('display_on'):
			jQuery('#map_option_list_2_'+mapid).addClass('display_off');
		var check =(map[mapid].street_view_center_lat !='') ?
			jQuery('#map_layer_streetview_'+mapid).addClass('display_on'):
			jQuery('#map_layer_streetview_'+mapid).addClass('display_off');
		if (map[mapid].map_typ_control_button !='block' && map[mapid].map_layer_button !='block'){
			jQuery("#map_setup_button_"+mapid).addClass('display_off');
		}
	},
	addElevationChart: function(mapid){
		var $wrapper = jQuery("<div>", {id: "map_elevation_wrapper"+mapid, class: "map_elevation_wrapper mec_hidden"});
		jQuery("#"+mapid).append($wrapper);
		
		var $close = jQuery("<div>", {id: "map_elevation_close"+mapid, class: "map_elevation_close"});
			$close.click(function(){ 
				  jQuery( "#map_elevation_wrapper"+mapid ).removeClass( "mec_show");
			 });
		jQuery("#map_elevation_wrapper"+mapid).append($close);
		var $chart = jQuery("<div>", {id: "map_elevation"+mapid, class: "map_elevation"});
		jQuery("#map_elevation_wrapper"+mapid).append($chart);
	},
	addOpenStreetCopyRight: function(mapid){
		var osmr = document.createElement('div');
			osmr.id = "map_osm_"+mapid;
			osmr.className = 'osm_right display_off';
			osmr.innerHTML ='&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
		map[mapid].controls[google.maps.ControlPosition.BOTTOM_RIGHT].push(osmr);
	},
}

function mapsize (mapid){
	var width = jQuery('#'+mapid).width();
	var height = jQuery('#'+mapid).height();
	if (height < 250){
		jQuery('#map_setup_button_'+mapid).addClass('display_off');
		map[mapid].setOptions({overviewMapControl:false});
		map[mapid].setOptions({panControl:false});
		map[mapid].setOptions({streetViewControl:false});
	}else{
		jQuery('#map_setup_button_'+mapid).removeClass('display_off');
		map[mapid].setOptions({overviewMapControl:mapoptions[mapid].overviewMapControl});
		map[mapid].setOptions({panControl:mapoptions[mapid].panControl});
		map[mapid].setOptions({streetViewControl:mapoptions[mapid].streetViewControl});
	}
	if (width < 300){
		map[mapid].setOptions({overviewMapControl:false});
		map[mapid].setOptions({scaleControl:false});
		map[mapid].setOptions({panControl:false});
		map[mapid].setOptions({streetViewControl:false});
	}else{
		map[mapid].setOptions({overviewMapControl:mapoptions[mapid].overviewMapControl});
		map[mapid].setOptions({scaleControl:mapoptions[mapid].scaleControl});
		map[mapid].setOptions({panControl:mapoptions[mapid].panControl});
		map[mapid].setOptions({streetViewControl:mapoptions[mapid].streetViewControl});
	}
}

function maploadevent(mapid){
		google.maps.event.addListener(map[mapid], 'tilesloaded', function() {
		if( map[mapid].map_setup_button == 'block'){	
			Map.addSetupButton(mapid);
		};
			Map.setSetupButtonOption(mapid);
			Map.addElevationChart(mapid);
			setmapview.maptyp(map[mapid].mapTypeId, mapid);
			setmapview.bike(mapid);
			setmapview.traffic(mapid);
			setmapview.transit(mapid);
			 if( map[mapid].street_view_activ == 'true'){
				streetviewlayer[mapid].setOptions({visible:true});
			 }
			 Map.addOpenStreetCopyRight(mapid);
			if (map[mapid].getMapTypeId() == 'osm'){
				jQuery('#map_osm_'+mapid).removeClass('display_off').addClass('display_on');
			}
		mapsize(mapid);
		google.maps.event.clearListeners(map[mapid], 'tilesloaded');
		});
}

var setmapview ={
	maptyp		: function(button, mapid){
				jQuery('#map_setup_button_'+mapid).removeClass('msb_satellite').addClass('msb_default');
					jQuery('#map_option_roadmap_'+mapid).removeClass('option_on').addClass('option_off');
					jQuery('#map_option_terrain_'+mapid).removeClass('option_on').addClass('option_off');
					jQuery('#map_option_satellite_'+mapid).removeClass('option_on').addClass('option_off');
					jQuery('#map_option_hybrid_'+mapid).removeClass('option_on').addClass('option_off');
					jQuery('#map_option_osm_'+mapid).removeClass('option_on').addClass('option_off');
					jQuery('#map_osm_'+mapid).removeClass('display_on').addClass('display_off');
					jQuery('#map_option_'+button+'_'+mapid).removeClass('option_off').addClass('option_on');
					map[mapid].setOptions({mapTypeId:button});
					 this.closeMapSetup(mapid);
					 if (button =='satellite' || button =='hybrid'){
						 jQuery('#map_setup_button_'+mapid).removeClass('msb_default').addClass('msb_satellite');
					 }
					if (button == 'osm'){
						jQuery('#map_osm_'+mapid).removeClass('display_off').addClass('display_on');
					}
	},
	bike		: function(mapid){
			  		var check = map[mapid].map_bike_layer == 'map' ?
					 [
					 bikelayer[mapid].setMap(map[mapid]),
					 jQuery('#map_layer_bike_'+mapid).removeClass('option_off').addClass('option_on'),
					map[mapid].map_bike_layer = 'null',
					this.closeMapSetup(mapid)
					 ]
					 :
					 [
					 bikelayer[mapid].setMap(null),
					 jQuery('#map_layer_bike_'+mapid).removeClass('option_on').addClass('option_off'),
					 map[mapid].map_bike_layer = 'map',
					 this.closeMapSetup(mapid)
					 ]
		
	},
	traffic			: function(mapid){
			  		var check = map[mapid].map_traffic_layer == 'map' ?
					 [
					 trafficlayer[mapid].setMap(map[mapid]),
					 jQuery('#map_layer_traffic_'+mapid).removeClass('option_off').addClass('option_on'),
					 map[mapid].map_traffic_layer = 'null',
					 this.closeMapSetup(mapid)
					 ]
					 :
					 [
					 trafficlayer[mapid].setMap(null),
					 jQuery('#map_layer_traffic_'+mapid).removeClass('option_on').addClass('option_off'),
					 map[mapid].map_traffic_layer = 'map',
					 this.closeMapSetup(mapid)
					 ]
		
	},
	transit			: function(mapid){
			  		var check = map[mapid].map_transit_layer == 'map' ?
					 [
					 transitlayer[mapid].setMap(map[mapid]),
					 jQuery('#map_layer_transit_'+mapid).removeClass('option_off').addClass('option_on'),
					 map[mapid].map_transit_layer = 'null',
					 this.closeMapSetup(mapid)
					 ]
					 :
					 [
					 transitlayer[mapid].setMap(null),
					 jQuery('#map_layer_transit_'+mapid).removeClass('option_on').addClass('option_off'),
					 map[mapid].map_transit_layer = 'map',
					 this.closeMapSetup(mapid)
					 ]
		
	},
	streetview		: function(mapid){
						streetviewlayer[mapid].setOptions({visible:true});
					setTimeout(function(){ 
						jQuery("#map_setup_wrapper_"+mapid).removeClass( "msw_show");
						jQuery("#map_setup_"+mapid).removeClass( "ms_show");
						jQuery('#map_setup_button_'+mapid).removeClass('msb_default').addClass('msb_street_view');
						jQuery('#map_full_screen_button_'+mapid).removeClass('mfsb_default').addClass('mfsb_street_view');
					}, 1000);
						
	},
	closeMapSetup	: function(mapid){
					setTimeout(function(){ 
					jQuery("#map_setup_wrapper_"+mapid).removeClass( "msw_show");
					jQuery("#map_setup_"+mapid).removeClass( "ms_show");
					}, 1000);
	}

}


function addmarkerevent (mapid, mid){
	google.maps.event.addListener(marker[mapid][mid], 'click', function() {
		infowindow[mapid].setMap(null);
		jQuery( "#map_elevation_wrapper"+mapid ).removeClass( "mec_show");
		infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+marker[mapid][mid].markerbeschreibung + '</div>',
			position	:marker[mapid][mid].position,
		});
		if (marker[mapid][mid].markerbeschreibung != '') {
			infowindow[mapid].open(map[mapid],marker[mapid][mid]);
		}
	});
	if (marker[mapid][mid].firstinfofenster == 'checked') {
		infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+marker[mapid][mid].markerbeschreibung + '</div>',
			position	:marker[mapid][mid].position,
		});
		infowindow[mapid].open(map[mapid],marker[mapid][mid]);
	}
	google.maps.event.addListener(marker[mapid][mid], 'mouseover', function() {
		marker[mapid][mid].setOpacity(1.0);
		});
	google.maps.event.addListener(marker[mapid][mid], 'mouseout', function() {
		marker[mapid][mid].setOpacity(0.85);
		});
		
}

function  initMarkerCluster(mapid){
	if (map[mapid].marker_cluster_activ == 'true'){
		var param = map[mapid].map_cluster_icon.split("_");
			var styles = [[{
			  url: URIBase+'plugins/content/plg_content_gmap/assets/gm_cluster/'+map[mapid].map_folder_cluster_icon+'/'+map[mapid].map_cluster_icon,
			  width: param[0],
			  height: param[1],
			  textColor: '#'+param[2],
			  anchorText: [param[3],param[4]],//Y,X
			  textSize: 12
				}]];
		markercluster[mapid].setStyles(styles[0]);
		markercluster[mapid].setMaxZoom(15);
		markercluster[mapid].setGridSize(parseInt(map[mapid].marker_cluster_grid_size));
		markercluster[mapid].addMarkers(marker[mapid]);
		addclusterevent (mapid);
	}
}
function addclusterevent (mapid){
 google.maps.event.addListener(markercluster[mapid], "mouseover", function (event) {
		 var info = ('<p style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+Joomla.JText._('JS_MARKER_CLUSTER_INFO_WINDOW_PART_ONE'));
		 var cmarkers = event.getMarkers();
		 for(var i = 0; i < cmarkers.length; i++){ 
			if (i < '2'){
				info += '</br><strong>'+cmarkers[i].markertitel+'</strong>';
			}
		 }
		 if (cmarkers.length > '2'){
			 info +=Joomla.JText._('JS_MARKER_CLUSTER_INFO_WINDOW_PART_TWO');
		 }
		 
		 info += '</p>';
		infowindow[mapid].open(null);
		infowindow[mapid].setOptions(
				{
				content : info,
				disableAutoPan:true, 
				position : event.getCenter(),
				pixelOffset:new google.maps.Size(0,-15)
				});
				infowindow[mapid].open(map[mapid]);
        });
 google.maps.event.addListener(markercluster[mapid], "mouseout", function (event) {
		infowindow[mapid].open(null);
		infowindow[mapid].setOptions({pixelOffset:new google.maps.Size(0,0),disableAutoPan:false, });
        });
 google.maps.event.addListener(markercluster[mapid], "click", function (event) {
		infowindow[mapid].open(null);
		infowindow[mapid].setOptions({pixelOffset:new google.maps.Size(0,0),disableAutoPan:false, });
        });
}

function addcircleevent (mapid, cid){
	google.maps.event.addListener(circle[mapid][cid], 'click', function(event) {
		jQuery( "#map_elevation_wrapper"+mapid ).removeClass( "mec_show");
		infowindow[mapid].open(null); 
		if (circle[mapid][cid].positinfowindow == 'false'){
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+circle[mapid][cid].circlebeschreibung+ '</div>',
				position	:event.latLng,
			});
		}else{
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+circle[mapid][cid].circlebeschreibung+ '</div>',
				position	:circle[mapid][cid].positinfowindow,
			});
		}
		if (circle[mapid][cid].circlebeschreibung != '') {
			infowindow[mapid].open(map[mapid]);
		}
	});
	if (circle[mapid][cid].firstinfofenster == 'checked') {
		if (circle[mapid][cid].positinfowindow == 'false'){
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+circle[mapid][cid].circlebeschreibung+ '</div>',
				position	:circle[mapid][cid].center,
			});
		}else{
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+circle[mapid][cid].circlebeschreibung+ '</div>',
				position	:circle[mapid][cid].positinfowindow,
			});
			
		}
		infowindow[mapid].open(map[mapid]);
	}
}
function addrectangleevent (mapid, cid){
	google.maps.event.addListener(rectangle[mapid][cid], 'click', function(event) {
		jQuery( "#map_elevation_wrapper"+mapid ).removeClass( "mec_show");
		infowindow[mapid].open(null);
		if (rectangle[mapid][cid].positinfowindow == 'false'){
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+rectangle[mapid][cid].rectanglebeschreibung+ '</div>',
				position	:event.latLng,
			});
		}else{
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+rectangle[mapid][cid].rectanglebeschreibung+ '</div>',
				position	:rectangle[mapid][cid].positinfowindow,
			});
		}
		if (rectangle[mapid][cid].rectanglebeschreibung != '') {
			infowindow[mapid].open(map[mapid]);
		}
	});
	if (rectangle[mapid][cid].firstinfofenster == 'checked') {
		if (rectangle[mapid][cid].positinfowindow == 'false'){
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+rectangle[mapid][cid].rectanglebeschreibung+ '</div>',
				position	:circle[mapid][cid].center,
			});
		}else{
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+rectangle[mapid][cid].rectanglebeschreibung+ '</div>',
				position	:rectangle[mapid][cid].positinfowindow,
			});
			
		}
		infowindow[mapid].open(map[mapid]);
	}
}
function addlineevent (mapid, cid){
	line[mapid][cid].getLength = getlinelength;
	google.maps.event.addListener(linedummy[mapid][cid], 'click', function(event) {
		infowindow[mapid].open(null);
		if (line[mapid][cid].positinfowindow == 'false'){
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+line[mapid][cid].linebeschreibung+ '</div>',
				position	:event.latLng,
			});
		}else{
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+line[mapid][cid].linebeschreibung+ '</div>',
				position	:line[mapid][cid].positinfowindow,
			});
		}
		if (line[mapid][cid].linebeschreibung != '') {
			infowindow[mapid].open(map[mapid]);
		}
		if(line[mapid][cid].chartonoff == 'true'){
		setlinechart(mapid,cid);
		}
	});
	if (line[mapid][cid].firstinfofenster == 'checked') {
		if (line[mapid][cid].positinfowindow == 'false'){
			var point= line[mapid][cid].getPath().getArray();
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+line[mapid][cid].linebeschreibung+ '</div>',
				position	:point[0],
			});
		}else{
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+line[mapid][cid].linebeschreibung+ '</div>',
				position	:line[mapid][cid].positinfowindow,
			});
			
		}
		infowindow[mapid].open(map[mapid]);
	}
}

var Line ={
	setSaveStyle: function(option,Mapid, id){
		if (option == 'default' || option == '' || option === false){
			 this.setDefaultStyle(Mapid,id);
		return;
		}
		line[Mapid][id].style = option;
		line[Mapid][id].lineSymbol = {
		  anchor:(new google.maps.Point(linestyle[option].anchor_x, linestyle[option].anchor_y)), 
		  path:				linestyle[option].path,
		  strokeWeight:		linestyle[option].strokeWeight,
		  strokeOpacity:	1-linestyle[option].strokeOpacity/10,
		  strokeColor:		linestyle[option].strokeColor,
		  fillColor:		linestyle[option].fillColor,
		  fillOpacity:		1-linestyle[option].fillOpacity/10,
		  rotation:			linestyle[option].rotation,
		  scale:			line[Mapid][id].style_scale
		};
		linedummy[Mapid][id].setOptions({
					icons: [{
					icon: line[Mapid][id].lineSymbol,
					offset: line[Mapid][id].style_offset,
					repeat: line[Mapid][id].style_repeat
				}]
		});
	},
	setDefaultStyle: function(Mapid,id) {
		linedummy[Mapid][id].setOptions({
					icons: ''
		});
	},
}
function addpolygonevent (mapid, cid){
	google.maps.event.addListener(polygon[mapid][cid], 'click', function(event) {
		jQuery( "#map_elevation_wrapper"+mapid ).removeClass( "mec_show");
		infowindow[mapid].open(null);
		if (polygon[mapid][cid].positinfowindow == 'false'){
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+polygon[mapid][cid].polygonbeschreibung+ '</div>',
				position	:event.latLng,
			});
		}else{
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+polygon[mapid][cid].polygonbeschreibung+ '</div>',
				position	:polygon[mapid][cid].positinfowindow,
			});
		}
		if (polygon[mapid][cid].polygonbeschreibung != '') {
			infowindow[mapid].open(map[mapid]);
		}
	});
	if (polygon[mapid][cid].firstinfofenster == 'checked') {
		if (polygon[mapid][cid].positinfowindow == 'false'){
			var point= polygon[mapid][cid].getPath().getArray();
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+polygon[mapid][cid].polygonbeschreibung+ '</div>',
				position	:point[0],
			});
		}else{
			infowindow[mapid].setOptions({
			content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+polygon[mapid][cid].polygonbeschreibung+ '</div>',
				position	:polygon[mapid][cid].positinfowindow,
			});
			
		}
		infowindow[mapid].open(map[mapid]);
	}
}
function addkmlevent (mapid, kmlid){
 google.maps.event.addListener(kmllayer[mapid][kmlid], "click", function (event) {
		if (kmllayer[mapid][kmlid].kml_beschreibung != ''){
			kmllayer[mapid][kmlid].setOptions({suppressInfoWindows: true});
			infowindow[mapid].open(null);
			infowindow[mapid].setOptions(
					{
					content : kmllayer[mapid][kmlid].kml_beschreibung, 
					position : event.latLng,
					});
			infowindow[mapid].open(map[mapid]);		
		}
        });
}
function getlinelength(){
	var factor = 1000
	var wert = google.maps.geometry.spherical.computeLength(this.getPath());
	var	erg1 = Math.round((wert)/parseFloat(factor)*100)/100;
	var erg2 = Math.round((wert/1000)*100)/100;
	return erg2;	
}

function setlinechart(mapid,cid) {
	function plotElevation(results, status, thisline) {
	  if (status != google.maps.ElevationStatus.OK) {
		return;
	  }
		if (line[mapid][cid].chartunits == 'SI'){
			var distanz = line[mapid][cid].getLength();
			titley = Joomla.JText._('JS_CHART_TITLE_AXE_Y_HEIGHT_SI');
			titlex = Joomla.JText._('JS_CHART_TITLE_AXE_X_DISTANZ_SI')
		}else{
			var distanz = Math.round (line[mapid][cid].getLength()/parseFloat(1.609)*100)/100;
			titley = Joomla.JText._('JS_CHART_TITLE_AXE_Y_HEIGHT_ANGLO');
			titlex = Joomla.JText._('JS_CHART_TITLE_AXE_X_DISTANZ_ANGLO')
		}
	  var elevations = results;
	  var data = new google.visualization.DataTable();
	  data.addColumn('string', 'Sample');
	  data.addColumn('number', 'Höhe');
	  for (var i = 0; i < results.length; i++) {
		  if (line[mapid][cid].chartunits == 'SI'){
		 	data.addRow(['', Math.round((parseInt(elevations[i].elevation))/parseFloat(1)*100)/100]);
		  }else{
			data.addRow(['', Math.round((parseInt(elevations[i].elevation))/parseFloat(0.9144)*100)/100]);  
		  }
	  }
	  chart[mapid].draw(data, {
		height: 100,
		title: Joomla.JText._('JS_CHART_TITLE'),
		legend: { position: "none" },
		titleY: titley,
		titleX: titlex + distanz
	  });
	}

	//jQuery( "#map_elevation"+mapid ).slideUp( "slow");
	if(line[mapid][cid].chartonoff == 'true'){
		chart[mapid] = new google.visualization.LineChart(document.getElementById('map_elevation'+mapid));
		var pathRequest = {
						'path': line[mapid][cid].getPath().getArray(),
						'samples': 500
						}
		elevator[mapid].getElevationAlongPath(pathRequest, plotElevation);
		jQuery( "#map_elevation_wrapper"+mapid ).toggleClass( "mec_show");		
	}else{
		jQuery( "#map_elevation_wrapper"+mapid ).toggleClass( "mec_hidden");	
	}

}


var Box = {
	visibilityOnOff: function(mapid){
		var opt = map[mapid].getZoom();
		if (!text[mapid]){
			return;
		};
		  for(var i = 0; i < text[mapid].length; i++){
			  if (opt < text[mapid][i].range_start || opt > text[mapid][i].range_end ){
				  text[mapid][i].setMap(null);
			  } else {
				  text[mapid][i].setMap(map[mapid]); 
			  };
		  };
		  
	},
}


//////////////////////
 
ToolTip.prototype = new google.maps.OverlayView();

function ToolTip(breite, hoehe, map, latlng, text, tid, rotation) {
 
    // Now initialize all properties.
   	this.versatz_x_ = 0;
	this.versatz_y_ = 0;
	this.latlng_ = latlng;
    this.map_ = map;
	this.breite_ = breite;
	this.hoehe_ = hoehe;
 	//this.html_ = html;
	this.html_ = text;
	this.textid= tid;
    this.div_ = null;
	this.rotation = rotation;
    // Explicitly call setMap on this overlay
    this.setMap(map);
  }
 
  ToolTip.prototype.onAdd = function() {
    // Create the DIV and set some basic attributes.
    var div = document.createElement('DIV');
	div.innerHTML = this.html_;
	div.setAttribute("id", "text");
	div.setAttribute("onclick", "");
    div.style.position = "absolute";
    // Set the overlay's div_ property to this DIV
    this.div_ = div;
    // We add an overlay to a map via one of the map's panes.
    // We'll add this overlay to the overlayImage pane.
    var panes = this.getPanes();
    panes.overlayImage.appendChild(div);
  }
 
  ToolTip.prototype.draw = function() {
    var overlayProjection = this.getProjection();
   var pixPosition = this.getProjection().fromLatLngToDivPixel(this.latlng_);
  if (!pixPosition) return;
    // Resize the image's DIV to fit the indicated dimensions.
    var div = this.div_;
    div.style.left =(pixPosition.x + this.versatz_x_ ) + "px";
    div.style.top = (pixPosition.y + this.versatz_y_) + "px";
    div.style.width =this.breite_ ;
    div.style.height = this.hoehe_ + 'px';
	div.style['transform-origin'] = '0px 0px';
	div.style.transform = 'rotate('+ this.rotation +'deg)';

 
  }
 
  ToolTip.prototype.onRemove = function() {
    this.div_.parentNode.removeChild(this.div_);
    this.div_ = null;
  } 


var gmapAction ={
	MapZoom		: function(mapid,zoom){
					map[mapid].setOptions({zoom:zoom});
					if (map[mapid].marker_cluster_activ == 'true'){
						markercluster[mapid].repaint();
					}
	},
	MapMove		: function(mapid,lat,lng){
					map[mapid].setOptions({center: new google.maps.LatLng(lat,lng)});
					if (map[mapid].marker_cluster_activ == 'true'){
						markercluster[mapid].repaint();
					}
	},
	MapMoveAndZoom		: function(mapid,zoom,lat,lng){
					map[mapid].setOptions({
						zoom:zoom,
						center: new google.maps.LatLng(lat,lng),
						});
					if (map[mapid].marker_cluster_activ == 'true'){
						markercluster[mapid].repaint();
					}
	},
}

function mod_search_refresh(mapid) {
	var url = location.href
	var name = 'mid'
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var mid = regex.exec( url );
	if(!mid) {
		return ;
	 }
    mid = mid[1];
	for(var i = 0; i < marker[mapid].length; i++){
		if (marker[mapid][i].id == mid){
			infowindow[mapid].setMap(null);
			infowindow[mapid].setOptions({
				content		:'<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+marker[mapid][i].markerbeschreibung + '</div>',
				position	:marker[mapid][i].position,
			});
			map[mapid].setCenter(marker[mapid][i].position);
				if (marker[mapid][i].markerbeschreibung != '') {
					infowindow[mapid].open(map[mapid],marker[mapid][i]);
				}
		}
  	}

}

(function() {

    /**
     * Class for dimension change detection.
     *
     * @param {Element|Element[]|Elements|jQuery} element
     * @param {Function} callback
     *
     * @constructor
     */
    this.ResizeSensor = function(element, callback) {
        /**
         *
         * @constructor
         */
        function EventQueue() {
            this.q = [];
            this.add = function(ev) {
                this.q.push(ev);
            };

            var i, j;
            this.call = function() {
                for (i = 0, j = this.q.length; i < j; i++) {
                    this.q[i].call();
                }
            };
        }

        /**
         * @param {HTMLElement} element
         * @param {String}      prop
         * @returns {String|Number}
         */
        function getComputedStyle(element, prop) {
            if (element.currentStyle) {
                return element.currentStyle[prop];
            } else if (window.getComputedStyle) {
                return window.getComputedStyle(element, null).getPropertyValue(prop);
            } else {
                return element.style[prop];
            }
        }

        /**
         *
         * @param {HTMLElement} element
         * @param {Function}    resized
         */
        function attachResizeEvent(element, resized) {
            if (!element.resizedAttached) {
                element.resizedAttached = new EventQueue();
                element.resizedAttached.add(resized);
            } else if (element.resizedAttached) {
                element.resizedAttached.add(resized);
                return;
            }

            element.resizeSensor = document.createElement('div');
            element.resizeSensor.className = 'resize-sensor';
            var style = 'position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: scroll; z-index: -1; visibility: hidden;';
            var styleChild = 'position: absolute; left: 0; top: 0;';

            element.resizeSensor.style.cssText = style;
            element.resizeSensor.innerHTML =
                '<div class="resize-sensor-expand" style="' + style + '">' +
                    '<div style="' + styleChild + '"></div>' +
                '</div>' +
                '<div class="resize-sensor-shrink" style="' + style + '">' +
                    '<div style="' + styleChild + ' width: 200%; height: 200%"></div>' +
                '</div>';
            element.appendChild(element.resizeSensor);

            if (!{fixed: 1, absolute: 1}[getComputedStyle(element, 'position')]) {
                element.style.position = 'relative';
            }

            var expand = element.resizeSensor.childNodes[0];
            var expandChild = expand.childNodes[0];
            var shrink = element.resizeSensor.childNodes[1];
            var shrinkChild = shrink.childNodes[0];

            var lastWidth, lastHeight;

            var reset = function() {
                expandChild.style.width = expand.offsetWidth + 10 + 'px';
                expandChild.style.height = expand.offsetHeight + 10 + 'px';
                expand.scrollLeft = expand.scrollWidth;
                expand.scrollTop = expand.scrollHeight;
                shrink.scrollLeft = shrink.scrollWidth;
                shrink.scrollTop = shrink.scrollHeight;
                lastWidth = element.offsetWidth;
                lastHeight = element.offsetHeight;
            };

            reset();

            var changed = function() {
                if (element.resizedAttached) {
                    element.resizedAttached.call();
                }
            };

            var addEvent = function(el, name, cb) {
                if (el.attachEvent) {
                    el.attachEvent('on' + name, cb);
                } else {
                    el.addEventListener(name, cb);
                }
            };
            
            var onScroll = function() {
              if (element.offsetWidth != lastWidth || element.offsetHeight != lastHeight) {
                  changed();
              }
              reset();
            }

            addEvent(expand, 'scroll', onScroll);
            addEvent(shrink, 'scroll', onScroll);
        }

        var elementType = Object.prototype.toString.call(element);
        var isCollectionTyped = ('[object Array]' === elementType
            || ('[object NodeList]' === elementType)
            || ('[object HTMLCollection]' === elementType)
            || ('undefined' !== typeof jQuery && element instanceof jQuery) //jquery
            || ('undefined' !== typeof Elements && element instanceof Elements) //mootools
        );

        if (isCollectionTyped) {
            var i = 0, j = element.length;
            for (; i < j; i++) {
                attachResizeEvent(element[i], callback);
            }
        } else {
            attachResizeEvent(element, callback);
        }

        this.detach = function() {
            if (isCollectionTyped) {
                var i = 0, j = element.length;
                for (; i < j; i++) {
                    ResizeSensor.detach(element[i]);
                }
            } else {
                ResizeSensor.detach(element);
            }
        };
    };

    this.ResizeSensor.detach = function(element) {
        if (element.resizeSensor) {
            element.removeChild(element.resizeSensor);
            delete element.resizeSensor;
            delete element.resizedAttached;
        }
    };

})();

///////////Full Screen///////////
(function () {
	'use strict';

	var isCommonjs = typeof module !== 'undefined' && module.exports;
	var keyboardAllowed = typeof Element !== 'undefined' && 'ALLOW_KEYBOARD_INPUT' in Element;

	var fn = (function () {
		var val;
		var valLength;

		var fnMap = [
			[
				'requestFullscreen',
				'exitFullscreen',
				'fullscreenElement',
				'fullscreenEnabled',
				'fullscreenchange',
				'fullscreenerror'
			],
			// new WebKit
			[
				'webkitRequestFullscreen',
				'webkitExitFullscreen',
				'webkitFullscreenElement',
				'webkitFullscreenEnabled',
				'webkitfullscreenchange',
				'webkitfullscreenerror'

			],
			// old WebKit (Safari 5.1)
			[
				'webkitRequestFullScreen',
				'webkitCancelFullScreen',
				'webkitCurrentFullScreenElement',
				'webkitCancelFullScreen',
				'webkitfullscreenchange',
				'webkitfullscreenerror'

			],
			[
				'mozRequestFullScreen',
				'mozCancelFullScreen',
				'mozFullScreenElement',
				'mozFullScreenEnabled',
				'mozfullscreenchange',
				'mozfullscreenerror'
			],
			[
				'msRequestFullscreen',
				'msExitFullscreen',
				'msFullscreenElement',
				'msFullscreenEnabled',
				'MSFullscreenChange',
				'MSFullscreenError'
			]
		];

		var i = 0;
		var l = fnMap.length;
		var ret = {};

		for (; i < l; i++) {
			val = fnMap[i];
			if (val && val[1] in document) {
				for (i = 0, valLength = val.length; i < valLength; i++) {
					ret[fnMap[0][i]] = val[i];
				}
				return ret;
			}
		}

		return false;
	})();

	var screenfull = {
		request: function (elem) {
			var request = fn.requestFullscreen;

			elem = elem || document.documentElement;

			// Work around Safari 5.1 bug: reports support for
			// keyboard in fullscreen even though it doesn't.
			// Browser sniffing, since the alternative with
			// setTimeout is even worse.
			if (/5\.1[\.\d]* Safari/.test(navigator.userAgent)) {
				elem[request]();
			} else {
				elem[request](keyboardAllowed && Element.ALLOW_KEYBOARD_INPUT);
			}
		},
		exit: function () {
			document[fn.exitFullscreen]();
		},
		toggle: function (elem) {
			if (this.isFullscreen) {
				this.exit();
			} else {
				this.request(elem);
			}
		},
		onchange: function () {},
		onerror: function () {},
		raw: fn
	};

	if (!fn) {
		if (isCommonjs) {
			module.exports = false;
		} else {
			window.screenfull = false;
		}

		return;
	}

	Object.defineProperties(screenfull, {
		isFullscreen: {
			get: function () {
				return !!document[fn.fullscreenElement];
			}
		},
		element: {
			enumerable: true,
			get: function () {
				return document[fn.fullscreenElement];
			}
		},
		enabled: {
			enumerable: true,
			get: function () {
				// Coerce to boolean in case of old WebKit
				return !!document[fn.fullscreenEnabled];
			}
		}
	});

	document.addEventListener(fn.fullscreenchange, function (e) {
		screenfull.onchange.call(screenfull, e);
	});

	document.addEventListener(fn.fullscreenerror, function (e) {
		screenfull.onerror.call(screenfull, e);
	});

	if (isCommonjs) {
		module.exports = screenfull;
	} else {
		window.screenfull = screenfull;
	}
})();
