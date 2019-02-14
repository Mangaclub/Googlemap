// JavaScript Document

function showline()
{
	Box.clearSelection();
	Rectangle.clearSelection();
	Circle.clearSelection();
	Marker.clearSelection();
	Polygon.clearSelection();
	showtab(5);
	google.maps.event.clearListeners(map, 'click');
}


function initline()
{
	for(var i = 0; i < line.length; i++)
	{
		//add new Methods
		line[i].getLength = getlinelength;
		line[i].setChart = setlinechart;
		line[i].getInfoWindow = getinfowindow;

		addlineevent(i);
		for(var p = 0; p < linemarker[i].length; p++)
		{
			addlinemarkerevent(i, p);
		}
	}

	initlinetabelle();
	Line.clearSelection();
}

function initlinetabelle() {
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'ID');
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_TITLE'));
  data.addColumn('string', Joomla.JText._('JS_LINE_HEADER_TABLE_LINE_LENGTH'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_EDIT'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_ACCESS_LEVEL'));
  var count = 0;
  for(var i = 0; i < line.length; i++){
		if(line[i].status != 'del'){
			data.addRows(1);
			data.setCell(count, 0, i+1);
			data.setCell(count, 1, line[i].linetitel);
			data.setCell(count, 2, line[i].getLength()+' km');
			data.setCell(count, 3, loadFormElement.buttonShow('Line.moveMapToThis',i) 
			+loadFormElement.buttonDelete('Line.delete',i)
			+loadFormElement.buttonInfoWindow('main.InfoWindowOpen',i+', line', line[i].firstinfofenster));
			data.setCell(count, 4, jQuery("#jform_line_access_level option[value="+line[i].access_group+"]").text());
		count++;
		}
		} 
 var table = new google.visualization.Table(document.getElementById('page_linetabelle'));
var view = new google.visualization.DataView(data);
  table.draw(view, {allowHtml: true, width:'100%', showRowNumber: false,cssClassNames: 'cssClassNames'});
 table.setSelection([{'row': Line.returnSelected()}]);
}


function addmapevent(lid)
{
	google.maps.event.clearListeners(map, 'click');
	google.maps.event.addListener(map, 'click', function(event)
	{
		var newpoint = event.latLng;
		var path = line[lid].getPath();
		path.push(newpoint);
		line[lid].setPath(path);
		line[lid].getLength();
	});
	google.maps.event.clearListeners(map, 'rightclick');
	google.maps.event.addListener(map, 'rightclick', function(event)
	{
		google.maps.event.clearListeners(map, 'click');
		map.setOptions({draggableCursor:''});
		line[lid].setEditable(false);
		Line.clearSelection();
		$('line_length').innerHTML = '';
		for(var p = 0; p < linemarker[lid].length; p++){
			linemarker[lid][p].setVisible(false);
		}
	});
}

function adddummylineevent (lid){
	google.maps.event.addListener(linedummy[lid], 'click', function(event)
	{
		showline();
		Line.clearSelection();
		map.setOptions({draggableCursor:'crosshair'});
		line[lid].gmselected = 'true';
		addmapevent(lid);
		for(var p = 0; p < linemarker[lid].length; p++){
			linemarker[lid][p].setVisible(true);
		}
		line[lid].setEditable(true);
		line[lid].setChart();
		line[lid].getInfoWindow(event, 'Line');
		Line.getWidth(lid);
		Line.getOpacity(lid);
		Line.getColor(lid);
		Line.getParameter(lid);
		Line.getAccessLevel(lid);
		Line.getStyleParameter(lid);
		initlinetabelle();
		line[lid].getLength();
	});
}

