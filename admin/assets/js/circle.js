
function showcircle()
{
	Box.clearSelection();
	Rectangle.clearSelection();
	Marker.clearSelection();
	Line.clearSelection();
	Polygon.clearSelection();
	google.maps.event.clearListeners(map, 'click');
	showtab(4);
}


function initcircle()
{
	for(var i = 0; i < circle.length; i++)
	{
		circle[i].getInfoWindow = getinfowindow;
		addcircleevent(i);
	}
}

function initcircletabelle() {
	google.maps.event.clearListeners(drawingManager, 'circlecomplete');
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'ID');
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_TITLE'));
  data.addColumn('string', Joomla.JText._('JS_LINE_HEADER_TABLE_CIRCLE_RADIUS'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_EDIT'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_ACCESS_LEVEL'));
  var count = 0;
  for(var i = 0; i < circle.length; i++){
		if(circle[i].status != 'del'){
			data.addRows(1);
			data.setCell(count, 0, i+1);
			data.setCell(count, 1, circle[i].title);
			data.setCell(count, 2, parseInt(circle[i].radius)+' m');
			data.setCell(count, 3, loadFormElement.buttonShow('Circle.moveMapToThis',i) 
			+loadFormElement.buttonDelete('Circle.delete',i)
			+loadFormElement.buttonInfoWindow('main.InfoWindowOpen',i+', circle', circle[i].firstinfofenster));
			data.setCell(count, 4, jQuery("#jform_circle_access_level option[value="+circle[i].access_group+"]").text());
		count++;
		}
		} 
 var table = new google.visualization.Table(document.getElementById('page_circletabelle'));
var view = new google.visualization.DataView(data);
  table.draw(view, {allowHtml: true, width:'100%', showRowNumber: false,cssClassNames: 'cssClassNames'});
table.setSelection([{'row': Circle.returnSelected()}]);
}
function circlenew()
{
	jQuery("#jform_circle_access_level option:first").attr('selected',true);
	jQuery('#jform_circle_access_level').trigger('liszt:updated');
	showsubtab (0, 'circle');
	Circle.clearSelection();
	google.maps.event.clearListeners(drawingManager, 'circlecomplete');
	drawingManager.setDrawingMode(google.maps.drawing.OverlayType.CIRCLE);
	drawingManager.setOptions({circleOptions:{
		fillColor: '',
		fillOpacity: '',
		strokeWeight: 1,
		clickable: false,
		zIndex: 1,
		editable: true
	}})
google.maps.event.addListener(drawingManager, 'circlecomplete', function(drawcircle) {
	drawingManager.setDrawingMode(null);
	var newcid = circle.length;
	circle[newcid]=(new google.maps.Circle(
	{
		map : map,
		circle_id : newcid,
		center: drawcircle.getCenter(), 
		gmselected : 'true', 
		status : 'isedit',
		text:'', 
		fillColor : '#000000', 
		fillOpacity :  0.0,
		strokeColor: '#000000',
		strokeOpacity: 1.0, 
		strokeWeight : 1, 
		firstinfofenster:'false',
		positinfowindowlat:'',
		positinfowindowlng:'',
		title: 'New Circle '+(newcid+1),
		positinfowindow: 'false',
		radius : drawcircle.getRadius(), 
		circle_new : 'yes', 
		editable: true
	}));
	jQuery('#jform_circle_marker1').val(circle[newcid].getCenter());
	jQuery('#jform_circle_radius').val(circle[newcid].radius);
	var cid = circle.length-1;
	drawcircle.setMap(null);
	circle[cid].getInfoWindow = getinfowindow;
	addcircleevent(cid);
	Circle.getAllOption(cid);
	Circle.setAccessLevel();
});
}

