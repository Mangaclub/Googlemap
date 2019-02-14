// JavaScript Document

function showpolygon()
{
	Box.clearSelection();
	Rectangle.clearSelection();
	Circle.clearSelection();
	Marker.clearSelection();
	Line.clearSelection();
	showtab(6);
	google.maps.event.clearListeners(map, 'click');
}


function initpolygon()
{
	for(var i = 0; i < polygon.length; i++)
	{
		//add new Methods
		polygon[i].getLength = getpolygonlength;
		polygon[i].getArea = getpolygonarea;
		polygon[i].getInfoWindow = getinfowindow;
		//ende
		
		addpolygonevent(i);
		for(var p = 0; p < polygonmarker[i].length; p++)
		{
			addpolygonmarkerevent(i, p);
		}
	}
	initpolygontabelle();
	Polygon.clearSelection();

}

function initpolygontabelle() {
  var data = new google.visualization.DataTable();
	data.addColumn('number', 'ID');
	data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_TITLE'));
	data.addColumn('string', Joomla.JText._('JS_POLYGON_HEADER_TABLE_LINE_LENGTH'));
	data.addColumn('string', Joomla.JText._('JS_POLYGON_HEADER_TABLE_AREA'));
	data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_EDIT'));
	data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_ACCESS_LEVEL'));
  var count = 0;
  for(var i = 0; i < polygon.length; i++){
		if(polygon[i].status != 'del'){
			data.addRows(1);
			data.setCell(count, 0, i+1);
			data.setCell(count, 1, polygon[i].polygontitel);
			data.setCell(count, 2, polygon[i].getLength()+' km');
			data.setCell(count, 3, polygon[i].getArea()+' km²');
			data.setCell(count, 4, loadFormElement.buttonShow('Polygon.moveMapToThis',i) 
			+loadFormElement.buttonDelete('Polygon.delete',i)
			+loadFormElement.buttonInfoWindow('main.InfoWindowOpen',i+', polygon', polygon[i].firstinfofenster));
			data.setCell(count, 5, jQuery("#jform_polygon_access_level option[value="+polygon[i].access_group+"]").text());
		count++;
		}
		} 
 var table = new google.visualization.Table(document.getElementById('page_polygontabelle'));
var view = new google.visualization.DataView(data);
  table.draw(view, {allowHtml: true, width:'100%', showRowNumber: false,cssClassNames: 'cssClassNames'});
 table.setSelection([{'row': Polygon.returnSelected()}]);
}


function addpolygonmapevent(lid)
{
	google.maps.event.clearListeners(map, 'click');
	google.maps.event.addListener(map, 'click', function(event)
	{
		var newpoint = event.latLng;
		var path = polygon[lid].getPath();
		path.push(newpoint);
		polygon[lid].setPath(path);
	});
	google.maps.event.clearListeners(map, 'rightclick');
	google.maps.event.addListener(map, 'rightclick', function(event)
	{
		google.maps.event.clearListeners(map, 'click');
		map.setOptions({draggableCursor:''});
		polygon[lid].setEditable(false);
		Polygon.clearSelection();
		Polygon.setDefaultFormular();
		for(var p = 0; p < polygonmarker[lid].length; p++){
			polygonmarker[lid][p].setVisible(false);
		}
	});
}

