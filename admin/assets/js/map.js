var mapsetup='on';

function init_map_option(){
	var option = {
			zoom: eval(jQuery('#jform_map_zoom').val()),
			mapTypeControl: false,
			center: new google.maps.LatLng(jQuery('#jform_map_center_lat').val(),jQuery('#jform_map_center_lng').val()),
						};
		return option;
}


var setmapoption ={
	
	defaultMapOption : function (){
		jQuery('#jform_map_center_lat').val(jQuery('#default_lat').val());
		jQuery('#jform_map_center_lng').val(jQuery('#default_lng').val());
		jQuery('#jform_map_zoom').val(jQuery('#default_zoom').val());
	},
	map_satellite_45			:function(option){map.setTilt(eval(option));},
	satellite_view_45_heading	:function(option){map.setHeading(eval(option));},
	map_scrollwheel				:function(option){map.setOptions({scrollwheel:option});},
	map_DoubleClickZoom			:function(option){map.setOptions({disableDoubleClickZoom:option});},
	map_overview_map			:function(option){map.setOptions({overviewMapControl:option});},
	map_overview_map_open		:function(option){map.setOptions({overviewMapControlOptions:{opened : option},});},
	map_draggable				:function(option){map.setOptions({draggable:option});},
	map_panControl				:function(option){map.setOptions({panControl:option});},
	map_zoomControl				:function(option){map.setOptions({zoomControl:option});},
	map_ZoomControlStyle		:function(option){map.setOptions({zoomControlOptions:{style : eval(option)}});},
	map_scaleControl			:function(option){map.setOptions({scaleControl:option});},
	streetViewControl			:function(option){map.setOptions({streetViewControl:option});},
	map_minzoom					:function(option){map.setOptions({minZoom:eval(option)});},
	map_maxzoom					:function(option){map.setOptions({maxZoom:eval(option)});},
	map_zoom					:function(option){map.setOptions({zoom:eval(option)});},
	map_center_lat				:function(option){map.setOptions({
									center :new google.maps.LatLng(option,eval(jQuery('#jform_map_center_lng').val()))});},
	map_center_lng				:function(option){map.setOptions({
									center :new google.maps.LatLng(eval(jQuery('#jform_map_center_lat').val()),option)});},
	language					:function(option){
									var check = option == '0' ?
										[
										jQuery('#jform_custom_map_language').css('visibility','visible'),
										jQuery('#jform_custom_map_language').focus(), 
										]:[
										jQuery('#jform_custom_map_language').css('visibility','hidden'),
										jQuery('#jform_custom_map_language').val('')
										]
								},
	map_setup_button			:function(option){
		jQuery('#map_setup_button').css('display', option);
	},
	map_typ_control_button		:function(option){
		jQuery('#map_option_list_1').css('display', option);
	},
	map_layer_button			:function(option){
		jQuery('#map_option_list_2').css('display', option);
	},
	map_streetviewcontrol		:function(option){map.setOptions({streetViewControl:option});},

}
var Map = {
	addFullScreenButton: function(){
		var $wrapper = jQuery("<div>", {id: "map_full_screen_button", class: "map_full_screen_button mfsb_default"});
		jQuery("#map").append($wrapper);
		jQuery("#map_full_screen_button").click(function() {
			Map.toggleFullScreen(mapid);
		});
	},
	toggleFullScreen: function(){
		screenfull.toggle(jQuery('#map')[0]);
	},
	addSetupButton: function(mapid){
		var $wrapper = jQuery("<div>", {id: "map_setup_button", class: "map_setup_button msb_default", onclick: "Map.toggleMsb()"});
			jQuery("#map").append($wrapper);
		var $wrapper = jQuery("<div>", {id: "map_setup_wrapper", class: "map_setup_wrapper msw_hidden", onclick: "Map.toggleMsw()"});
			jQuery("#map").append($wrapper);
		var $wrapper = jQuery("<div>", {id: "map_setup", class: "map_setup ms_hidden"});
			jQuery("#map").append($wrapper);
			jQuery("#map_setup").html(maplang['map_button_html']);
	},
	toggleMsb: function(){
			jQuery("#map_setup_wrapper").toggleClass( "msw_show");
			jQuery("#map_setup").toggleClass( "ms_show");
	},
	toggleMsw: function(){
			jQuery("#map_setup_wrapper").toggleClass( "msw_show");
			jQuery("#map_setup").toggleClass( "ms_show");
	},
	addOpenStreetCopyRight: function(){
		var osmr = new Element('div', {
			'id' : 'map_osm',
			'class' : 'osm_right display_off'
		});
		osmr.innerHTML ='&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
		map.controls[google.maps.ControlPosition.BOTTOM_RIGHT].push(osmr);
	},
}
////////////action vom steuerbutton////