function addlineevent(lid)
{
	adddummylineevent(lid);
	google.maps.event.addListener(line[lid], 'click', function(event)
	{
		showline();
		Line.clearSelection();
		map.setOptions({draggableCursor:'crosshair'});
		line[lid].gmselected = 'true';
		addmapevent(lid);
		for(var p = 0; p < linemarker[lid].length; p++){
			linemarker[lid][p].setVisible(true);
		}
		line[lid].setEditable(true);
		line[lid].setChart();
		line[lid].getInfoWindow(event, 'Line');
		Line.getWidth(lid);
		Line.getOpacity(lid);
		Line.getColor(lid);
		Line.getParameter(lid);
		Line.getAccessLevel(lid);
		Line.getStyleParameter(lid);
		initlinetabelle();
		line[lid].getLength();
	});

	google.maps.event.addListener(line[lid].getPath(), 'insert_at', function(index) {
		line[lid].status = 'isedit';
		var point= line[lid].getPath().getArray();
		linemarker[lid][linemarker[lid].length] = new google.maps.Marker({
			position : point[index],
			title : '#' + index, 
			map : map, 
			visible : true, 
			draggable : false, 
			icon : mysystemicon('line_point_delete.png', 16, 16, 24, 8),
		});
		for(var i = 0; i < linemarker[lid].length; i++){
			google.maps.event.clearListeners(linemarker[lid][i], 'dblclick');
		};
				var point= line[lid].getPath().getArray();
				for(var i = 0; i < point.length; i++){
					addlinemarkerevent(lid,i);
					linemarker[lid][i].setPosition(point[i]);
					linemarker[lid][i].setTitle('#' + i);	
				};
		Line.updateDummy(lid);		
		//controlerLine.getFormOption();
		line[lid].getLength();
	});

	google.maps.event.addListener(line[lid].getPath(), 'set_at', function(index) {
			line[lid].status = 'isedit';
			var point= line[lid].getPath().getArray();
			linemarker[lid][index].setPosition(point[index]);
			line[lid].getLength();
			Line.updateDummy(lid);
	});
	google.maps.event.addListener(line[lid].getPath(), 'remove_at', function(index) {
		line[lid].status = 'isedit';
		line[lid].getLength();
		google.maps.event.clearListeners(linemarker[lid][index], 'dblclick');
			linemarker[lid][index].setMap(null);
			linemarker[lid].splice(index, 1);
		for(var i = 0; i < linemarker[lid].length; i++){
			google.maps.event.clearListeners(linemarker[lid][i], 'dblclick');
		};
				var point= line[lid].getPath().getArray();
				for(var i = 0; i < point.length; i++){
					addlinemarkerevent(lid,i);
					linemarker[lid][i].setPosition(point[i]);
					linemarker[lid][i].setTitle('#' + i);	
				};
		Line.updateDummy(lid);		
	});
}
function getlinelength(){
	var factor = getSelectedValue('adminForm', 'jform_line_length');
	var wert = google.maps.geometry.spherical.computeLength(this.getPath());
	var	erg1 = Math.round((wert)/parseFloat(factor)*100)/100;
	var erg2 = Math.round((wert/1000)*100)/100;
	$('line_length').innerHTML = erg1;
	return erg2;	
}
function convertlinelength(factor){
	var lid = controlerLine.returnSelectedLine();
	if (lid === false) return;
	var wert = google.maps.geometry.spherical.computeLength(line[lid].getPath());	
	wert = Math.round((wert)/parseFloat(factor)*100)/100;
	$('line_length').innerHTML = wert;
	return wert;
}


