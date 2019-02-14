var breite = 'min';
var hoehe = 'auto';
var textid;

function showtext()
{
	Rectangle.clearSelection();
	Circle.clearSelection();
	Marker.clearSelection();
	Line.clearSelection();
	Polygon.clearSelection();
	google.maps.event.clearListeners(map, 'click');
	showtab(7);
}


function inittext(){
	for(var i = 0; i < boxmarker.length; i++)
	{
		box[i] = new HtmlBox(breite, hoehe, map, boxmarker[i].position, boxmarker[i].text, i, boxmarker[i].rotation);
		addtextevent(i);
	}
}

function inittexttabelle(){
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'ID');
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_BOX'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_EDIT'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_ACCESS_LEVEL'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_RANGE_VIEW'));
  var count = 0;
  for(var i = 0; i < boxmarker.length; i++){
		if(boxmarker[i].status != 'del'){
			data.addRows(1);
			data.setCell(count, 0, i+1);
			data.setCell(count, 1, boxmarker[i].text);
			data.setCell(count, 2, loadFormElement.buttonShow('Box.moveMapToThis',i) 
			+loadFormElement.buttonDelete('Box.delete',i));
			data.setCell(count, 3, jQuery("#jform_htmlbox_access_level option[value="+boxmarker[i].access_group+"]").text());
			data.setCell(count, 4, boxmarker[i].range_start + Joomla.JText._('COM_GMAP_VIEW_GM_MAP_EDITOR_HTMLBOX_RANGE_LABEL') + boxmarker[i].range_end);
		count++;
		}
		} 
 var table = new google.visualization.Table(document.getElementById('page_texttabelle'));
var view = new google.visualization.DataView(data);
  table.draw(view, {allowHtml: true, width:'100%', showRowNumber: false,cssClassNames: 'cssClassNames'});
 table.setSelection([{'row': Box.returnSelected()}]);
}

function addtextevent(tid){
	google.maps.event.addListener(boxmarker[tid], 'click', function(event){
		Box.selectBox(tid);
		
	});
	google.maps.event.addListener(boxmarker[tid], 'dragstart', function(event){
		boxmarker[tid].status = 'isedit';
		showtext();
	});
	google.maps.event.addListener(boxmarker[tid], 'dragend', function(event){
		boxmarker[tid].lat = boxmarker[tid].position.lat();
		boxmarker[tid].lng = boxmarker[tid].position.lng();
	});
	google.maps.event.addListener(boxmarker[tid], 'drag', function(event){
		box[tid].setMap(null);
		box[tid] = new HtmlBox(breite, hoehe, map, event.latLng, boxmarker[tid].text, tid, boxmarker[tid].rotation);
	});
}
function textnew()
{
	Box.clearSelection();
	showsubtab (0, 'htmlbox');
	Box.setDefaultFormular();

	var newrid = boxmarker.length;
	var center = map.getCenter();
	boxmarker[newrid] = new google.maps.Marker({
		id				: '',
		position		: center,
		rotation		:0,
		gmselected		:'true',
		lat				: '',
		lng				: '',
		range_start		:0,
		range_end		:21,
		text			: 'Neue HTML Box',
		map				: map,
		text_new		: 'yes',
		status			: 'isedit',
		visible			: true,
		draggable		: true,
		icon			: mysystemicon('element_activ_nosave.png', 15, 26, 7, 7),
		});
		
		addtextevent(newrid);
		box[newrid] = new HtmlBox(breite, hoehe, map, center, boxmarker[newrid].text, newrid, boxmarker[newrid].rotation);
		boxmarker[newrid].lat = boxmarker[newrid].position.lat();
		boxmarker[newrid].lng = boxmarker[newrid].position.lng();
	//inittexttabelle();
	Box.setAccessLevel();
}

