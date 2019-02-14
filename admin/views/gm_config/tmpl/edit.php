<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

?>

<script language="javascript" type="text/javascript">
var map;
var backup;

function initialize() {
	var start = new google.maps.LatLng(<?php echo $this->item->conf_center_lat?>,<?php echo $this->item->conf_center_lng?>);
 	var myOptions = {
      zoom: <?php echo $this->item->conf_start_zoom;?>,
      center: start,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map($('map'), myOptions);
    kartenwerte();
	}
	
	function kartenwerte() {
	var mapcenter =  map.getCenter();
	$('jform_conf_center_lat').value =mapcenter.lat();
	$('jform_conf_center_lng').value =mapcenter.lng();	
	$('jform_conf_start_zoom').value = map.getZoom();
getBackupMsg();	
	}
function create_backup() {
	var msg;
	var siteurl= "index.php?option=com_gmap&task=gm_config.create_backup";
  	jQuery.ajax({
			url		: siteurl,
			async: false,
			type: "POST",
			error:function(){
                    msg ='<?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_NEW_FAILURE_MSG' ); ?>';
					return msg;
                },
			 success: function() {
					msg ='<?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_NEW_MSG' ); ?>';
					$('msg_backup_2').innerHTML = '';
					getBackupMsg ();
					return msg;
           },
        });
	alert (msg);
}
function restore_backup() {
 if (backup == '1'){
	var msg;
	var siteurl= "index.php?option=com_gmap&view=gm_config&tmpl=component&layout=form_restore_backup&format=raw&backup_import=<?php echo $this->backup_info['backup_import'];?>";
  	jQuery.ajax({
			url		: siteurl,
			async: false,
			type: "GET",
			dataType:"json",
			error:function(){
                    msg ='<?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_RESTORE_FAILURE_MSG' ); ?>';
					return msg;
                },
			 success: function(response) {
				 	var res = response;
					msg ='<?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_RESTORE_MSG' ); ?>';
					$('msg_backup_2').innerHTML =res;
					return msg;
           },
        });
	alert (msg);
 }else{
	alert ('<?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_BACKUP_NOT_PRESENT'); ?>'); 
 };
getBackupMsg ();
}

function getBackupMsg () {
		var siteurl="index.php?option=com_gmap&view=gm_config&tmpl=component&layout=form_backup&format=raw";
		jQuery.ajax({
			url		: siteurl,
			async: false,
			type: "GET",
			dataType:"json",
			error:function(){
				alert('<?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_LOAD_BACKUP_INFO_FAILURE_MSG' ); ?>');
                },
			 success: function(response) {
				var res = response;
				if (typeof res.backup_info === 'undefined'){
					$('msg_backup_1').innerHTML ='<?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_BACKUP_BACKUP_NOT_PRESENT' ); ?>';
					backup = '0';
				}else{
					$('msg_backup_1').innerHTML = res.backup_info;
					backup = '1';
				}
           },
        });
}

function showtab (tabshow) {
		for(var i = 1; i<=3; i++) {
			var contents = 'tab-'+i;
            $(contents).setStyle('display', 'none');
		}
			var content = 'tab-'+tabshow;
            $(content).setStyle('display', 'block');
			var tabshow2 =tabshow-1;
			jQuery('#gmap-main-tab a:eq('+tabshow2+')').tab('show');
		getBackupMsg ();	
}
function showtabconfig () {
	showtab(2);
	initialize();
}

</script>
<form action="<?php echo JRoute::_('index.php?option=com_gmap&layout=edit&id=1'); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<ul  id="gmap-main-tab" class="nav nav-tabs" role="tablist">
  <li onClick="showtab(1)" class="active">
  	<a href="#api" role="tab" data-toggle="tab"><?php echo JText::_( 'API-KEY' ); ?></a>
   </li>
  <li onClick="showtabconfig()">
  	<a href="#config" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_TITLE_CONFIG' ); ?></a>
   </li>
  <li onClick="showtab(3)">
  	<a href="#backup" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_CONFIG_TAB_LABEL_BACKUP' ); ?></a>
   </li>
</ul>
	<div id="api">
          <?php echo $this->loadTemplate('api');?>    
	</div>
      
      <div id="config">
          <?php echo $this->loadTemplate('config');?>
      </div>	
      <div id="backup">
          <?php echo $this->loadTemplate('backup');?>
      </div>	
<input type="hidden" name="task" value="gm_config.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>

</form>