function addpolygonevent(lid)
{
	
	google.maps.event.addListener(polygon[lid], 'click', function(event)
	{
		showpolygon();
		Polygon.clearSelection();
		map.setOptions({draggableCursor:'crosshair'});
		polygon[lid].gmselected = 'true';
		addpolygonmapevent(lid);
		for(var p = 0; p < polygonmarker[lid].length; p++){
			polygonmarker[lid][p].setVisible(true);
		}
		polygon[lid].setEditable(true);
		polygon[lid].getInfoWindow(event, 'Polygon');
		initpolygontabelle();
		polygon[lid].getLength();
		polygon[lid].getArea();
		Polygon.getLineWidth(lid);
		Polygon.getLineOpacity(lid);
		Polygon.getLineColor(lid);
		Polygon.getFillColor(lid)
		Polygon.getFillOpacity(lid);
		Polygon.getParameter(lid);
		Polygon.getAccessLevel(lid);
	});

	google.maps.event.addListener(polygon[lid].getPath(), 'insert_at', function(index) {
		polygon[lid].status = 'isedit';
		var point= polygon[lid].getPath().getArray();
		polygonmarker[lid][polygonmarker[lid].length] = new google.maps.Marker({
			position : point[index],
			title : '#' + index, 
			map : map, 
			visible : true, 
			draggable : false, 
			icon : mysystemicon('line_point_delete.png', 16, 16, 24, 8),
		});
		
		for(var i = 0; i < polygonmarker[lid].length; i++){
			google.maps.event.clearListeners(polygonmarker[lid][i], 'dblclick');
		};
				var point= polygon[lid].getPath().getArray();
				for(var i = 0; i < point.length; i++){
					addpolygonmarkerevent(lid,i);
					polygonmarker[lid][i].setPosition(point[i]);
					polygonmarker[lid][i].setTitle('#' + i);	
				};
		infowindow.open(null);
		polygon[lid].getLength();
		polygon[lid].getArea();
});

google.maps.event.addListener(polygon[lid].getPath(), 'set_at', function(index) {
		polygon[lid].status = 'isedit';
		infowindow.open(null);
		var point= polygon[lid].getPath().getArray();
		polygonmarker[lid][index].setPosition(point[index]);
		polygon[lid].getLength();
		polygon[lid].getArea();
});
google.maps.event.addListener(polygon[lid].getPath(), 'remove_at', function(index) {
	polygon[lid].status = 'isedit';
	polygon[lid].getLength();
	polygon[lid].getArea();
	google.maps.event.clearListeners(polygonmarker[lid][index], 'dblclick');
		polygonmarker[lid][index].setMap(null);
		polygonmarker[lid].splice(index, 1);
	for(var i = 0; i < polygonmarker[lid].length; i++){
		google.maps.event.clearListeners(polygonmarker[lid][i], 'dblclick');
	};
			var point= polygon[lid].getPath().getArray();
			for(var i = 0; i < point.length; i++){
				addpolygonmarkerevent(lid,i);
				polygonmarker[lid][i].setPosition(point[i]);
				polygonmarker[lid][i].setTitle('#' + i);	
			};
});
}
function getpolygonlength(){
	var factor = getSelectedValue('adminForm', 'jform_polygon_line_length');
	var firstpoint = this.getPath().getArray();
	if (firstpoint.length >= 3){
		var wert1 = google.maps.geometry.spherical.computeLength(this.getPath());	
		var wert2 = google.maps.geometry.spherical.computeDistanceBetween(firstpoint[0],firstpoint[firstpoint.length-1]);
		var erg = Math.round((wert1 + wert2)/parseFloat(factor)*100)/100;
		var erg2 = parseInt(wert1 + wert2)/1000;
		$('polygon_line_length').innerHTML = erg;
		return erg2;
	}
}

function getpolygonarea(){
	var factor = getSelectedValue('adminForm', 'jform_polygon_area');
	var firstpoint = this.getPath().getArray();
	if (firstpoint.length >= 3){
		var wert1 = google.maps.geometry.spherical.computeArea(this.getPath());
		var erg = Math.round((wert1)/parseFloat(factor)*100)/100;	
		var erg2 = parseInt((wert1/10000))/100;
		$('polygon_area').innerHTML = erg;
		return erg2;
		
	}
}

function convertpolygonlength(factor){
	var poly = Polygon.returnSelected();
	if (poly === false) return;
	var firstpoint = polygon[poly].getPath().getArray();
	if (firstpoint.length >= 3){
		var wert1 = google.maps.geometry.spherical.computeLength(polygon[poly].getPath());	
		var wert2 = google.maps.geometry.spherical.computeDistanceBetween(firstpoint[0],firstpoint[firstpoint.length-1]);
		var erg = Math.round((wert1 + wert2)/parseFloat(factor)*100)/100;
		$('polygon_line_length').innerHTML = erg;
	}
}

function convertpolygonarea(factor){
	var poly = Polygon.returnSelected();
	if (poly === false) return;
	var firstpoint = polygon[poly].getPath().getArray();
	if (firstpoint.length >= 3){
		var wert1 = google.maps.geometry.spherical.computeArea(polygon[poly].getPath());	
		var erg = Math.round((wert1)/parseFloat(factor)*100)/100;
		$('polygon_area').innerHTML = erg;
	}
}

