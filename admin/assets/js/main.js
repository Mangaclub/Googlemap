// JavaScript Document
var progresswert = 0;
var saveprogresswert = 0;
jQuery(document).ready(function(){
	jQuery('#gm-toolbar').insertAfter('.header');
	jQuery('div').remove('.subhead-collapse');

});
function initialize() {
	
	progress(0,'#loadbar');
	statusBar.addMapCenter();	
	loadFormElement.optionElementeFilter();
	loadFormElement.initFormElementeEditor();
	if (jQuery('#jform_map_width').val() != '') {
		jQuery('#map_container').css("width" , jQuery('#jform_map_width').val());
		jQuery('#map_container').css("height" , jQuery('#jform_map_height').val());
	}

	if (jQuery('#jform_map_center_lat').val() == '') {
				setmapoption.defaultMapOption();
	}
	modalDialog.markerAutocomplete();
	google.maps.controlStyle = 'azteca';
	map = new google.maps.Map(document.getElementById('map'), init_map_option());
	map.folder_cluster_icon = jQuery('#jform_map_folder_cluster_icon').val() || 'gm_cluster_adefault';
	map.cluster_icon = jQuery('#jform_map_cluster_icon').val() || 'default.png';
	map.mapTypes.set("osm", new google.maps.ImageMapType({
		getTileUrl: function(coord, zoom) {
			return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
		},
		tileSize: new google.maps.Size(256, 256),
		name: "OpenStreetMap",
		maxZoom: 18
	}));
	bike_layer = new google.maps.BicyclingLayer();
	traffic_layer = new google.maps.TrafficLayer();
	transit_layer = new google.maps.TransitLayer();
	streetview_layer = map.getStreetView();
	geocoder = new google.maps.Geocoder();
	infowindow = new google.maps.InfoWindow();
	elevator = new google.maps.ElevationService();
	markercluster = new MarkerClusterer(map);
	autocomplete = new google.maps.places.Autocomplete(document.getElementById('jform_marker_address'));
  		autocomplete.bindTo('bounds', map);
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		var markerId = Marker.returnSelected();
		if (markerId === false){
			jQuery( "#dialog-confirm" ).dialog( "open" );
			return place = autocomplete.getPlace();
		}else {
			Marker.moveToAddress(markerId);
		 place = autocomplete.getPlace();
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		} else {
			map.setCenter(place.geometry.location);
		}
		}
	});
	var lang;
	var check = jQuery('#jform_custom_map_language').val() == '' ?
		[
		lang = getSelectedValue('adminForm', 'jform_map_language')
		]:[
		lang = jQuery('#jform_custom_map_language').val(),
		jQuery('#jform_custom_map_language').css("visibility",'visible'),
		]
	;

		getlang('gm_lang', 'form_ajax_lang', 'raw', 'getlang', lang);//View, Layout, Format, Ziel, Lang
		getLineStyle('gm_editor', 'form_ajax_line_style', 'raw');//View, Layout, Format
				
	google.maps.event.addListener(map, 'tilesloaded', function() {
		
		loadFormElement.addMapResize();
			Map.addSetupButton();
		//Karten Optionen Laden//
		setmapoption.map_scrollwheel(radioGetCheckedValue('jform_map_scrollwheel', 'true'));
		setmapoption.map_DoubleClickZoom(radioGetCheckedValue('jform_map_DoubleClickZoom', 'true'));
		setmapoption.map_overview_map(radioGetCheckedValue('jform_map_overview_map', 'true'));
		setmapoption.map_overview_map_open(radioGetCheckedValue('jform_map_overview_map_open', 'true'));
		setmapoption.map_draggable(radioGetCheckedValue('jform_map_draggable', 'true'));
		setmapoption.map_panControl(radioGetCheckedValue('jform_map_panControl', 'true'));
		setmapoption.map_zoomControl(radioGetCheckedValue('jform_map_zoomControl'));
		setmapoption.map_ZoomControlStyle(getSelectedValue('adminForm', 'jform_map_ZoomControlStyle'));
		setmapoption.map_scaleControl(radioGetCheckedValue('jform_map_scaleControl', 'true'));
		setmapoption.streetViewControl(radioGetCheckedValue('jform_streetViewControl', 'true'));
		setmapoption.map_minzoom(jQuery('#jform_map_minzoom').val());
		setmapoption.map_maxzoom(jQuery('#jform_map_maxzoom').val());
		//Steuerbutton Optionen laden///
		setmapoption.map_setup_button(radioGetCheckedValue('jform_map_setup_button'));
		setmapoption.map_typ_control_button(radioGetCheckedValue('jform_map_typ_control_button'));
		setmapoption.map_layer_button(radioGetCheckedValue('jform_map_layer_button'));
		//Layer Optionen laden//
		setmapoption.satellite_view_45_heading(getSelectedValue('adminForm', 'jform_map_satellite_view_45_heading'));
		setmapoption.map_satellite_45(radioGetCheckedValue('jform_map_satellite_view_45', 'true45'));
		setmapview.maptyp(getSelectedValue('adminForm', 'jform_map_maptype'));
		setmapview.map_bike_layer(radioGetCheckedValue('jform_map_bike_layer'));
		setmapview.map_traffic_layer(radioGetCheckedValue('jform_map_traffic_layer'));
		setmapview.map_transit_layer(radioGetCheckedValue('jform_map_transit_layer'));
		Map.addOpenStreetCopyRight();
		//StreetView laden//
		map_streetview.loadsaveddata();
		//togglemapsetupview();
		drawingManager = new google.maps.drawing.DrawingManager({
			  drawingControl: false,
			});
		drawingManager.setMap(map);
	getdata('gm_editor', 'form_ajax_marker', 'raw', 'getallmarker','');//View, Layout, Format, Ziel, Lang
	getdata('gm_editor', 'form_ajax_rectangle', 'raw', 'getallrectangle', '');//View, Layout, Format, Ziel, Lang
	getdata('gm_editor', 'form_ajax_circle', 'raw', 'getallcircle','');//View, Layout, Format, Ziel, Lang
	getdata('gm_editor', 'form_ajax_line', 'raw', 'getallline','');//View, Layout, Format, Ziel, Lang
	getdata('gm_editor', 'form_ajax_polygon', 'raw', 'getallpolygon','');//View, Layout, Format, Ziel, Lang
	getdata('gm_editor', 'form_ajax_htmlbox', 'raw', 'getalltexte','');//View, Layout, Format, Ziel, Lang
	getkml('gm_editor', 'form_ajax_kml', 'raw');//View, Layout, Format
	
	google.maps.event.clearListeners(map, 'tilesloaded');
	});
	statusBar.setMapCenter();
	
}

