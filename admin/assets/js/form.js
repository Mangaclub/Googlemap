// JavaScript Document

var loadFormElement = {
	initFormElementeEditor: function (){
		var elemente = ['marker','rectangle','circle','line','polygon','htmlbox'];
		for(var i = 0; i < elemente.length; i++){
			jQuery("#jform_"+elemente[i]+"_access_level option:first").attr('selected',true);
			jQuery("#jform_"+elemente[i]+"_access_level").trigger('liszt:updated');
		}
	},
	buttonShow: function (option1, option2){
		var button = '<a class="btn btn-mini" title="'
			button += Joomla.JText._('JS_MAIN_TABLE_BUTTON_TITLE_SHOW');
			button +='" href="javascript:void(0)" onclick="' + option1 + '('+option2+');">';
			button +='<img class="assume" src="components/com_gmap/assets/images/eye.png" ';
			button +='width="12" height="12" />';
			button +=Joomla.JText._('JS_MAIN_TABLE_BUTTON_SHOW');
			button +='</a>';
		return button;	
	},
	buttonDelete: function (option1, option2){
		var button = '<a class="btn btn-mini" title="'
			button += Joomla.JText._('JS_MAIN_TABLE_BUTTON_TITLE_DELETE');
			button +='" href="javascript:void(0)" onclick="' + option1 + '('+option2+');">';
			button +='<img class="assume" src="components/com_gmap/assets/images/reset.png" ';
			button +='width="12" height="12" />';
			button +=Joomla.JText._('JS_MAIN_TABLE_BUTTON_DELETE');
			button +='</a>';
		return button;	
	},
	buttonInfoWindow: function(option1, option2, isopen){
		if (isopen == 'checked'){
		var button = '<a class="btn btn-mini" title="'
			button += Joomla.JText._('JS_MAIN_TABLE_BUTTON_TITLE_INFOWINDOW_YES');
			button +='" href="javascript:void(0)" onclick="' + option1 + '('+option2+');">';
			button +='<img class="assume" src="components/com_gmap/assets/images/yes.png" ';
			button +='width="12" height="12" />';
			button +=Joomla.JText._('JS_MAIN_TABLE_BUTTON_INFOWINDOW');
			button +='</a>';
		return button;
		}else{
		var	button = '<a class="btn btn-mini" title="'
			button += Joomla.JText._('JS_MAIN_TABLE_BUTTON_TITLE_INFOWINDOW_NO');
			button +='" href="javascript:void(0)" onclick="' + option1 + '('+option2+');">';
			button +='<img class="assume" src="components/com_gmap/assets/images/no.png" ';
			button +='width="12" height="12" />';
			button +=Joomla.JText._('JS_MAIN_TABLE_BUTTON_INFOWINDOW');
			button +='</a>';
		return button;
		}
	},
	addMapResize:function (){
		jQuery("#map_container" ).resizable({
			stop: function( event, ui ) {
				var center = map.getCenter();
				
				google.maps.event.trigger(map, 'resize');
				 map.setCenter(center); 
				}
		});
	},
	optionElementeFilter: function (){
		jQuery("#jform_showelement_chzn").css("width","100%");
	},
}

var statusBar = {
	addMapCenter: function (){
		var statusbar = jQuery("<div>", {id: "gmap-statusbar", class: "btn-toolbar"});
		var gmap_center = jQuery("<div>", {id: "gmap-center", class: "btn-group"});
		var gmap_center_lat = jQuery("<div>", {id: "gmap-center-lat", class: "badge"});
		var gmap_center_lng = jQuery("<div>", {id: "gmap-center-lng", class: "badge"});
		var gmap_zoom = jQuery("<div>", {id: "gmap-zoom", class: "btn-group"});
		var gmap_zoom_level = jQuery("<div>", {id: "gmap-zoom-level", class: "badge"});
		jQuery("#status").prepend(statusbar);
		jQuery("#gmap-statusbar").append(gmap_center);
		jQuery("#gmap-statusbar").append(gmap_center_lat);
		jQuery("#gmap-statusbar").append(gmap_center_lng);
		jQuery("#gmap-statusbar").append(gmap_zoom);
		jQuery("#gmap-statusbar").append(gmap_zoom_level);
		jQuery("#gmap-center").html("Map Center:");
		jQuery("#gmap-zoom").html("Zoom Level:");
	},
	setMapCenter: function (){
		jQuery("#gmap-center-lat").html("Latitude: " + jQuery('#jform_map_center_lat').val());
		jQuery("#gmap-center-lng").html("Longitude: " + jQuery('#jform_map_center_lng').val());
		jQuery("#gmap-zoom-level").html(jQuery('#jform_map_zoom').val());
		google.maps.event.addListener(map, 'dragend', function() {
			var mapcenter =  map.getCenter();
			jQuery("#gmap-center-lat").html("Latitude: " + mapcenter.lat());
			jQuery("#gmap-center-lng").html("Longitude: " + mapcenter.lng());
		});
		google.maps.event.addListener(map, 'zoom_changed', function() {
			jQuery("#gmap-zoom-level").html(map.getZoom());
			Box.visibilityOnOff();
		});
	}
}


