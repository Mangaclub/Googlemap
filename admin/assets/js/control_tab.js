// JavaScript Document

function showtab (tabshow) {
		for(var i = 1; i<=8; i++) {
			var contents = 'tab-'+i;
            $(contents).setStyle('display', 'none');
		}
			var content = 'tab-'+tabshow;
            $(content).setStyle('display', 'block');
			var tabshow2 =tabshow-1;
			jQuery('#gmap-main-tab a:eq('+tabshow2+')').tab('show')
}
function toggle_screen () {
	screenfull.toggle(jQuery('.contentpane component')[0]);
}
function showsubtab (tabnumber, page) {
	
	jQuery('#'+page+'-tab a:eq('+tabnumber+')').tab('show')

}
	