var setmapview ={
	maptyp		: function(button){
					jQuery('#map_option_roadmap').removeClass('option_on').addClass('option_off');
					jQuery('#map_option_terrain').removeClass('option_on').addClass('option_off'); 
					jQuery('#map_option_satellite').removeClass('option_on').addClass('option_off');
					jQuery('#map_option_hybrid').removeClass('option_on').addClass('option_off');
					jQuery('#map_option_osm').removeClass('option_on').addClass('option_off');   
					jQuery('#map_option_'+button).removeClass('option_off').addClass('option_on');
					jQuery('#map_osm').removeClass('display_on').addClass('display_off');
					map.setOptions({mapTypeId:button});
					if (button == 'satellite' || button == 'hybrid'){
						jQuery( "#satellite_view_45" ).slideDown( "slow");
					}else{
						jQuery( "#satellite_view_45" ).slideUp( "slow");
					}
					if (button == 'osm'){
						jQuery('#map_osm').removeClass('display_off').addClass('display_on');
					}
				  },
	map_bike_layer: function(option){
						if(option == 'null'){
							bike_layer.setMap(null);
							jQuery('#map_layer_bike').removeClass('option_on').addClass('option_off');
							return;
						}
						if(option == 'map'){
							bike_layer.setMap(map);
							jQuery('#map_layer_bike').removeClass('option_off').addClass('option_on');
							return;
						}
			  		var check = bike_layer.getMap() == null ?
					 [
					 bike_layer.setMap(map),
					 jQuery('#map_layer_bike').removeClass('option_off').addClass('option_on'),
					 ]:[
					 bike_layer.setMap(null),
					 jQuery('#map_layer_bike').removeClass('option_on').addClass('option_off'),
					 ]},

	map_traffic_layer: function(option){
						if(option == 'null'){
							traffic_layer.setMap(null);
							jQuery('#map_layer_traffic').removeClass('option_on').addClass('option_off');
							return;
						}
						if(option == 'map'){
							traffic_layer.setMap(map);
							jQuery('#map_layer_traffic').removeClass('option_off').addClass('option_on');
							return;
						}
			  		var check = traffic_layer.getMap() == null ?
					 [
					 traffic_layer.setMap(map),
					 jQuery('#map_layer_traffic').removeClass('option_off').addClass('option_on'),
					 ]:[
					 traffic_layer.setMap(null),
					 jQuery('#map_layer_traffic').removeClass('option_on').addClass('option_off'),
					 ]},
	map_transit_layer: function(option){
						if(option == 'null'){
							transit_layer.setMap(null);
							jQuery('#map_layer_transit').removeClass('option_on').addClass('option_off');
							return;
						}
						if(option == 'map'){
							transit_layer.setMap(map);
							jQuery('#map_layer_transit').removeClass('option_off').addClass('option_on');
							return;
						}
			  		var check = transit_layer.getMap() == null ?
					 [
					 transit_layer.setMap(map),
					 jQuery('#map_layer_transit').removeClass('option_off').addClass('option_on'),
					 ]:[
					 transit_layer.setMap(null),
					 jQuery('#map_layer_transit').removeClass('option_on').addClass('option_off'),
					 ]},
	map_streetview_layer: function(){
					 streetview_layer.setVisible(true)
						},
}


