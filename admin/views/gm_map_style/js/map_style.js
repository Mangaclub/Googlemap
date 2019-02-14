

function initialize(){
jQuery( "#accordion" ).accordion({collapsible: true});
	var option = {
			zoom: eval(jQuery('#default_zoom').val()),
			mapTypeControl: false,
			center: new google.maps.LatLng(jQuery('#default_lat').val(),jQuery('#default_lng').val()),
						};
	
map = new google.maps.Map(document.getElementById('map'), option);

}

google.maps.event.addDomListener(window, 'load', initialize);