function addlinemarkerevent(lid,lmid){
	google.maps.event.addListener(linemarker[lid][lmid], 'dblclick', function()
	{
		line[lid].getPath().removeAt(lmid);
	});
		google.maps.event.addListener(linemarker[lid][lmid], 'rightclick', function()
	{
	});

}
function linenew(newPath)
{
	jQuery("#jform_line_access_level option:first").attr('selected',true);
	jQuery('#jform_line_access_level').trigger('liszt:updated');
	showsubtab (0, 'line');
	Line.clearSelection();
	Line.setDefaultFormular();
	var newlid = line.length;
	linemarker[newlid] = new Array();
	$('jform_line_title').value = Joomla.JText._('JS_LINE_TITLE_NEW_LINE');
	line[newlid] = new google.maps.Polyline(
	{
		map 			: map, 
		line_id 		: '', 
		gmselected 	: 'true', 
		status 		: 'isedit', 
		linetitel 		: $('jform_line_title').value, 
		strokeColor 	: '#000000', 
		strokeOpacity 	: 1.0, 
		strokeWeight 	: 1, 
		line_new 		: 'yes',
		firstinfofenster:'false',
		positinfowindowlat:'',
		positinfowindowlng:'',
		positinfowindow: 'false',
		chartunits		: 'SI',
		geodesic 		: true,
		editable		: true,
		text			:'' 
	});
	Line.newDummy(newlid);
	addmapevent(newlid);
	addlineevent(newlid);
	map.setOptions({draggableCursor:'crosshair'});
	line[newlid].getLength = getlinelength;
	line[newlid].getInfoWindow = getinfowindow;
	line[newlid].setChart = setlinechart;
	if(newPath){
		line[newlid].setPath(newPath);
	}
	Line.setAccessLevel();
}


