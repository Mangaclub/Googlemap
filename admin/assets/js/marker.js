var selectedmarkericondir = '';
var selectedmarkericonfile = '';

function showmarker()
{
	Rectangle.clearSelection();
	Circle.clearSelection();
	Line.clearSelection();
	Polygon.clearSelection();
	google.maps.event.clearListeners(map, 'click');
	Box.clearSelection();
	showtab(2)
}

function initmarkertabelle() {
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'ID');
  data.addColumn('string', Joomla.JText._('JS_MARKER_HEADER_TABLE_ICON'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_TITLE'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_EDIT'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_ACCESS_LEVEL'));
  var count = 0;
  for(var i = 0; i < marker.length; i++){
		if(marker[i].status != 'del'){
			var geticon = '<img src="../images/stories/com_gmap/' + marker[i].markericon + '" title="Icon" />';
			if(marker[i].markericon == 'standard'){
				geticon = '<img src="../administrator/components/com_gmap/assets/images/pin_rot.png" title="Standard Icon" />'
			}
			data.addRows(1);
			data.setCell(count, 0, count+1);
			data.setCell(count, 1, geticon);
			data.setCell(count, 2, marker[i].markertitel);
			data.setCell(count, 3, loadFormElement.buttonShow('Marker.moveMapToThis',i) 
			+loadFormElement.buttonDelete('Marker.delete',i)
			+loadFormElement.buttonInfoWindow('main.InfoWindowOpen',i+', marker', marker[i].firstinfofenster));
			data.setCell(count, 4, jQuery("#jform_marker_access_level option[value="+marker[i].access_group+"]").text());
		count++;
		}
		} 
 var table = new google.visualization.Table(document.getElementById('page_markertabelle'));
var view = new google.visualization.DataView(data);
  table.draw(view, {allowHtml: true, width:'100%', showRowNumber: false,cssClassNames: 'cssClassNames'});
 table.setSelection([{'row': Marker.returnSelected()}]);
}


function initmarker(){
	for(var i = 0; i < marker.length; i++){
		addmarkerevent(i);
	}
	initmarkertabelle()
}


function addmarkerevent(mid)
{
	google.maps.event.addListener(marker[mid], 'dragstart', function()
	{
		Marker.clearSelection();
		marker[mid].gmselected = 'true';
		for(var i = 0; i < marker.length; i++){
			marker[i].setOpacity(0.6);
		}
		marker[mid].setOpacity(1.0);
		dummy_marker[mid].setVisible(false);
	});
	google.maps.event.addListener(marker[mid], 'dragend', function()
	{
		
		marker[mid].status = 'isedit';
		dummy_marker[mid].setIcon(mysystemicon('element_activ_no_save.png',15,26,7,7));
		dummy_marker[mid].setPosition(marker[mid].position);
		dummy_marker[mid].setVisible(true);
		Marker.geocodeFromLatLng(mid);
		Marker.getContent(mid);
	});
	google.maps.event.addListener(marker[mid], 'click', function(event)
	{
		Marker.clearSelection();
		showmarker();
		for(var i = 0; i < marker.length; i++){
			marker[i].setOpacity(0.6);
		}
		marker[mid].setOpacity(1.0);
		marker[mid].gmselected = 'true';
		initmarkertabelle();
		dummy_marker[mid].setVisible(true);
		Marker.getContent(mid);
		Marker.getAccessLevel(mid);
		if (marker[mid].text != '' && $('jform_showelement')[6].selected){ 	
			infowindow.setOptions({
				content : '<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+marker[mid].text + '</div>',
				pixelOffset:new google.maps.Size(0, 0) 
				});
				infowindow.open(map,marker[mid]);
		}else {
			infowindow.open(null);
		}
		return;

	});
	google.maps.event.addListener(marker[mid], 'rightclick', function(event)
	{
		Marker.clearSelection();
		for(var i = 0; i < marker.length; i++){
			marker[i].setOpacity(1.0);
		}

	});

}




function newmarker()
{
	jQuery("#jform_marker_access_level option:first").attr('selected',true);
	jQuery('#jform_marker_access_level').trigger('liszt:updated');
	showsubtab (0, 'marker');
	Marker.clearSelection();
	var MarkerStart = map.getCenter();
	var newid = marker.length;
	marker[newid] = new google.maps.Marker(
	{
		map : map,
    animation : google.maps.Animation.DROP, 
	position : MarkerStart, 
    draggable : true, 
    status : 'isedit', 
    gmselected : 'true', 
    markernew : 'yes', 
    markerlat : '', 
    markerid : '', 
    markerlng : '', 
    markerort : '', 
    markerplz : '', 
    markericon : 'standard', 
    markertitel : Joomla.JText._('JS_MARKER_NEW'), 
    markerstrasse : '', 
    text : '',
	markermouseover : '',
	firstinfofenster: 'false', 
    icon : defaulticon(), 
	title: '',
	});
	dummy_marker[newid] = new google.maps.Marker(
	{
		position		: MarkerStart,
		draggable		: false,
		map				: map,
		icon		: mysystemicon('element_activ_no_save.png',15,26,7,7),
		visible: true,
	});
	if (selectedmarkericondir != ''){
    Marker.setIcon(selectedmarkericondir, selectedmarkericonfile);
  }else{
    Marker.setIcon('standard','standard');
  }
	addmarkerevent(newid);
	Marker.geocodeFromLatLng(newid);
	Marker.setAccessLevel();
}

function setmarkeredit()
{
	for(var i = 0; i < marker.length; i++)
	{
		if(marker[i].markertitel != marker[i].oldmarkertitel || marker[i].markerort != marker[i].oldmarkerort || marker[i].markerstrasse != marker[i].oldmarkerstrasse || marker[i].markerplz != marker[i].oldmarkerplz || marker[i].title != marker[i].oldtitle || marker[i].markerbeschreibung != marker[i].oldmarkerbeschreibung || marker[i].markernew == 'yes')
		{
			if(marker[i].status != 'del')
			{
				marker[i].status = 'isedit';
				Marker.returnSelected();
			}
		}
	}
}

var Marker ={
	clearSelection:function(option){
		this.setContent();
		for(var i = 0; i < marker.length; i++){
			marker[i].setOpacity(1.0);
			if (marker[i].status == 'isedit'){
				dummy_marker[i].setIcon(mysystemicon('element_passiv_no_save.png',15,26,7,7));
			}else{
				dummy_marker[i].setVisible(false);
				dummy_marker[i].setIcon(mysystemicon('element_activ.png',15,26,7,7));
			}
			  marker[i].gmselected = 'false';
			// marker[i].setOptions({draggable : true});
			  infowindow.open(null);
		}
	},	
	returnSelected: function(option){
		for(var i = 0; i < marker.length; i++){
		  if (marker[i].gmselected == 'true'){
			marker[i].setOpacity(1.0);
			dummy_marker[i].setIcon(mysystemicon('element_activ.png',15,26,7,7));
			if (marker[i].status == 'isedit'){
				dummy_marker[i].setIcon(mysystemicon('element_activ_no_save.png',15,26,7,7));
			}
			 return i; 
		  }};
		  return false;
	},
	geocodeFromLatLng: function(option){
		var lat = marker[option].position.lat();
		var lng = marker[option].position.lng();
		var latlng = new google.maps.LatLng(lat, lng);
			geocoder.geocode({'latLng' : latlng},function(results, status){
				if(status == google.maps.GeocoderStatus.OK){
					for(var i=0; i < results[0].address_components.length; i++){
						var component = results[0].address_components[i];
						if(component.types[0] == "postal_code"){
							marker[option].markerplz=component.long_name;
						}
						if(component.types[0] == "route"){
							marker[option].markerstrasse=component.long_name;
						}
						if (component.types[0] == "street_number"){
							var streetnumber = component.long_name;
						}
						if(component.types[0] == "locality"){
							marker[option].markerort=component.long_name;
						}
						if(component.types[0] == "sublocality_level_1"){
							var ot = component.long_name;
						}
					}
				}
				if (streetnumber != undefined){
					marker[option].markerstrasse += ' ' + streetnumber;	
				}
				if (ot != undefined){
					marker[option].markerort += ' OT ' + ot;	
				}
				marker[option].markerlat = lat;
				marker[option].markerlng = lng;
				Marker.getContent(option);
			})
	},
	createText: function(option){
		var text = '<p style="font-family: arial,helvetica,sans-serif; ';
			text+= 'font-size: 12px; line-height: normal; color: #000000; padding: 0px; margin: 0px;"><strong>';
			text+= $('jform_marker_titel').value + '</strong><br />' +  $('jform_marker_strasse').value + '<br />';
			text+= $('jform_marker_plz').value + ' ' + $('jform_marker_ort').value + '</p>';
		document.getElementById('jform_marker_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = text;
		showsubtab (1, 'marker');
	},
	setText: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		marker[cid].status = 'isedit';
		marker[cid].text = document.getElementById('jform_marker_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML;
		marker[cid].text = returnFullImagePath(marker[cid].text);
		infowindow.setOptions({content : '<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+marker[cid].text + '</div>'});
		infowindow.open(map,marker[cid]);
	},	
	deleteText: function(option){
		var cid =this.returnSelected();
		if (cid === false) return;
		marker[cid].status = 'isedit';
		marker[cid].text = '';
		document.getElementById('jform_marker_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML ='';
		infowindow.open(null);
	},
	createMouseOver: function(){
		var cid =this.returnSelected();
		if (cid === false) return;
		var title =jQuery("#jform_marker_titel").val() + '\n';
			title+=jQuery("#jform_marker_plz").val() + ' ' ;
			title+=jQuery("#jform_marker_ort").val();
		jQuery("#jform_marker_mouseover").val(title);
		marker[cid].title = title;
		marker[cid].status = 'isedit';
		this.returnSelected();
	},
	assumeMouseOver: function(){
		var cid =this.returnSelected();
		if (cid === false) return;
		marker[cid].title = jQuery("#jform_marker_mouseover").val();
		marker[cid].status = 'isedit';
		this.returnSelected();		
	},
	setInfoWindowOpen: function(option){
		var cid = this.returnSelectedMarker();
		if (cid === false) return;
		main.InfoWindowOpen(cid,'marker', option);
		},
	setContent: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		//marker[cid].status = 'isedit';
		marker[cid].markertitel = jQuery("#jform_marker_titel").val();
		marker[cid].markerstrasse = jQuery("#jform_marker_strasse").val();
		marker[cid].markerplz = jQuery("#jform_marker_plz").val();
		marker[cid].markerort = jQuery("#jform_marker_ort").val();
		marker[cid].markerlat = jQuery("#jform_move_lat").val();
		marker[cid].markerlng = jQuery("#jform_move_lng").val();
		marker[cid].title = jQuery("#jform_marker_mouseover").val();
		setmarkeredit();
	},
	getContent: function(option){
		jQuery("#jform_marker_titel").val(marker[option].markertitel);
		jQuery("#jform_marker_strasse").val(marker[option].markerstrasse);
		jQuery("#jform_marker_plz").val(marker[option].markerplz);
		jQuery("#jform_marker_ort").val(marker[option].markerort);
		jQuery("#jform_move_lat").val(marker[option].markerlat);
		jQuery("#jform_move_lng").val(marker[option].markerlng);
		jQuery("#jform_marker_mouseover").val(marker[option].title);
		document.getElementById('jform_marker_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = marker[option].text;
		this.getIcon(option);
		radionSetCheckedValue('jform_marker_infowindow_open',marker[option].firstinfofenster);
	},
	setAutoTypes: function(option){
		if (option == 'latlng'){
			jQuery( "#marker_address" ).css("display" ,"none");
			jQuery( "#marker_move_lat_lng" ).css("display" ,"block");
		}else{
		autocomplete.setTypes([option]);
			jQuery( "#marker_address" ).css("display" ,"block");
			jQuery( "#marker_move_lat_lng" ).css("display" ,"none");
		}
	},
	moveToLatLng: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		var latlng = new google.maps.LatLng(jQuery("#jform_move_lat").val(), jQuery("#jform_move_lng").val());
		map.setCenter(latlng);
		marker[cid].setOptions({
			position : latlng
		});
		dummy_marker[cid].setIcon(mysystemicon('element_activ_no_save.png',15,26,7,7));
		dummy_marker[cid].setPosition(marker[cid].position);
		dummy_marker[cid].setVisible(true);

	},
	moveToAddress: function(option){
		if (!option){
			option = this.returnSelected();
			if (option === false) return;
		}
		marker[option].status = 'isedit';
		var address = jQuery('#jform_marker_address').val();
			geocoder.geocode({
				'address' : address
			},
			 function(results, status){
				if(status == google.maps.GeocoderStatus.OK){
					map.setCenter(results[0].geometry.location);
					marker[option].setOptions({
						position : results[0].geometry.location
					});
					Marker.geocodeFromLatLng(option);
					dummy_marker[option].setIcon(mysystemicon('element_activ_no_save.png',15,26,7,7));
					dummy_marker[option].setPosition(marker[option].position);
					dummy_marker[option].setVisible(true);
				}
			}
			)
	},
	moveMapToThis: function(option){
		this.clearSelection();
		map.setCenter(marker[option].getPosition());
		marker[option].gmselected = 'true';
		this.getContent(option);
	},
	setIcon: function(dir, file){
		var cid = this.returnSelected();
			jQuery('#standard').removeClass('iconselect');
			jQuery('.markericon').removeClass('iconselect');
			jQuery("img[id='"+ file +"']").addClass('iconselect');
			document.imagelib.src='../images/stories/com_gmap/'+ dir + '/' + file;
			selectedmarkericondir =  dir;
			selectedmarkericonfile = file;
		if (cid === false) return;
			marker[cid].markericon = dir + '/' + file ;
			marker[cid].setOptions({icon : myicon(dir + '/' + file),});
			marker[cid].status = 'isedit';
			if (dir && file == 'standard'){
				marker[cid].markericon = 'standard';
				marker[cid].setOptions({icon : defaulticon(),});
				document.imagelib.src= URIBase+'administrator/components/com_gmap/assets/images/pin_rot.png';
			}
	},
	getIcon: function(option){
		if (marker[option].markericon != 'standard') {
			var pfadfile = marker[option].markericon.split("/");
			 document.imagelib.src = '../images/stories/com_gmap/'+ marker[option].markericon;
				var pfad = pfadfile[0];
				var file = pfadfile[1];
				jQuery('#'+pfad).prop("checked", true);
				jQuery('.markericon').removeClass('iconselect');
				gm_element('markericontreeview').scrollTop = gm_element(file).offsetTop-200;
				jQuery("img[id='"+ file +"']").addClass('iconselect');
				selectedmarkericondir =  pfad;
				selectedmarkericonfile = file;

			}else{
				document.imagelib.src = 'components/com_gmap/assets/images/pin_rot.png';
				jQuery('.markericon').removeClass('iconselect');
				jQuery('#standard').addClass('iconselect');
				selectedmarkericondir =  '';
				selectedmarkericonfile = '';

			}
	},
	setAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if(!option){
			marker[cid].access_group =	jQuery('#jform_marker_access_level option:selected').val();
		}else{
		marker[cid].access_group = option;
		}
		marker[cid].status = 'isedit';
		initmarkertabelle();
		},
	getAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		setSelectedValue('jform_marker_access_level', marker[cid].access_group);
		},
	delete: function(option) {
		if (!option){
			option = this.returnSelected();
			if (option === false) return;
		}
		marker[option].setMap(null);
		removedata('remove_marker', marker[option].marker_id);
		marker[option].status = 'del';
		dummy_marker[option].setMap(null);
		cleartxt.markertxt();
		initmarkertabelle();
	}
}

function saveallmarker(){
	var mcounter1 = 0;
	var mcounter2 = 0;
	Marker.clearSelection();
	for(var i = 0; i < marker.length; i++){
		if(marker[i].status != 'del' && marker[i].status != 'standard'){
			mcounter1 += 1;
			}
		}
	if (mcounter1 != 0){	
		for(var i = 0; i < marker.length; i++){
			if(marker[i].status != 'del' && marker[i].status != 'standard'){
				mcounter2 += 1;
				if (mcounter1 > mcounter2){
					savemarker(i);
				}else if(mcounter1 == mcounter2){
					var last ='true';
					savemarker(i, last);
				}
			}
			cleartxt.markertxt();
			marker[i].setMap(null)
			dummy_marker[i].setMap(null);
		}
	}else{
	 main.SaveProgress(14);	
	}
}


///////////////////////Cluster//////////////////////////
function addclusterevent (){
 google.maps.event.addListener(markercluster, "mouseover", function (event) {
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
		infowindow.open(null);
		infowindow.setOptions(
				{
				content : info, 
				position : event.getCenter(),
				disableAutoPan:true, 
				pixelOffset:new google.maps.Size(0, -15)
				});
			if(radioGetCheckedValue('jform_marker_cluster_info_window') == 'true'){	
				infowindow.open(map);
			}
        });
 google.maps.event.addListener(markercluster, "mouseout", function (event) {
		infowindow.open(null);
		infowindow.setOptions({disableAutoPan:false, });
        });
 google.maps.event.addListener(markercluster, "click", function (event) {
		infowindow.open(null);
		infowindow.setOptions({disableAutoPan:false, });
        });
}
var controlerMarkerCluster = {
	setClusterActiv:function(option){
		if(radioGetCheckedValue('jform_marker_cluster_activ') == 'true' && $('jform_showelement')[7].selected == false){
			Marker.clearSelection();
			this.setClusterIcon(map.folder_cluster_icon, map.cluster_icon);
			markercluster.setMaxZoom(19);
			markercluster.setGridSize(parseInt($('jform_marker_cluster_grid_size').value));
			markercluster.addMarkers(marker);
			addclusterevent ();
		}else{
			this.setClusterPassiv();
		}
	},
	setClusterPassiv:function(){
			markercluster.clearMarkers();
			for(var i = 0; i < marker.length; i++){
				marker[i].setMap(map);
			}
			google.maps.event.clearListeners(markercluster, 'mouseover');
	},
	setClusterGrid:function(){
		markercluster.setGridSize(parseInt($('jform_marker_cluster_grid_size').value));
		markercluster.repaint();
	},
	setClusterIcon:function(folder,image){
		if(image){
			var param = image.split("_");
			var styles = [[{
			  url: URIBase+'plugins/content/plg_content_gmap/assets/gm_cluster/'+folder+'/'+image,
			  width: param[0],
			  height: param[1],
			  textColor: '#'+param[2],
			  anchorText: [param[3],param[4]],//Y,X
			  textSize: 12
				}]];
			markercluster.setStyles(styles[0]);
			markercluster.repaint();
			map.folder_cluster_icon = folder;
			map.cluster_icon = image;
			}
	},
}
