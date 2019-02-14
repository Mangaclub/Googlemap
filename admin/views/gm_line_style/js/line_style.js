var line;
var svg_line;
var svg;
var line_style_path;
var svg_preview_path;
var container_versatz =150;

google.maps.event.addDomListener(window, 'load', init_line_style);
function init_line_style(){
	jQuery( "#accordion" ).accordion({
		collapsible: true,
		heightStyle: "content",
		active: false		
		});
	var option = {
			zoom: 9,
			mapTypeControl: true,
			center: new google.maps.LatLng(39.596425424221636, 2.9426324796676084),
						};
	
	map = new google.maps.Map(document.getElementById('map'), option);
				linepoints = new Array();
				linepoints[0] = new google.maps.LatLng(40.075177520053046,2.6789606046676084);
				linepoints[1] = new google.maps.LatLng(39.51383716162181,2.9371393156051084);
				linepoints[2] = new google.maps.LatLng(39.45236165052789,3.4974420499801084);
			svg_line = new google.maps.Polyline({
			  map					:map,
			  strokeColor			:'#000000',
			  strokeWeight			:1,
			  strokeOpacity			:0,
			  path					:linepoints,
			  geodesic				: true,
			  clickable				:false,
			  zIndex				: 1
			});
			line = new google.maps.Polyline({
			  map					:map,
			  strokeColor			:'#000000',
			  strokeWeight			:1,
			  strokeOpacity			:1,
			  path					:linepoints,
			  geodesic				: true,
			  clickable				:false,
			  zIndex				: 0
			});
	jQuery("#svgContainer" ).resizable();	
	svg = SVG('svgContainer').size('100%', '100%')
	var line_x = svg.line(container_versatz, 0, container_versatz, 500).stroke({ width: 1,color:'#fafa00' })
	var line_y = svg.line(0, container_versatz, 500, container_versatz).stroke({ width: 1,color:'#fafa00' })
	var label = svg.text('-y').x(container_versatz+5);
	var label = svg.text('+y').x(container_versatz+5).y(container_versatz+120);
	var label = svg.text('-x').x(5).y(container_versatz);
	var label = svg.text('+x').x(container_versatz+120).y(container_versatz);
	svg_preview_path = svg.path(jQuery("#jform_path" ).val());
	lineStyle.anchor_x(jQuery( "#jform_anchor_x" ).val());
	lineStyle.anchor_y(jQuery( "#jform_anchor_y" ).val());
	lineStyle.rotation(jQuery( "#jform_rotation" ).val());
	lineStyle.scale(jQuery( "#jform_scale" ).val());
	lineStyle.strokeOpacity(jQuery( "#jform_strokeOpacity" ).val());
	lineStyle.strokeWeight(jQuery( "#jform_strokeWeight" ).val());
	lineStyle.fillOpacity(jQuery( "#jform_fillOpacity" ).val());
	lineStyle.fillColor(jQuery( "#jform_fillColor" ).val());
	lineStyle.strokeColor(jQuery( "#jform_strokeColor" ).val());
	lineStyle.drawLineSymbol();
	
addEvents();
};



var lineStyle  ={
		anchor_x: function(value){
//			svg_preview_path.dx(value);
			this.drawLineSymbol();
			this.svg_zoom();
		},
		anchor_y: function(value){
//			svg_preview_path.dy(value);
			this.drawLineSymbol();
			this.svg_zoom();
		},
		rotation: function(value){
			svg_preview_path.rotate(value,container_versatz,container_versatz);
			this.drawLineSymbol();
			this.svg_zoom();
		},
		scale: function(value){
			this.drawLineSymbol();
		},
		strokeOpacity: function(value){
			svg_preview_path.stroke({opacity:1-value/10});
			this.drawLineSymbol();
			this.svg_zoom();
		},
		strokeWeight: function(value){
			svg_preview_path.stroke({width:value});
			this.drawLineSymbol();
			this.svg_zoom();
		},
		fillOpacity: function(value){
			svg_preview_path.fill({opacity:1-value/10});
			this.drawLineSymbol();
			this.svg_zoom();
		},
		fillColor: function(value){
			svg_preview_path.fill({color:value});
			this.drawLineSymbol();
			this.svg_zoom();
		},
		strokeColor: function(value){
			svg_preview_path.stroke({color:value});
			this.drawLineSymbol();
			this.svg_zoom();
		},
		drawLineSymbol: function(){
			lineSymbol = {
			  anchor:(new google.maps.Point(jQuery( "#jform_anchor_x" ).val(), jQuery( "#jform_anchor_y" ).val())), 
			  path: jQuery( "#jform_path" ).val(),
			  strokeWeight: jQuery( "#jform_strokeWeight" ).val(),
			  strokeOpacity: 1-jQuery( "#jform_strokeOpacity" ).val()/10,
			  strokeColor: jQuery( "#jform_strokeColor" ).val(),
			  fillColor: jQuery( "#jform_fillColor" ).val(),
			  fillOpacity: 1-jQuery( "#jform_fillOpacity" ).val()/10,
			  rotation:jQuery( "#jform_rotation" ).val(),
			  scale: jQuery( "#jform_scale" ).val()
			};
			svg_line.setOptions({
						icons: [{
						icon: lineSymbol,
						offset: jQuery( "#jform_opt_line_svg_offset" ).val(),
						repeat: jQuery( "#jform_opt_line_svg_repeat" ).val()
					}]
			});
			this.svg_zoom();
		},
		svg_zoom: function(value){
			var x =parseInt(jQuery( "#jform_anchor_x" ).val());
			var y =parseInt(jQuery( "#jform_anchor_y" ).val());
			svg_preview_path.scale(value);
			svg_preview_path.plot(' M '+(container_versatz/jQuery("#jform_svg_zoom").val())+','+(container_versatz/jQuery( "#jform_svg_zoom" ).val())+'' + jQuery("#jform_path" ).val());
			svg_preview_path.dmove(x,y);
		},
}

function addEvents(){
jQuery( "#jform_fillColor" ).minicolors('settings', {
	change:function(hex){
		lineStyle.fillColor(hex);
		lineStyle.drawLineSymbol();
		},
	});
jQuery( "#jform_strokeColor" ).minicolors('settings', {
	change:function(hex){
		lineStyle.strokeColor(hex);
		lineStyle.drawLineSymbol();
		},
	});
	
}