function addpolygonmarkerevent(lid,lmid){
	polygonmarker[lid][lmid].getButtonWindow = getbuttonwindow;
	google.maps.event.addListener(polygonmarker[lid][lmid], 'dblclick', function()
	{	infowindow.open(null);
		polygon[lid].getPath().removeAt(lmid);
	});
	google.maps.event.addListener(polygonmarker[lid][lmid], 'click', function()
	{	infowindow.open(null);
	});

}
function polygonnew()
{
	showsubtab (0, 'polygon');
	Polygon.clearSelection();
	Polygon.setDefaultFormular();
	var newlid = polygon.length;
	polygonmarker[newlid] = new Array();
	$('jform_polygon_title').value = Joomla.JText._('JS_POLYGON_TITLE_NEW_polygon');
	polygon[newlid] = new google.maps.Polygon(
	{
		map 			: map, 
		polygon_id 		: '', 
		gmselected : 'true', 
		status 	: 'isedit', 
		polygontitel 	: $('jform_polygon_title').value, 
		strokeColor 	: '#000000', 
		strokeOpacity 	: 1.0, 
		strokeWeight 	: 1,
		fillColor 		: '',
		fillOpacity		: 0.0,
		polygon_new 	: 'yes',
		positinfowindow: 'false',
		positinfowindowlat:'',
		positinfowindowlng:'',
		geodesic 		: true,
		editable		: true,
		text			:'' 
	});
	addpolygonmapevent(newlid);
	addpolygonevent(newlid);
	map.setOptions({draggableCursor:'crosshair'});
	polygon[newlid].getLength = getpolygonlength;
	polygon[newlid].getArea = getpolygonarea;
	polygon[newlid].getInfoWindow = getinfowindow;
	Polygon.setAccessLevel();
}

var Polygon ={
	clearSelection: function(option){
		for(var i = 0; i < polygon.length; i++){
			  polygon[i].setEditable(false);
			  polygon[i].gmselected = 'false';
			for(var p = 0; p < polygonmarker[i].length; p++){
				polygonmarker[i][p].setVisible(false);
			}
		   }
		infowindow.open(null);
		google.maps.event.clearListeners(map, 'click');
		map.setOptions({draggableCursor:''});
	},	
	returnSelected: function(option){
		for(var i = 0; i < polygon.length; i++){
		  if (polygon[i].gmselected == 'true'){
			 return i; 
		  }};
		  return false;
	},
	setDefaultFormular: function(option){
		jQuery("#jform_polygon_access_level option:first").attr('selected',true);
		jQuery('#jform_polygon_access_level').trigger('liszt:updated');
		jQuery("#jform_polygon_title").val('');
		jQuery("#polygon_line_length").html('');
		jQuery("#polygon_area").html('');
		jQuery("#jform_polygon_line_color").val('#000000');
		jQuery("#jform_polygon_fill_color").val('#000000');
		jQuery("#polygon_line_width" ).slider('value',1);
		jQuery("#polygon_line_width span" ).html('1');
		jQuery("#polygon_line_opacity" ).slider('value',0);
		jQuery("#polygon_line_opacity span" ).html('0');
		jQuery("#polygon_fill_opacity" ).slider('value',10);
		jQuery("#polygon_fill_opacity span" ).html('10');
		document.getElementById('jform_polygon_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = '';
	},	
	setText: function(option){
		var lid = this.returnSelected();
		if (lid === false) return;
		polygon[lid].status = 'isedit';
		polygon[lid].text = document.getElementById('jform_polygon_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML;
		polygon[lid].text = returnFullImagePath(polygon[lid].text);
		infowindow.setContent('<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+polygon[lid].text+'</div>');
		infowindow.open(map);
	},	
	deleteText: function(option){
		var lid =this.returnSelected();
		if (lid === false) return;
		polygon[lid].status = 'isedit';
		polygon[lid].text = '';
		document.getElementById('jform_polygon_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML ='';
		infowindow.open(null);
	},
	setInfoWindowPosition: function(){
		var cid = this.returnSelected();
		if (cid === false) return;
		polygon[cid].positinfowindow = polygon[cid].temppositinfowindow;
		polygon[cid].positinfowindowlat = infowindow.position.lat();
		polygon[cid].positinfowindowlng = infowindow.position.lng();
		polygon[cid].status = 'isedit';
		polygon[cid].getInfoWindow('default', 'Polygon');
		},
	deleteInfoWindowPosition: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		polygon[cid].positinfowindow = 'false';
		polygon[cid].positinfowindowlat = '';
		polygon[cid].positinfowindowlng = '';
		polygon[cid].status = 'isedit';
		polygon[cid].getInfoWindow('default', 'Polygon');
	},
	setInfoWindowOpen: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		main.InfoWindowOpen(cid,'polygon', option);
		},
	setLineColor: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		polygon[cid].setOptions({strokeColor :jQuery('#jform_polygon_line_color').val()});
		polygon[cid].status = 'isedit';
	},
	setLineWidth: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		polygon[cid].setOptions({strokeWeight :option});
		polygon[cid].status = 'isedit';
	},
	setLineOpacity: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		polygon[cid].setOptions({strokeOpacity :1-option/10});
		polygon[cid].status = 'isedit';
	},
	getLineColor: function(option){
		jQuery('#jform_polygon_line_color').val(polygon[option].strokeColor);
	},
	getLineWidth: function(option){
		jQuery( "#polygon_line_width" ).slider('value',polygon[option].strokeWeight);
		jQuery( "#polygon_line_width span" ).html(polygon[option].strokeWeight);
	},
	getLineOpacity: function(option){
		jQuery( "#polygon_line_opacity" ).slider('value',10-(polygon[option].strokeOpacity)*10);
		jQuery( "#polygon_line_opacity span" ).html(parseInt(10-polygon[option].strokeOpacity*10));
		jQuery( "#jform_polygon_line_opacity" ).val(10-(polygon[option].strokeOpacity)*10)
	},
	setFillColor: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if (jQuery('#jform_polygon_fill_color').val() == ''){
			polygon[cid].setOptions({fillColor :'#000000'});
			polygon[cid].setOptions({fillOpacity :0.0});
			jQuery( "#polygon_fill_opacity" ).slider("option", "disabled", true );
			jQuery("#polygon_fill_opacity" ).slider('value',10);
			jQuery("#polygon_fill_opacity span" ).html('10');
		}else{
			jQuery( "#polygon_fill_opacity" ).slider("option", "disabled", false );	
			polygon[cid].setOptions({fillColor :jQuery('#jform_polygon_fill_color').val()});
		}
		polygon[cid].status = 'isedit';
	},
	setFillOpacity: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		polygon[cid].setOptions({fillOpacity :1-option/10});
		polygon[cid].status = 'isedit';
	},
	getFillColor: function(option){
		jQuery('#jform_polygon_fill_color').val(polygon[option].fillColor);
	},
	getFillOpacity: function(option){
		jQuery( "#polygon_fill_opacity" ).slider('value',10-(polygon[option].fillOpacity)*10);
		jQuery( "#polygon_fill_opacity span" ).html(parseInt(10-polygon[option].fillOpacity*10));
		jQuery( "#jform_polygon_fill_opacity" ).val(10-(polygon[option].fillOpacity)*10)
	},
	getParameter: function(option){
		jQuery('#jform_polygon_title').val(polygon[option].polygontitel);
		document.getElementById('jform_polygon_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = polygon[option].text;
		radionSetCheckedValue('jform_polygon_infowindow_open',polygon[option].firstinfofenster);
	},
	setParameter: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		polygon[cid].polygontitel = jQuery('#jform_polygon_title').val();
		polygon[cid].status = 'isedit';
	},
	setAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if(!option){
			polygon[cid].access_group =	jQuery('#jform_polygon_access_level option:selected').val();
		}else{
		polygon[cid].access_group = option;
		}
		polygon[cid].status = 'isedit';
		},
	getAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		setSelectedValue('jform_polygon_access_level', polygon[cid].access_group);
		},
	moveMapToThis: function(option){
		this.clearSelection();
		var polygoncenter = polygonmarker[option][0].getPosition();
		map.setCenter(polygoncenter);
		},
	delete: function(option) {
		if (!option){
			option = this.returnSelected();
			if (option === false) return;
		}
		polygon[option].setMap(null);
			for(var p = 0; p < polygonmarker[option].length; p++){
				polygonmarker[option][p].setMap(null);
			}

		removedata('remove_polygon', polygon[option].polygon_id);
		polygon[option].status = 'del';
		Polygon.clearSelection(option);
		Polygon.setDefaultFormular();
		initpolygontabelle();
	}
}