function progress(wert, bar) {
	progresswert = progresswert + wert;
	var progressbar = jQuery( bar ), progressLabel = jQuery( ".progress-label");
	progressbar.progressbar({
				value: false,
				change: function() {
						progressLabel.text( progressbar.progressbar( "value" ) + "%" );
						},
				complete: function() {
						progressLabel.text( "Complete!" );
						}
		});
	progressbar.progressbar( "value", progresswert );
	if (progresswert == 100){
		jQuery( bar ).slideUp( "slow");
		document.getElementById("map").style.visibility='visible';
	}
};

function myicon(icon){
	var icon = new google.maps.MarkerImage(URIBase+'images/stories/com_gmap/' + icon);
	return icon;
	}

function returnFullImagePath (string){
	var newImageString = 'src="' + URIBase + 'images';
	var newString = string.replace(/src="images/g, newImageString);
	return newString;	
}
var main ={
		ButtonInfoWindowPosition: function(action, parameter){
						var buttonlink;
							buttonlink = '<a class="btn btn-mini" title="'
							buttonlink += Joomla.JText._('JS_MAIN_TABLE_BUTTON_TITLE_INFOWINDOW_POSITION');
							buttonlink +='" href="#" onclick="';
							buttonlink += action;
							buttonlink +='(';
							buttonlink +=parameter;
							buttonlink +=');">';
							buttonlink +='<img class="assume" src="components/com_gmap/assets/images/yes.png" ';
							buttonlink +='width="12" height="12" />';
							buttonlink +=Joomla.JText._('JS_MAIN_TABLE_BUTTON_INFOWINDOW_POSITION');
							buttonlink +='</a>';
						return buttonlink;	
		},
		InfoWindowOpen: function(id, gmelement, option){
						var element = eval(gmelement);
						var status = element[id].firstinfofenster;
						for(var i = 0; i < marker.length; i++){
							if (marker[i].firstinfofenster == 'checked'){
								marker[i].firstinfofenster = '';
								marker[i].status = 'isedit';
							}
						}
						for(var i = 0; i < rectangle.length; i++){
							if (rectangle[i].firstinfofenster == 'checked'){
								rectangle[i].firstinfofenster = '';
								rectangle[i].status = 'isedit';
							}
						}
						for(var i = 0; i < circle.length; i++){
							if (circle[i].firstinfofenster == 'checked'){
								circle[i].firstinfofenster = '';
								circle[i].status = 'isedit';
							}
						}
						for(var i = 0; i < line.length; i++){
							if (line[i].firstinfofenster == 'checked'){
								line[i].firstinfofenster = '';
								line[i].status = 'isedit';
							}
						}
						for(var i = 0; i < polygon.length; i++){
							if (polygon[i].firstinfofenster == 'checked'){
								polygon[i].firstinfofenster = '';
								polygon[i].status = 'isedit';
							}
						}
						if (status == 'checked'){
							element[id].firstinfofenster = '';
							element[id].status = 'isedit';
						}else{
							element[id].firstinfofenster = 'checked';
							element[id].status = 'isedit';
						};
						initmarkertabelle();
						initrectangletabelle();
						initcircletabelle();
						initlinetabelle();
						initpolygontabelle();
						if (gmelement == 'rectangle'){
							//getrectangleoption(id);
						}
						if (gmelement == 'circle'){
							//getcircleoption(id);
						}
						if (gmelement == 'line'){
							controlerLine.getLineParameter(id);
						}
						if (gmelement == 'polygon'){
							//polygon[id].setFormOption();
						}
		},
		ShowElement: function(){
			
				if (gm_element('jform_showelement')[0].selected){
					for(var i = 0; i < marker.length; i++){marker[i].setVisible(false)}
					Marker.clearSelection();
				}else{
					for(var i = 0; i < marker.length; i++){
						if(marker[i].status != 'del'){marker[i].setVisible(true)}
					}
				}
				if (gm_element('jform_showelement')[1].selected){
					for(var i = 0; i < rectangle.length; i++){rectangle[i].setVisible(false)}
					Rectangle.clearSelection();
				}else{
					for(var i = 0; i < rectangle.length; i++){
						if(rectangle[i].status != 'del'){rectangle[i].setVisible(true)}
					}
				}
				if (gm_element('jform_showelement')[2].selected){
					for(var i = 0; i < circle.length; i++){circle[i].setVisible(false)}
					Circle.clearSelection();
				}else{
					for(var i = 0; i < circle.length; i++){
						if(circle[i].status != 'del'){circle[i].setVisible(true)}
					}
				}
				if (gm_element('jform_showelement')[3].selected){
					for(var i = 0; i < line.length; i++){line[i].setVisible(false)}
					Line.clearSelection();
				}else{
					for(var i = 0; i < line.length; i++){
						if(line[i].status != 'del'){line[i].setVisible(true)}
					}
				}
				if (gm_element('jform_showelement')[4].selected){
					for(var i = 0; i < polygon.length; i++){polygon[i].setVisible(false)}
					Polygon.clearSelection();
				}else{
					for(var i = 0; i < polygon.length; i++){
						if(polygon[i].status != 'del'){polygon[i].setVisible(true)}
					}
				}
				Box.visibilityOnOff();
//				if (gm_element('jform_showelement')[5].selected){
//						Box.clearSelection();
//						for(var i = 0; i < boxmarker.length; i++){boxmarker[i].setVisible(false);box[i].setMap(null);}
//					}else{
//						for(var i = 0; i < boxmarker.length; i++){
//							if(boxmarker[i].status != 'del'){boxmarker[i].setVisible(true);box[i].setMap(map);}
//						}
//						Box.clearSelection();
//					}
				if (gm_element('jform_showelement')[7].selected){
					markercluster.clearMarkers();
					for(var i = 0; i < marker.length; i++){
						marker[i].setMap(map);
					}
					google.maps.event.clearListeners(markercluster, 'mouseover');
				}else{
					controlerMarkerCluster.setClusterActiv();
					}
			},//ende ShowElement
			SaveAllElements: function(wert){
				saveprogresswert=0;
				save_map();
				saveallmarker();
				saveallrectangle();
				saveallcircle();
				saveallline();
				saveallpolygon();
				savealltext();
			},
			SaveProgress: function(wert){
				saveprogresswert = saveprogresswert+wert
				var progressbar = jQuery("#savebar"), progressLabel = jQuery( ".progress-label2");
				progressLabel.text( "Save..." );
				progressbar.progressbar({
							value: false,
							change: function() {
									progressLabel.text( progressbar.progressbar("value") + "%" );
									},
							complete: function() {
									progressLabel.text( "Complete!" );
									setTimeout(function () {
										document.getElementById('progress-label2').innerHTML = '';  
									 	jQuery( "#savebar" ).progressbar("destroy");
										}, 1000);
									}
					});
				progressbar.progressbar( "value", saveprogresswert );
			}
}
function defaulticon(){
	var icon = new google.maps.MarkerImage(URIBase+'administrator/components/com_gmap/assets/images/pin_rot.png');
	return icon;
	}
function mysystemicon(icon, sizex, sizey, versatzx, versatzy){
	var icon = new google.maps.MarkerImage(URIBase+'administrator/components/com_gmap/assets/images/' + icon,
	new google.maps.Size(sizex, sizey),
	new google.maps.Point(0,0),
	new google.maps.Point(versatzx, versatzy)
	);   
	return icon;
	}
	
var cleartxt = {
    markertxt: function(){
        jQuery('#jform_marker_titel').val('');
        jQuery('#jform_marker_ort').val('');
        jQuery('#jform_marker_plz').val('');
        jQuery('#jform_marker_strasse').val('');
        jQuery('#jform_marker_lat').val('');
        jQuery('#jform_marker_lng').val('');
		jQuery('#jform_marker_mouseover').val('');
		document.getElementById('jform_marker_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = '';
        },
    recangletxt: function(){
        jQuery('#jform_rectangle_marker1').val('');
        jQuery('#jform_rectangle_marker2').val('');
        },
    circletxt: function(){
        jQuery('#jform_circle_marker1').val('');
        jQuery('#jform_circle_radius').val('');
        },    
    linetxt: function(){
        jQuery('#jform_line_title').val('');
       // clearpointliste ();
        },
    texttxt: function(){
		document.getElementById('jform_text_box_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML =  '';   
		}
}	
//Methode
function getinfowindow(posit,element,tab){
	if (posit != 'default'){
		this.temppositinfowindow = posit.latLng;
	}
	
	if (this.positinfowindow != 'false'){
		infowindow.setOptions(
				{
				content : '<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+this.text+'</div>', 
				position : this.positinfowindow,
				pixelOffset:new google.maps.Size(0, 0)
				});
	}else{
		var addlink = main.ButtonInfoWindowPosition(element+'.setInfoWindowPosition');
		infowindow.setOptions(
				{
				content : '<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+this.text+addlink+'</div>', 
				position : this.temppositinfowindow,
				pixelOffset:new google.maps.Size(0, 0)
				});
	}
	if (this.text != '' && jQuery('#jform_showelement').val() == 'infowindow'){ 	
		infowindow.open(map);	
	}else {
		infowindow.open(null);
	}
}
//Methode
function getbuttonwindow(posit){
			infowindow.setOptions(
					{
					content : this.text, 
					position : posit.latLng,
					});
			infowindow.open(map);	
}