//////////Refresh der Karte auf Backendwerte////////////
function setmapcenter () {
	var mapcenter = new google.maps.LatLng(jQuery('#jform_map_center_lat').val(),jQuery('#jform_map_center_lng').val());
	map.setOptions({
		center: mapcenter,
		minZoom:parseInt(jQuery('#jform_map_minzoom').val()),
		maxZoom:parseInt(jQuery('#jform_map_maxzoom').val()),
		zoom: parseInt(jQuery('#jform_map_zoom').val())
		})
}
//////////Übernahme der Kartenwerte ins Backend///////////
function getmapcenter () {
	var mapcenter =  map.getCenter();
	jQuery('#jform_map_center_lat').val(mapcenter.lat());
	jQuery('#jform_map_center_lng').val(mapcenter.lng());
	
}
////////////Übernahme der Zoom Kartenwerte ins Backend/////////
var setzoom ={
	map_zoom			:function(option){jQuery('#jform_map_zoom').val(map.getZoom());},
	map_minzoom			:function(option){jQuery('#jform_map_minzoom').val(map.getZoom());
											map.setOptions({minZoom: map.getZoom()});},
	map_maxzoom			:function(option){jQuery('#jform_map_maxzoom').val(map.getZoom());
											map.setOptions({maxZoom: map.getZoom()});},
	reset_zoom			:function(option){map.setOptions({minZoom: null,maxZoom: null,})
											jQuery('#jform_map_minzoom').val('');
											jQuery('#jform_map_maxzoom').val('');},
}


//////////////////////////////streetview///////////////////////////////////////
var map_streetview ={
	loadsaveddata		:function(option){
						if(jQuery('#jform_street_view_center_lat').val() != ''){
							var mapcenter = new google.maps.LatLng(jQuery('#jform_street_view_center_lat').val(),
																	jQuery('#jform_street_view_center_lng').val());
								streetview_layer.setPosition(mapcenter);
								streetview_layer.setPov({
													heading:parseFloat(jQuery('#jform_street_view_heading').val()),
													zoom:	parseInt(jQuery('#jform_street_view_zoom').val()),
													pitch:	parseFloat(jQuery('#jform_street_view_pitch').val())
													});
									jQuery('#jform_street_view_activ').show();
									jQuery('#jform_street_view_activ-lbl').show();
									jQuery('#map_layer_streetview').removeClass('display_off').addClass('option_off');
						}else{
									jQuery('#jform_street_view_activ').hide();
									jQuery('#jform_street_view_activ-lbl').hide();
									jQuery('#map_layer_streetview').removeClass('option_off').addClass('display_off');
						}
					},
	getfrommap		:function(option){
							if 	(center = streetview_layer.getPosition()){
								if (center.lat() && center.lng() != '') {
									jQuery('#jform_street_view_center_lat').val(center.lat());
									jQuery('#jform_street_view_center_lng').val(center.lng());
									jQuery('#jform_street_view_heading').val(streetview_layer.getPov().heading);
									jQuery('#jform_street_view_pitch').val(streetview_layer.getPov().pitch);
									jQuery('#jform_street_view_zoom').val(streetview_layer.getPov().zoom);
									jQuery('#jform_street_view_activ').show();
									jQuery('#jform_street_view_activ-lbl').show();
									jQuery('#map_layer_streetview').removeClass('display_off').addClass('option_off');
								}
							}
					},
	delete_view		:function(option){
							jQuery('#jform_street_view_center_lat').val('');
							jQuery('#jform_street_view_center_lng').val('');
							jQuery('#jform_street_view_heading').val('');
							jQuery('#jform_street_view_pitch').val('');
							jQuery('#jform_street_view_zoom').val('');
							streetview_layer.setOptions({visible:false});
							jQuery('#jform_street_view_activ').hide();
							jQuery('#jform_street_view_activ-lbl').hide();
							jQuery('#map_layer_streetview').removeClass('display_off').addClass('option_off');
					},
	refresh_view	:function(option){
						if(jQuery('#jform_street_view_center_lat').val() != ''){
							var mapcenter = new google.maps.LatLng(jQuery('#jform_street_view_center_lat').val(),
																	jQuery('#jform_street_view_center_lng').val());
								streetview_layer.setPosition(mapcenter);
								streetview_layer.setPov({
													heading:parseFloat(jQuery('#jform_street_view_heading').val()),
													zoom:	parseInt(jQuery('#jform_street_view_zoom').val()),
													pitch:	parseFloat(jQuery('#jform_street_view_pitch').val())
													});
								streetview_layer.setOptions({visible:true});
						}
		},
}