var Box ={
	clearSelection:function(option){
		for(var i = 0; i < boxmarker.length; i++){
			if (boxmarker[i].status == 'isedit'){
				boxmarker[i].setIcon(mysystemicon('element_passiv_no_save.png',15,26,7,7));
			}else{
				boxmarker[i].setVisible(false);
				boxmarker[i].setIcon(mysystemicon('element_activ.png',15,26,7,7));
			}
			  boxmarker[i].gmselected = 'false';
			  boxmarker[i].setOptions({draggable : false});
		}
	},	
	returnSelected: function(option){
		for(var i = 0; i < boxmarker.length; i++){
			if (boxmarker[i].gmselected == 'true'){
				boxmarker[i].setIcon(mysystemicon('element_activ.png',15,26,7,7));
			if (boxmarker[i].status == 'isedit'){
				boxmarker[i].setIcon(mysystemicon('element_activ_no_save.png',15,26,7,7));
			}
			boxmarker[i].setVisible(true);
			 boxmarker[i].setOptions({draggable : true});
			 return i; 
		  }};
		  return false;
	},
	selectBox: function(option){
		this.clearSelection();
		boxmarker[option].gmselected = 'true';
		boxmarker[option].setIcon(mysystemicon('element_activ.png',15,26,7,7));
		if (boxmarker[option].status == 'isedit'){
			boxmarker[option].setIcon(mysystemicon('element_activ_no_save.png',15,26,7,7));
		};
		boxmarker[option].setVisible(true);
		boxmarker[option].setOptions({draggable : true});
		this.getContent(option);
		this.getAccessLevel();
		jQuery( "#htmlbox_rotation" ).slider('value',boxmarker[option].rotation);
		jQuery( "#htmlbox_rotation span" ).html(boxmarker[option].rotation);
		jQuery( "#htmlbox_range_view" ).slider('values',[boxmarker[option].range_start,boxmarker[option].range_end ]);
		jQuery( "#htmlbox_range_view span:nth-child(2)" ).html(boxmarker[option].range_start);
		jQuery( "#htmlbox_range_view span:nth-child(3)" ).html(boxmarker[option].range_end);
		showtext();
		inittexttabelle();
	},
	setDefaultFormular: function(option){
		jQuery("#jform_htmlbox_access_level option:first").attr('selected',true);
		jQuery('#jform_htmlbox_access_level').trigger('liszt:updated');
		document.getElementById('jform_text_box_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = 'Neue HTML Box';
		jQuery( "#htmlbox_rotation" ).slider('value',0);
		jQuery( "#htmlbox_rotation span" ).html('0');
		jQuery( "#htmlbox_range_view" ).slider('values',[0,21]);
		jQuery( "#htmlbox_range_view span:nth-child(2)" ).html('0');
		jQuery( "#htmlbox_range_view span:nth-child(3)" ).html('21');
	},
	getContent: function(option){
		document.getElementById('jform_text_box_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML = boxmarker[option].text;
	},
	setContent: function(){
		var cid = this.returnSelected();
		if (cid === false) return;
		boxmarker[cid].text = document.getElementById('jform_text_box_beschreibung_ifr').contentWindow.document.getElementById('tinymce').innerHTML;
		boxmarker[cid].text = returnFullImagePath(boxmarker[cid].text);
		box[cid].setMap(null);
		box[cid] = new HtmlBox(breite, hoehe, map, boxmarker[cid].getPosition(), boxmarker[cid].text, cid, boxmarker[cid].rotation);
		boxmarker[cid].status = 'isedit';
	},
	setRotation: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		box[cid].setMap(null);
		boxmarker[cid].rotation= option;
		box[cid] = new HtmlBox(breite, hoehe, map, boxmarker[cid].getPosition(), boxmarker[cid].text, cid, option);
		boxmarker[cid].status = 'isedit';
	},
	setRangeView: function(value1, value2){
		var cid = this.returnSelected();
		if (cid === false) return;
		boxmarker[cid].range_start = value1;
		boxmarker[cid].range_end = value2;
		boxmarker[cid].status = 'isedit';
	},
	visibilityOnOff: function(){
		var opt = map.getZoom();
		this.returnSelected();
		  for(var i = 0; i < boxmarker.length; i++){
			  if (opt < boxmarker[i].range_start || opt > boxmarker[i].range_end || gm_element('jform_showelement')[5].selected){
				  boxmarker[i].setVisible(false);
				  box[i].setMap(null);
			  } else {
				if (boxmarker[i].status != 'del'){  
				  box[i].setMap(map); 
				}
			  };
		  };
		  
	},
	moveMapToThis: function(option){
		this.clearSelection();
		map.setCenter(boxmarker[option].getPosition());
		boxmarker[option].gmselected = 'true';
		this.returnSelected();
		this.getContent(option);
	},
	setAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		if(!option){
			boxmarker[cid].access_group =	jQuery('#jform_htmlbox_access_level option:selected').val();
		}else{
		boxmarker[cid].access_group = option;
		}
		boxmarker[cid].status = 'isedit';
		inittexttabelle();
		},
	getAccessLevel: function(option){
		var cid = this.returnSelected();
		if (cid === false) return;
		setSelectedValue('jform_htmlbox_access_level', boxmarker[cid].access_group);
		},
	delete: function(option) {
		if (!option){
			option = this.returnSelected();
			if (option === false) return;
		}
		boxmarker[option].setMap(null);
		box[option].setMap(null);
		removedata('remove_htmlbox', boxmarker[option].id);
		boxmarker[option].status = 'del';
		cleartxt.texttxt();
		inittexttabelle();
	}
}