var modalDialog = {
	markerAutocomplete: function (){
		jQuery("#marker-dialog").html(Joomla.JText._('JS_DIALOG_MARKER_NOT_SELECTED'));
		jQuery( "#dialog-confirm" ).dialog({
			resizable: false,
			autoOpen: false,
			width:400,
			modal: true,
			title: Joomla.JText._('JS_DIALOG_QUEST'),
			buttons: [{
				text : Joomla.JText._('JS_DIALOG_MARKER_CREATE_NEW'),
				click: function() {
						if (place.geometry.viewport) {
								map.fitBounds(place.geometry.viewport);
							} else {
								map.setCenter(place.geometry.location);
							}
						newmarker();
						jQuery( this ).dialog( "close" );
						}
				},{
				text : 	Joomla.JText._('JS_DIALOG_CANCEL'),
				click: function() {
						jQuery( this ).dialog( "close" );
					}
				}]
		});
	},
}
var Core = {
	checkVar: function (gm_var, gm_default){
		return (typeof gm_var == 'undefined' ? gm_default : gm_var);
	},
}

function gm_element(ele){
var my_gm_element = document.getElementById(ele);
return my_gm_element;
}

function getSelectedOption( frmName, srcListName ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );

	i = srcList.selectedIndex;
	if (i != null && i > -1) {
		return srcList.options[i];
	} else {
		return null;
	}
}

function setSelectedValue(srcListName, value ) {
	var srcLen = jQuery("select#"+srcListName+" option").size();
	for (var i=0; i < srcLen; i++) {
		jQuery("select#"+srcListName+" option").attr('selected',false);
	}
	jQuery("#"+srcListName+" option[value="+value+"]").attr('selected',true);
	jQuery('#'+srcListName).trigger('liszt:updated');
}

function getSelectedValue( frmName, srcListName ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );

	i = srcList.selectedIndex;
	if (i != null && i > -1) {
		return srcList.options[i].value;
	} else {
		return null;
	}
}

function getSelectedText( frmName, srcListName ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );

	i = srcList.selectedIndex;
	if (i != null && i > -1) {
		return srcList.options[i].text;
	} else {
		return null;
	}
}

function radioGetCheckedValue(radioObj,convert) {
		if (jQuery('#'+ radioObj+'0').is(':checked')) {
			if (convert == 'true45'){
				return 45;
			}
			if (convert == 'true'){
				return true;
			}else{
				return jQuery('#'+ radioObj+'0').val();	
			}
		} else {
			if (convert == 'true45'){
				return 0;
			}
			if (convert == 'true'){
				return false;
			}else{
				return jQuery('#'+ radioObj+'1').val();	
			}
		}
}

function radionSetCheckedValue(radioObj,option){
	if (option == 'true' || option == 'checked' || option == 'SI'|| option == '1'){
		jQuery('#'+ radioObj+'0').next('label').addClass('btn active btn-success');
		jQuery('#'+ radioObj+'0').prop("checked", true);
		jQuery('#'+ radioObj+'1').next('label').removeClass('active btn-success');
		jQuery('#'+ radioObj+'1').next('label').addClass('btn');
		jQuery('#'+ radioObj+'1').prop("checked", false);
	} else if (option == 'false' || option == '' || option == 'ANGLO' || option == '3'){
		jQuery('#'+ radioObj+'0').next('label').removeClass('btn active btn-success');
		jQuery('#'+ radioObj+'0').next('label').addClass('btn');
		jQuery('#'+ radioObj+'0').prop("checked", false);
		jQuery('#'+ radioObj+'1').next('label').addClass('btn active btn-success');
		jQuery('#'+ radioObj+'1').prop("checked", true);
	}
}
