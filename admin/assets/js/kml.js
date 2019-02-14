// JavaScript Document

function initkml(){
	controlerKml.readSaveFile();
	//importFromKml.getXml();
	
}
function addkmlevent (kmlid){
 google.maps.event.addListener(kmllayer[kmlid], "click", function (event) {
		if (kmllayer[kmlid].kml_beschreibung != ''){
			kmllayer[kmlid].setOptions({suppressInfoWindows: true});
			infowindow.setOptions(
					{
					content : kmllayer[kmlid].kml_beschreibung, 
					position : event.latLng,
					});
			infowindow.open(map);		
		}
        });
}
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
var controlerKml ={
	readSaveFile: function(option){
		var sfiles = jQuery('#jform_kml_files').val();
		var sfile = sfiles.split(";");
		for(var i = 0; i < sfile.length; i++){
			if (sfile[i] != ''){
				jQuery("#jform_kml_file option[value='" + sfile[i] + "']").prop("selected", true);
				jQuery('#jform_kml_file').trigger('liszt:updated');
			}
		}
		this.showFile();
	},	
	showFile: function(option){
		jQuery('#jform_kml_file option').each(function(i) {
			if (this.selected){
				addkmlevent(i);
				kmllayer[i].show_kml ='on';
				kmllayer[i].setMap(map);
			}else{
				kmllayer[i].show_kml ='off';
				kmllayer[i].setMap(null);
			}
		});		
	},	
	returnSelectedKmlFiles: function(option){
		
		var kmlfiles = '';
		for(var i = 0; i < kmllayer.length; i++)
		{
			if (kmllayer[i].show_kml == 'on'){
				var kmlid = kmllayer[i].kml_id;
				if (kmlfiles.length > 0){
					kmlfiles += ';';
				}
				kmlfiles += kmlid;
			}
		}
		return kmlfiles;
	},
					
}
var linepoints;	
var importFromKml = {
	getXml: function(url){
		var fileurl = jQuery('#jform_import_url').val();
			//var fileurl = URIBase+'administrator/components/com_gmap/assets/js/sample.kml';
		 jQuery.ajax({
				type: "GET",
				url: fileurl,
				dataType: "xml",
				success: function(xml){
						import_xml = xml;
						importFromKml.getLine();
				  },
				error: function() {
					alert("An error occurred while processing XML file.");
				  }
				  });
	},
	getLine: function(){
				
				jQuery(import_xml).find('LineString').each(function(i){
					linenew();
				 	var cords = jQuery(this).find('coordinates').text();
				 	var cordset = cords.split("\n");
					var newlid = controlerLine.returnSelectedLine();
					linemarker[newlid] = new Array();
						for(var e = 0; e < cordset.length; e++){
							var latlng = cordset[e].split(",");
							var newpoint = new google.maps.LatLng(latlng[1] ,latlng[0] );
								
								jQuery('#counter').html(e);
								if (cordset.length < 32000){
									linemarker[newlid][e] = new google.maps.Marker({
										position: newpoint,
										title: '#'+ e,
										map: map,
										visible: true,
										icon: mysystemicon('line_point_delete.png', 16, 16, 24, 8),
										});
									addlinemarkerevent(newlid, e);	
								}
							linepoints.push(newpoint);	
						};
						setLine(newlid, linepoints);
						//line[newlid].setPath(linepoints);	
							
				});
	},
	getMarkerPoint: function(){
	
	}

}

function setLine(lid, points){
	line[lid].setPath(points);
	
}

function kmlimporttabelle() {
  var data = new google.visualization.DataTable();
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_ELEMENT'));
  data.addColumn('string', Joomla.JText._('JS_LINE_HEADER_TABLE_ELEMENT_DESC'));
  data.addColumn('string', Joomla.JText._('JS_MAIN_HEADER_TABLE_ELEMENT_IMPORT_BUTTON'));
  var count = 0;
  for(var i = 0; i < line.length; i++){
		if(line[i].status != 'del'){
			data.addRows(1);
			data.setCell(count, 0, line[i].linetitel);
			data.setCell(count, 1, line[i].getLength()+' km');
			data.setCell(count, 2, main.tableButtonShow('lineshow',i)+main.tableButtonDelete('linedel',i)+main.tableButtonInfoWindow('main.InfoWindowOpen',i+', \'line\'', line[i].firstinfofenster));
		count++;
		}
		} 
 var table = new google.visualization.Table(document.getElementById('kmlimporttabelle'));
var view = new google.visualization.DataView(data);
  table.draw(view, {allowHtml: true, showRowNumber: false,cssClassNames: 'cssClassNames'});
 table.setSelection([{'row': controlerLine.returnSelectedLine()}]);
}
