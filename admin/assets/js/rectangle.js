var marker1 = new Array();
var marker2 = new Array();

function showrectangle(){
	Marker.clearSelection();
	Box.clearSelection();
	Circle.clearSelection();
	Line.clearSelection();
	Polygon.clearSelection();
	google.maps.event.clearListeners(map, 'click');
	showtab(3);
}

function initrectangle(){
	for(var i = 0; i < rectangle.length; i++)
	{
		rectangle[i].getInfoWindow = getinfowindow;//from main
		addrectangleevent(i);
	}
	initrectangletabelle();
}

function initrectangletabelle() {
	
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'ID');
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_TITLE'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_EDIT'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_ACCESS_LEVEL'));
  var count = 0;
  for(var i = 0; i < rectangle.length; i++){
		if(rectangle[i].status != 'del'){
			data.addRows(1);
			data.setCell(count, 0, i+1);
			data.setCell(count, 1, rectangle[i].title);
			data.setCell(count, 2, loadFormElement.buttonShow('Rectangle.moveMapToThis',i) 
			+loadFormElement.buttonDelete('Rectangle.delete',i)
			+loadFormElement.buttonInfoWindow('main.InfoWindowOpen',i+', rectangle', rectangle[i].firstinfofenster));
			data.setCell(count, 3, jQuery("#jform_rectangle_access_level option[value="+rectangle[i].access_group+"]").text());
		count++;
		}
		} 
 var table = new google.visualization.Table(document.getElementById('page_rectangletabelle'));
var view = new google.visualization.DataView(data);
  table.draw(view, {allowHtml: true, width:'100%', showRowNumber: false,cssClassNames: 'cssClassNames'});
 table.setSelection([{'row': Rectangle.returnSelected()}]);
}

function addrectangleevent(rid)
{
	google.maps.event.addListener(rectangle[rid], 'click', function(event)
	{
		showrectangle();
		Rectangle.clearSelection();
		rectangle[rid].gmselected = 'true';
		Rectangle.getAllOption(rid);
		Rectangle.getAccessLevel(rid);
		rectangle[rid].setEditable(true);
		rectangle[rid].setDraggable(true);
		rectangle[rid].getInfoWindow(event, 'Rectangle');
		initrectangletabelle();
		
	});
	google.maps.event.addListener(rectangle[rid], 'bounds_changed', function()
	{
		rectangle[rid].status = 'isedit';
	});
	google.maps.event.addListener(rectangle[rid], 'dragend', function()
	{
		rectangle[rid].status = 'isedit';
	});
}

function rectanglenew(){
	jQuery("#jform_rectangle_access_level option:first").attr('selected',true);
	jQuery('#jform_rectangle_access_level').trigger('liszt:updated');
	showsubtab (0, 'rectangle');
	Rectangle.clearSelection();
	google.maps.event.clearListeners(drawingManager, 'rectanglecomplete');
	drawingManager.setDrawingMode(google.maps.drawing.OverlayType.RECTANGLE);
	drawingManager.setOptions({rectangleOptions:{
		fillColor: '',
		fillOpacity: 0.0, 
		strokeWeight: 1,
		clickable: false,
		zIndex: 1,
		editable: true
	}})
google.maps.event.addListener(drawingManager, 'rectanglecomplete', function(rect) {
	drawingManager.setDrawingMode(null);
	var newrid = rectangle.length;
	rectangle[newrid] = new google.maps.Rectangle(
	{
		map : map, 
		rectangle_id : '', 
		gmselected : 'true', 
		status : 'isedit', 
		fillColor : '#000000', 
		fillOpacity : 0.0, 
		strokeColor : '#000000', 
		strokeOpacity : 1.0, 
		strokeWeight : 1, 
		title: 'New Rectangle '+(newrid+1),
		rectangle_new : 'yes', 
		editable: true,
		firstinfofenster:'false',
		positinfowindowlat:'',
		positinfowindowlng:'',
		positinfowindow: 'false',
		draggable: true,
		text:''
	});
	var currentBounds = rect.getBounds();
	var latLngBounds = new google.maps.LatLngBounds(currentBounds.getSouthWest(), currentBounds.getNorthEast());
	rectangle[newrid].setBounds(latLngBounds);
	rectangle[newrid].getInfoWindow = getinfowindow;
	rect.setMap(null);
	addrectangleevent(newrid);
	Rectangle.getAllOption(newrid);
	Rectangle.setAccessLevel();
});	
}