function savealltext()
{
	Box.clearSelection();
	var counter1 = 0;
	var counter2 = 0;
	for(var i = 0; i < boxmarker.length; i++){
		if(boxmarker[i].status != 'del' && boxmarker[i].status != 'standard'){
			counter1 += 1;
			}
		}
	if (counter1 != 0){	
		for(var i = 0; i < boxmarker.length; i++){
			if(boxmarker[i].status != 'del' && boxmarker[i].status != 'standard'){
				counter2 += 1;
				if (counter1 > counter2){
					savebox(i);
				}else if(counter1 == counter2){
					var last ='true';
					savebox(i, last);
				}
			}
			boxmarker[i].setMap(null);
			box[i].setMap(null);
		}
	}else{
	 main.SaveProgress(16);	
	}
}

HtmlBox.prototype = new google.maps.OverlayView();
function HtmlBox(breite, hoehe, map, latlng, text, tid, rotation)
{
	//text = text.replace(/src=\"/g, 'src="' + URIBase);
	this.versatz_x_ = 0;
	this.versatz_y_ = 0;
	this.latlng_ = latlng;
	this.map_ = map;
	this.breite_ = breite;
	this.hoehe_ = hoehe;
	this.html_ = text;
	this.textid = tid;
	this.rotation = rotation;
	this.div_ = null;
	this.setMap(map);
}

HtmlBox.prototype.onAdd = function()
{
	var div = document.createElement('DIV');
	div.innerHTML = this.html_;
	div.setAttribute("id", "text");
	div.setAttribute("onclick", "Box.selectBox(" + this.textid + ")");
	div.style.position = "absolute";
	this.div_ = div;
	var panes = this.getPanes();
	panes.overlayImage.appendChild(div);
};

HtmlBox.prototype.draw = function()
{
	var overlayProjection = this.getProjection();
	var pixPosition = this.getProjection().fromLatLngToDivPixel(this.latlng_);
	if(!pixPosition)
		return;

	var div = this.div_;
	div.style.left = (pixPosition.x + this.versatz_x_) + "px";
	div.style.top = (pixPosition.y + this.versatz_y_) + "px";
	div.style.width = this.breite_;
	div.style.height = this.hoehe_ + 'px';
	div.style['transform-origin'] = '0px 0px';
	div.style.transform = 'rotate('+ this.rotation +'deg)';
};

HtmlBox.prototype.onRemove = function()
{
	this.div_.parentNode.removeChild(this.div_);
	this.div_ = null;
};