var Line ={
	clearSelection: function(option){
		for(var i = 0; i < line.length; i++){
			  line[i].setEditable(false);
			  line[i].gmselected = 'false';
			for(var p = 0; p < linemarker[i].length; p++){
				linemarker[i][p].setVisible(false);
			}
		   }
		 jQuery( "#map_elevation" ).slideUp( "slow");  
		//this.setDefaultFormular(); 
		google.maps.event.clearListeners(map, 'click');
		map.setOptions({draggableCursor:''});
	},	
	returnSelected: function(option){
		for(var i = 0; i < line.length; i++){
		  if (line[i].gmselected == 'true'){
			 return i; 
		  }};
		  return false;
	},	
	setDefaultFormular: function(option){
		jQuery("#jform_line_access_level option:first").attr('selected',true);
		jQuery('#jform_line_access_level').trigger('liszt:updated');
		jQuery( "#jform_line_title").val('');
		jQuery( "#jform_line_farbe_linie").val('#000000');
		jQuery( "#line_opacity" ).slider('value',0);
		jQuery( "#line_opacity span" ).html('0');
		jQuery( "#line_width" ).slider('value',1);
		jQuery( "#line_width span" ).html('1');
		radionSetCheckedValue('jform_chart_on_off','false');
		jQuery("#line_length").html('');
		document.getElementById('jform_line_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = '';
		radionSetCheckedValue('jform_chart_units','SI');
		jQuery( "#opt_line_scale" ).slider('value','1');
		jQuery( "#opt_line_scale span" ).html('1');
		jQuery( "#jform_opt_line_svg_offset" ).val('0');
		jQuery( "#jform_opt_line_svg_repeat" ).val('10px');
		radionSetCheckedValue('jform_opt_line_zindex','1');
		setSelectedValue('jform_line_style','default');

	},	
	setText: function(option){
		var lid = this.returnSelected();
		if (lid === false) return;
		line[lid].status = 'isedit';
		line[lid].text = document.getElementById('jform_line_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML;
		line[lid].text = returnFullImagePath(line[lid].text);
		infowindow.setContent('<div style="font-family: Arial,Helvetica,sans-serif;line-height: normal;color: #000000; padding: 0px; margin: 0px;">'+line[lid].text+'</div>');
		infowindow.open(map);
	},	
	deleteText: function(option){
		var lid =this.returnSelected();
		if (lid === false) return;
		line[lid].status = 'isedit';
		line[lid].text = '';
		document.getElementById('jform_line_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML ='';
		infowindow.open(null);
	},
	setColor: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		line[cid].setOptions({strokeColor :jQuery('#jform_line_farbe_linie').val()});
		line[cid].status = 'isedit';
	},
	setWidth: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		line[cid].setOptions({strokeWeight :option});
		line[cid].status = 'isedit';
	},
	setOpacity: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		line[cid].setOptions({strokeOpacity :1-option/10});
		line[cid].status = 'isedit';
	},
	getColor: function(option){
		jQuery('#jform_line_farbe_linie').val(line[option].strokeColor);
	},
	getWidth: function(option){
		jQuery( "#line_width" ).slider('value',line[option].strokeWeight);
		jQuery( "#line_width span" ).html(line[option].strokeWeight);
	},
	getOpacity: function(option){
		jQuery( "#line_opacity" ).slider('value',10-(line[option].strokeOpacity)*10);
		jQuery( "#line_opacity span" ).html(parseInt(10-line[option].strokeOpacity*10));
		jQuery( "#jform_line_opacity" ).val(10-(line[option].strokeOpacity)*10)
	},
	getParameter: function(option){
		jQuery('#jform_line_title').val(line[option].linetitel);
		radionSetCheckedValue('jform_chart_on_off',line[option].chartonoff);
		document.getElementById('jform_line_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = line[option].text;
		radionSetCheckedValue('jform_line_infowindow_open',line[option].firstinfofenster);
		radionSetCheckedValue('jform_chart_units',line[option].chartunits);
	},
	setParameter: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		line[cid].linetitel = jQuery('#jform_line_title').val();
		line[cid].status = 'isedit';
	},
	updateDummy: function (option) {
		var point= line[option].getPath().getArray();
		var dummypoints = new Array();
		for(var i = 0; i < point.length; i++){
			var lat = linemarker[option][i].position.lat();
			var lng = linemarker[option][i].position.lng();
			var newpoint = new google.maps.LatLng(lat ,lng);
			dummypoints.push(newpoint);
		};
		linedummy[option].setMap(null);
		linedummy[option] = new google.maps.Polyline({
			map					:map,
			strokeColor			:'#000000',
			strokeWeight		:1,
			strokeOpacity		:0,
			path				:dummypoints,
			geodesic			: true,
			zIndex				: 2
		});
		adddummylineevent(option);
		this.drawStyle(option);		
	},
	newDummy: function (option) {
		linedummy[option] = new Array();
		linedummy[option] = new google.maps.Polyline({
			map					:map,
			strokeColor			:'#000000',
			strokeWeight		:1,
			strokeOpacity		:0,
			geodesic			: true,
			zIndex				: 2
		});
		adddummylineevent(option);
	},
	setDefaultStyle: function() {
		var cid = this.returnSelected();
		if (cid === false) return;
		linedummy[cid].setOptions({
					icons: ''
		});
		line[cid].status = 'isedit';
	},
	setSaveStyle: function(option, id){
		var cid = id;
		if (cid === false) return;
		if (option == 'default' || option == '' || option === false){
			 this.setDefaultStyle(cid);
		return;
		}
		line[cid].style = option;
		line[cid].lineSymbol = {
		  anchor:(new google.maps.Point(linestyle[option].anchor_x, linestyle[option].anchor_y)), 
		  path:				linestyle[option].path,
		  strokeWeight:		linestyle[option].strokeWeight,
		  strokeOpacity:	1-linestyle[option].strokeOpacity/10,
		  strokeColor:		linestyle[option].strokeColor,
		  fillColor:		linestyle[option].fillColor,
		  fillOpacity:		1-linestyle[option].fillOpacity/10,
		  rotation:			linestyle[option].rotation,
		  scale:			line[cid].style_scale
		};
		linedummy[cid].setOptions({
					icons: [{
					icon: line[cid].lineSymbol,
					offset: line[cid].style_offset,
					repeat: line[cid].style_repeat
				}]
		});
	},
	setStyle: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if (option == 'default' || option == '' || option === false){
			 this.setDefaultStyle(cid);
		return;
		}
		line[cid].style = option;
		line[cid].lineSymbol = {
		  anchor:(new google.maps.Point(linestyle[option].anchor_x, linestyle[option].anchor_y)), 
		  path:				linestyle[option].path,
		  strokeWeight:		linestyle[option].strokeWeight,
		  strokeOpacity:	1-linestyle[option].strokeOpacity/10,
		  strokeColor:		linestyle[option].strokeColor,
		  fillColor:		linestyle[option].fillColor,
		  fillOpacity:		1-linestyle[option].fillOpacity/10,
		  rotation:			linestyle[option].rotation,
		  scale:			linestyle[option].scale
		};
		this.drawStyle(cid);
		line[cid].status = 'isedit';
	},
	setStyleScale: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		line[cid].lineSymbol.scale = option;
		line[cid].style_scale = option;
		this.drawStyle(cid);
	},
	setStyleParameter: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		linedummy[cid].setOptions({icons: ''});
		linedummy[cid].setOptions({
					icons: [{
					icon: line[cid].lineSymbol,
					offset: jQuery( "#jform_opt_line_svg_offset" ).val(),
					repeat: jQuery( "#jform_opt_line_svg_repeat" ).val()
				}]
		});
		line[cid].style_offset = jQuery( "#jform_opt_line_svg_offset" ).val();
		line[cid].style_repeat = jQuery( "#jform_opt_line_svg_repeat" ).val();
		line[cid].status = 'isedit';
	},
	setStyleZindex: function(option) {
		var cid = this.returnSelected();
		if (cid === false) return;
		line[cid].setOptions({zIndex:option});
		line[cid].style_zindex = option;
		line[cid].status = 'isedit';
	},
	drawStyle: function(option){
		linedummy[option].setOptions({icons: ''});	
		linedummy[option].setOptions({
					icons: [{
					icon: line[option].lineSymbol,
					offset: jQuery( "#jform_opt_line_svg_offset" ).val(),
					repeat: jQuery( "#jform_opt_line_svg_repeat" ).val()
				}]
		});
		line[option].status = 'isedit';
	},
	getStyleParameter: function(option){
		jQuery( "#opt_line_scale" ).slider('value',line[option].style_scale);
		jQuery( "#opt_line_scale span" ).html(line[option].style_scale);
		jQuery( "#jform_opt_line_svg_offset" ).val(line[option].style_offset);
		jQuery( "#jform_opt_line_svg_repeat" ).val(line[option].style_repeat);
		radionSetCheckedValue('jform_opt_line_zindex',line[option].style_zindex);
		setSelectedValue('jform_line_style',line[option].style);
	},
	setInfoWindowPosition: function(){
		var cid = this.returnSelected();
		if (cid === false) return;
		line[cid].positinfowindow = line[cid].temppositinfowindow;
		line[cid].positinfowindowlat = infowindow.position.lat();
		line[cid].positinfowindowlng = infowindow.position.lng();
		line[cid].status = 'isedit';
		line[cid].getInfoWindow('default', 'Line');
		},
	deleteInfoWindowPosition: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		line[cid].positinfowindow = 'false';
		line[cid].positinfowindowlat = '';
		line[cid].positinfowindowlng = '';
		line[cid].status = 'isedit';
		line[cid].getInfoWindow('default', 'Line');
	},
	setInfoWindowOpen: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		main.InfoWindowOpen(cid,'line', option);
		line[cid].status = 'isedit';
		},
	setChartDataUnits: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		line[cid].chartunits = option;
		line[cid].status = 'isedit';
		if (line[cid].chartonoff == 'true'){
			setChartHide();
			setChartShow();
		}
		},
	returnChartDataUnits: function(){
		var cid = this.returnSelected();
		return line[cid].chartunits;
		},
	setAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if(!option){
			line[cid].access_group =	jQuery('#jform_line_access_level option:selected').val();
		}else{
		line[cid].access_group = option;
		}
		line[cid].status = 'isedit';
		},
	getAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		setSelectedValue('jform_line_access_level', line[cid].access_group);
		},
	moveMapToThis: function(option){
		this.clearSelection();
		var linesetcenter = linemarker[option][0].getPosition();
		map.setCenter(linesetcenter);
		},
	delete: function(option) {
		if (!option){
			option = this.returnSelected();
			if (option === false) return;
		}
		line[option].setMap(null);
			for(var p = 0; p < linemarker[option].length; p++){
				linemarker[option][p].setMap(null);
			}

		removedata('remove_line', line[option].line_id);
		line[option].status = 'del';
		cleartxt.linetxt();
		initlinetabelle();
	}
}