var Rectangle ={
	clearSelection:function(option){
		for(var i = 0; i < rectangle.length; i++){
			  rectangle[i].setEditable(false);
			   rectangle[i].setDraggable(false);
			  rectangle[i].gmselected = 'false';
			  infowindow.open(null);
		}
		jQuery('#jform_rectangle_title').val('');
	},	
	returnSelected: function(option){
		for(var i = 0; i < rectangle.length; i++){
		  if (rectangle[i].gmselected == 'true'){
			 return i; 
		  }};
		  return false;
	},	
	setRectangleParameter: function(option){
		var cid = this.returnSelected();
			if (cid === false) return;
		rectangle[cid].title = jQuery('#jform_rectangle_title').val();
		rectangle[cid].status = 'isedit';
	},
	setText: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		rectangle[cid].status = 'isedit';
		rectangle[cid].text = document.getElementById('jform_rectangle_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML;
		rectangle[cid].text = returnFullImagePath(rectangle[cid].text);
		rectangle[cid].getInfoWindow('default', 'Rectangle');
		infowindow.open(map);
	},	
	getText: function(option) {
		document.getElementById('jform_rectangle_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = rectangle[option].text;
	},
	deleteText: function(option){
		var cid =this.returnSelected();
		if (cid === false) return;
		rectangle[cid].status = 'isedit';
		rectangle[cid].text = '';
		document.getElementById('jform_rectangle_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML ='';
		infowindow.open(null);
	},
	setInfoWindowPosition: function(){
		var cid = this.returnSelected();
		if (cid === false) return;
		rectangle[cid].positinfowindow = rectangle[cid].temppositinfowindow;
		rectangle[cid].positinfowindowlat = infowindow.position.lat();
		rectangle[cid].positinfowindowlng = infowindow.position.lng();
		rectangle[cid].status = 'isedit';
		rectangle[cid].getInfoWindow('default', 'Rectangle');
		},
	deleteInfoWindowPosition: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		rectangle[cid].positinfowindow = 'false';
		rectangle[cid].positinfowindowlat = '';
		rectangle[cid].positinfowindowlng = '';
		rectangle[cid].status = 'isedit';
		rectangle[cid].getInfoWindow('default', 'Rectangle');
	},	
	setInfoWindowOpen: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		main.InfoWindowOpen(cid,'rectangle', option);
		rectangle[cid].status = 'isedit';
		},
	setLineColor: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		rectangle[cid].setOptions({strokeColor :jQuery('#jform_rectangle_farbe_linie').val()});
		rectangle[cid].status = 'isedit';
	},
	setLineWidth: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		rectangle[cid].setOptions({strokeWeight :option});
		rectangle[cid].status = 'isedit';
	},
	setLineOpacity: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		rectangle[cid].setOptions({strokeOpacity :1-option/10});
		rectangle[cid].status = 'isedit';
	},
	getLineWidth: function(option){
		jQuery( "#rectangle_line_width" ).slider('value',rectangle[option].strokeWeight);
		jQuery( "#rectangle_line_width span" ).html(rectangle[option].strokeWeight);
	},
	getLineColor: function(option){
		jQuery('#jform_rectangle_farbe_linie').val(rectangle[option].strokeColor);
	},
	getFillColor: function(option){
		jQuery('#jform_rectangle_farbe_fuellung').val(rectangle[option].fillColor);
	},
	getLineOpacity: function(option){
		jQuery( "#rectangle_line_opacity" ).slider('value',10-(rectangle[option].strokeOpacity)*10);
		jQuery( "#rectangle_line_opacity span" ).html(parseInt(10-rectangle[option].strokeOpacity*10));
	},
	setFillColor: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if (rectangle[cid].fillOpacity == 0.0){
			rectangle[cid].setOptions({fillOpacity :1.0});
			this.getFillOpacity(cid);
		}
		if (jQuery('#jform_rectangle_farbe_fuellung').val() == ''){
			rectangle[cid].setOptions({fillColor :'#000000'});
			rectangle[cid].setOptions({fillOpacity :0.0});
			jQuery( "#rectangle_fill_opacity" ).slider("option", "disabled", true );
			jQuery( "#jform_rectangle_fill_opacity" ).val(0.0)
			rectangle[cid].status = 'isedit';
			return
			}
		jQuery( "#rectangle_fill_opacity" ).slider("option", "disabled", false );
		rectangle[cid].setOptions({fillColor :jQuery('#jform_rectangle_farbe_fuellung').val()});
		rectangle[cid].status = 'isedit';
	},
	setFillOpacity: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		rectangle[cid].setOptions({fillOpacity :1-option/10});
		rectangle[cid].status = 'isedit';
	},
	getFillOpacity: function(option){
		jQuery( "#rectangle_fill_opacity" ).slider('value',10-(rectangle[option].fillOpacity)*10);
		jQuery( "#rectangle_fill_opacity span" ).html(parseInt(10-(rectangle[option].fillOpacity)*10));
	},
	getAllOption: function(option){
		this.getLineWidth(option);
		this.getLineOpacity(option);
		this.getLineColor(option);
		this.getFillColor(option)
		this.getFillOpacity(option);
		this.getText(option);
		jQuery('#jform_rectangle_title').val(rectangle[option].title);
	},
	moveMapToThis: function(option){
		this.clearSelection();
		var currentBounds = rectangle[option].getBounds();
		var topLeftLatLng = new google.maps.LatLng( currentBounds.getNorthEast().lat(),
                                                currentBounds.getSouthWest().lng());
		map.setCenter(topLeftLatLng);
		rectangle[option].gmselected = 'true';
		this.getAllOption(option);
		rectangle[option].setEditable(true);
		rectangle[option].setDraggable(true);
	},
	setAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if(!option){
			rectangle[cid].access_group =	jQuery('#jform_rectangle_access_level option:selected').val();
		}else{
		rectangle[cid].access_group = option;
		}
		rectangle[cid].status = 'isedit';
		},
	getAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		setSelectedValue('jform_rectangle_access_level', rectangle[cid].access_group);
		},
	delete: function(option) {
		if (!option){
			option = this.returnSelected();
			if (option === false) return;
		}
		rectangle[option].setMap(null);
		removedata('remove_rectangle', rectangle[option].rectangle_id);
		rectangle[option].status = 'del';
		cleartxt.rectangletxt();
		initrectangletabelle();
	}
}

function saveallrectangle(){
	
	var counter1 = 0;
	var counter2 = 0;
	Rectangle.clearSelection();
	for(var i = 0; i < rectangle.length; i++){
		if(rectangle[i].status != 'del' && rectangle[i].status != 'standard'){
			counter1 += 1;
			}
		}
	if (counter1 != 0){	
		for(var i = 0; i < rectangle.length; i++){
			if(rectangle[i].status != 'del' && rectangle[i].status != 'standard'){
				counter2 += 1;
				if (counter1 > counter2){
					saverectangle(i);
				}else if(counter1 == counter2){
					var last ='true';
					saverectangle(i, last);
				}
			}
			rectangle[i].setMap(null)
		}
	}else{
	 main.SaveProgress(14);	
	}
}