function saveallpolygon()
{
		
	var counter1 = 0;
	var counter2 = 0;
	Polygon.clearSelection();
	
	for(var i = 0; i < polygon.length; i++){
		if (polygonmarker[i].length <= 2){
			polygon[i].status = 'del';
		}
		if(polygon[i].status != 'del' && polygon[i].status != 'standard'){
			counter1 += 1;
			}
		}
	if (counter1 != 0){	
		for(var i = 0; i < polygon.length; i++){
			if(polygon[i].status != 'del' && polygon[i].status != 'standard'){
				var punkte = '';
					for(var p = 0; p < polygonmarker[i].length; p++)
					{
						var lat = polygonmarker[i][p].position.lat();
						var lng = polygonmarker[i][p].position.lng();
						punkte += lat + ',' + lng + '|';
						polygonmarker[i][p].setMap(null);
					}
				counter2 += 1;
				if (counter1 > counter2){
					savepolygon(i, punkte);
				}else if(counter1 == counter2){
					var last ='true';
					savepolygon(i, punkte, last);
				}
			}
			for(var p = 0; p < polygonmarker[i].length; p++){
				polygonmarker[i][p].setMap(null);
			}
			polygon[i].setMap(null)
		}
	}else{
	 main.SaveProgress(14);	
	}
	
}