function saveallline()
{
	var counter1 = 0;
	var counter2 = 0;
	Line.clearSelection();
	for(var i = 0; i < line.length; i++){
		if (linemarker[i].length <= 1){
			line[i].status = 'del';
		}
		if(line[i].status != 'del' && line[i].status != 'standard' && linemarker[i].length > 1){
			counter1 += 1;
			}
		}
	if (counter1 != 0){	
		for(var i = 0; i < line.length; i++){
			if(line[i].status != 'del' && line[i].status != 'standard' && linemarker[i].length > 1){
				var punkte = '';
					for(var p = 0; p < linemarker[i].length; p++)
					{
						var lat = linemarker[i][p].position.lat();
						var lng = linemarker[i][p].position.lng();
						punkte += lat + ',' + lng + '|';
						linemarker[i][p].setMap(null);
					}
				counter2 += 1;
				if (counter1 > counter2){
					saveline(i, punkte);
				}else if(counter1 == counter2){
					var last ='true';
					saveline(i, punkte, last);
				}
			}
			for(var p = 0; p < linemarker[i].length; p++){
				linemarker[i][p].setMap(null);
			}
			line[i].setMap(null);
			linedummy[i].setMap(null);
		}
	}else{
	 main.SaveProgress(14);	
	}
}

//////////////elevation chart////////////////
function setlinechart() {
	function plotElevation(results, status, thisline) {
	  if (status != google.maps.ElevationStatus.OK) {
		alert(Joomla.JText._('JS_LINE_ERROR_NO_ELEVATION'));
		setChartHide();
		radionSetCheckedValue('jform_chart_on_off','false');
		return;
	  }
		if (Line.returnChartDataUnits() == 'SI'){
			var lid = Line.returnSelected();
			var distanz = line[lid].getLength();
			titley = Joomla.JText._('JS_LINE_TITLE_AXE_Y_HEIGHT_SI');
			titlex = Joomla.JText._('JS_LINE_TITLE_AXE_X_DISTANZ_SI')
		}else{
			var lid = Line.returnSelected();
			var distanz = Math.round (line[lid].getLength()/parseFloat(1.609)*100)/100;
			titley = Joomla.JText._('JS_LINE_TITLE_AXE_Y_HEIGHT_ANGLO');
			titlex = Joomla.JText._('JS_LINE_TITLE_AXE_X_DISTANZ_ANGLO')
		}
	  var elevations = results;
	  var data = new google.visualization.DataTable();
	  data.addColumn('string', 'Sample');
	  data.addColumn('number', Joomla.JText._('JS_LINE_HEIGHT'));
	  for (var i = 0; i < results.length; i++) {
		  if (Line.returnChartDataUnits() == 'SI'){
		 	data.addRow(['', Math.round((parseInt(elevations[i].elevation))/parseFloat(1)*100)/100]);
		  }else{
			data.addRow(['', Math.round((parseInt(elevations[i].elevation))/parseFloat(0.9144)*100)/100]);  
		  }
	  }
		var lid = Line.returnSelected();
	  jQuery( "#map_elevation" ).slideDown( "slow");	  
	  chart.draw(data, {
		height: 150,
		legend: 'true',
		titleY: titley,
		titleX: titlex + distanz
	  });
	}

	jQuery( "#map_elevation" ).slideUp( "slow");
	if(this.chartonoff == 'true'){
		chart = new google.visualization.LineChart(document.getElementById('map_elevation'));
		var pathRequest = {
						'path': this.getPath().getArray(),
						'samples': 500
						}
		elevator.getElevationAlongPath(pathRequest, plotElevation);	
	}			

}

function setChartHide(){
 var lid = Line.returnSelected();
	  if (lid === false) return;
		 jQuery( "#map_elevation" ).slideUp( "slow");
		  line[lid].chartonoff = 'false';
		  line[lid].status = 'isedit';
}
function setChartShow(){
 var lid = Line.returnSelected();
	  if (lid === false) return;
		  line[lid].chartonoff = 'true';
		  line[lid].status = 'isedit';
	line[lid].setChart();	  
}