function addcircleevent(cid)
{
	google.maps.event.addListener(circle[cid], 'click', function(event)
	{
		showcircle();
		Circle.clearSelection();
		circle[cid].gmselected = 'true';
		Circle.getAllOption(cid);
		Circle.getAccessLevel(cid);
		circle[cid].setEditable(true);
		circle[cid].getInfoWindow(event, 'Circle');
		initcircletabelle();
		
	});
	google.maps.event.addListener(circle[cid], 'center_changed', function()
	{
		jQuery('#jform_circle_marker1').val(circle[cid].getCenter());
		circle[cid].status = 'isedit';
	});
	google.maps.event.addListener(circle[cid], 'radius_changed', function()
	{
		jQuery('#jform_circle_radius').val(circle[cid].radius);
		circle[cid].status = 'isedit';
	});
}


var Circle ={
	clearSelection: function(option){
		for(var i = 0; i < circle.length; i++){
		  circle[i].setEditable(false);
		  circle[i].gmselected = 'false';
		  infowindow.open(null);
		}
		jQuery('#jform_circle_marker1').val('');
		jQuery('#jform_circle_radius').val('');
		jQuery('#jform_circle_title').val('');
	},	
	returnSelected: function(option){
		for(var i = 0; i < circle.length; i++){
          if (circle[i].gmselected == 'true'){
			 return i; 
		  }};
		  return false;
	},
	setCircleParameter: function(option){
		var cid = this.returnSelected();
			if (cid === false) return;
		circle[cid].title = jQuery('#jform_circle_title').val();
		circle[cid].status = 'isedit';
	},
	setText: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		circle[cid].status = 'isedit';
		circle[cid].text = document.getElementById('jform_circle_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML;
		circle[cid].text = returnFullImagePath(circle[cid].text);
		infowindow.setContent(circle[cid].text);
		infowindow.open(map);
	},
	getText: function(option) {
		document.getElementById('jform_circle_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = circle[option].text;
	},
	deleteText: function(option){
		var cid =this.returnSelected();
		if (cid === false) return;
		circle[cid].status = 'isedit';
		circle[cid].text = '';
		document.getElementById('jform_circle_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML ='';
		infowindow.open(null);
	},
	setInfoWindowPosition: function(){
		var cid = this.returnSelected();
		if (cid === false) return;
		circle[cid].positinfowindow = circle[cid].temppositinfowindow;
		circle[cid].positinfowindowlat = infowindow.position.lat();
		circle[cid].positinfowindowlng = infowindow.position.lng();
		circle[cid].status = 'isedit';
		circle[cid].getInfoWindow('default', 'Circle');
		},
	deleteInfoWindowPosition: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		circle[cid].positinfowindow = 'false';
		circle[cid].positinfowindowlat = '';
		circle[cid].positinfowindowlng = '';
		circle[cid].status = 'isedit';
		circle[cid].getInfoWindow('default', 'Circle');
	},
	setInfoWindowOpen: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		main.InfoWindowOpen(cid,'circle', option);
		},
	getRadius: function(option){
		jQuery("#jform_circle_radius").val(circle[option].radius);
		},
	setRadius: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
			circle[cid].setOptions(
			{
				radius : eval(jQuery("#jform_circle_radius").val()),
			});
			circle[cid].status = 'isedit';
		},
	setLineColor: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		circle[cid].setOptions({strokeColor :jQuery('#jform_circle_farbe_linie').val()});
		circle[cid].status = 'isedit';
	},
	setLineWidth: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		circle[cid].setOptions({strokeWeight :option});
		circle[cid].status = 'isedit';
	},
	setLineOpacity: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		circle[cid].setOptions({strokeOpacity :1-option/10});
		circle[cid].status = 'isedit';
	},
	getLineWidth: function(option){
		jQuery( "#circle_line_width" ).slider('value',circle[option].strokeWeight);
		jQuery( "#circle_line_width span" ).html(circle[option].strokeWeight);
	},
	getLineColor: function(option){
		jQuery('#jform_circle_farbe_linie').val(circle[option].strokeColor);
	},
	getFillColor: function(option){
		jQuery('#jform_circle_farbe_fuellung').val(circle[option].fillColor);
	},
	getLineOpacity: function(option){
		jQuery( "#circle_line_opacity" ).slider('value',10-(circle[option].strokeOpacity)*10);
		jQuery( "#circle_line_opacity span" ).html(parseInt(10-circle[option].strokeOpacity*10));
	},
	setFillColor: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if (circle[cid].fillOpacity == 0.0){
			circle[cid].setOptions({fillOpacity :1.0});
			this.getFillOpacity(cid);
		}
		if (jQuery('#jform_circle_farbe_fuellung').val() == ''){
			circle[cid].setOptions({fillColor :'#000000'});
			circle[cid].setOptions({fillOpacity :0.0});
			jQuery( "#circle_fill_opacity" ).slider("option", "disabled", true );
			circle[cid].status = 'isedit';
			return
			}
		jQuery( "#circle_fill_opacity" ).slider("option", "disabled", false );
		//this.getFillOpacity(cid);	
		circle[cid].setOptions({fillColor :jQuery('#jform_circle_farbe_fuellung').val()});
		circle[cid].status = 'isedit';
	},
	setFillOpacity: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		circle[cid].setOptions({fillOpacity :1-option/10});
		circle[cid].status = 'isedit';
	},
	getFillOpacity: function(option){
		jQuery( "#circle_fill_opacity" ).slider('value',10-(circle[option].fillOpacity)*10);
		jQuery( "#circle_fill_opacity span" ).html(parseInt(10-(circle[option].fillOpacity)*10));
	},
	getAllOption: function(option){
		this.getLineWidth(option);
		this.getLineOpacity(option);
		this.getLineColor(option);
		this.getFillColor(option)
		this.getFillOpacity(option);
		this.getRadius(option);
		this.getText(option);
		jQuery('#jform_circle_marker1').val(circle[option].getCenter());
		jQuery('#jform_circle_title').val(circle[option].title);
	},
	moveMapToThis: function(option){
		this.clearSelection();
		map.setCenter(circle[option].getCenter());
		circle[option].gmselected = 'true';
		this.getAllOption(option);
		circle[option].setEditable(true);
	},
	setAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if(!option){
			circle[cid].access_group =	jQuery('#jform_circle_access_level option:selected').val();
		}else{
		circle[cid].access_group = option;
		}
		circle[cid].status = 'isedit';
		},
	getAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		setSelectedValue('jform_circle_access_level', circle[cid].access_group);
		},
	delete: function(option) {
		if (!option){
			option = this.returnSelected();
			if (option === false) return;
		}
		circle[option].setMap(null);
		removedata('remove_circle', circle[option].circle_id);
		circle[option].status = 'del';
		cleartxt.circletxt();
		initcircletabelle();
	}
}

function saveallcircle(){
	var counter1 = 0;
	var counter2 = 0;
	Circle.clearSelection();
	for(var i = 0; i < circle.length; i++){
		if(circle[i].status != 'del' && circle[i].status != 'standard'){
			counter1 += 1;
			}
		}
	if (counter1 != 0){	
		for(var i = 0; i < circle.length; i++){
			if(circle[i].status != 'del' && circle[i].status != 'standard'){
				counter2 += 1;
				if (counter1 > counter2){
					circle[i].circlemarkerlat = circle[i].getCenter().lat();
					circle[i].circlemarkerlng = circle[i].getCenter().lng();
					savecircle(i);
				}else if(counter1 == counter2){
					var last ='true';
					circle[i].circlemarkerlat = circle[i].getCenter().lat();
					circle[i].circlemarkerlng = circle[i].getCenter().lng();
					savecircle(i, last);
				}
			}
			circle[i].setMap(null)
		}
	}else{
	 main.SaveProgress(14);	
	}
}
