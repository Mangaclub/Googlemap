<?php 
// No direct access
defined('_JEXEC') or die; 
$document = JFactory::getDocument();
$js = "google.load('visualization', '1', {packages: ['table','corechart']});
				var URIBase = '".JURI::root()."';";
$document->addScriptDeclaration( $js );	

$js1 = 'jQuery(document).ready(function() {';
$js1 .= "gm_initialize('".$map_id."');";
$js1 .= '});';
$document->addScriptDeclaration( $js1 );
	///Filter für nur eine Map APi///
	$headData = $document->getHeadData();
	$scripts = $headData['scripts'];
	$regex1 = '/https:\/\/maps.googleapis.com\/maps\/api\/.+?/';
	$treffer = '0';
	foreach ($scripts as $key => $value) {
		if ( preg_match($regex1, $key)){
			$treffer = '1';
		}
	}
		if ($treffer == '0'){
			$db			= JFactory::getDBO();
		$query = "SELECT * FROM #__gm_config WHERE id= '1' ORDER BY id ASC";
		$db->setQuery( $query );
		$row1 = $db->loadObject();
		$conf_parameter = array();
		$teile = explode(";", $row1->conf_parameter);
		if (count( $teile ) > '0'){
			for ($i=0, $n=count( $teile ); $i < $n; $i++){
				$parameter = explode("|", $teile[$i]);
				$conf_parameter[$parameter[0]] = $parameter[1];
			}
		}
		$apikey = '';
		if ( $conf_parameter['conf_api_key'] >''){
			$apikey = 'key='.$conf_parameter['conf_api_key'];
		}
		$db			= JFactory::getDBO();
		$query = "SELECT * FROM #__gm_map WHERE id= '$map_id' ORDER BY id ASC";
		$db->setQuery( $query );
		$row2 = $db->loadObject();
		$map_parameter = array();
		$teile = explode(",", $row2->map_parameter);
			for ($i=0, $n=count( $teile ); $i < $n; $i++){
				$parameter = explode(":", $teile[$i]);
				$map_parameter[$parameter[0]] = $parameter[1];
			}
		if ($map_parameter['map_language'] == 'auto'){
			$lang = JFactory::getLanguage();
			$teile = explode("-", $lang->getTag());
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.21&language='.$teile[0].'&libraries=drawing,geometry&'.$apikey);
		}
		if ($map_parameter['map_language'] == '0' and $map_parameter['custom_map_language'] != '' ){
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.21&language='.$map_parameter['custom_map_language'].'&libraries=drawing,geometry&'.$apikey);
		}
		if ($map_parameter['map_language'] != 'auto' and $map_parameter['map_language'] != '0' ){
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.21&language='.$map_parameter['map_language'].'&libraries=drawing,geometry&'.$apikey);
		}
		if ($map_parameter['map_language'] == '0' and $map_parameter['custom_map_language'] == '' ){
			$lang = JFactory::getLanguage();
			$teile = explode("-", $lang->getTag());
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.21&language='.$teile[0].'&libraries=drawing,geometry&'.$apikey);
		}
	}


		JHTML::_('behavior.core', true);
		JHtml::_('jquery.framework');
		JHtml::_('jquery.ui');
	$document->addScript('https://www.google.com/jsapi');
	$document->addScript( JURI::root(true).'/plugins/content/plg_content_gmap/ajax.js' );
	$document->addScript( JURI::root(true).'/plugins/content/plg_content_gmap/gm_map.js' );
	$document->addScript( JURI::root(true).'/plugins/content/plg_content_gmap/assets/js/markerclusterer_min.js' );
		$document->addStyleSheet('plugins/content/plg_content_gmap/assets/css/map_button_pc.css'); 
		$document->addStyleSheet('plugins/content/plg_content_gmap/assets/css/jquery.fancybox-1.3.4.css');	
		$document->addStyleSheet('plugins/content/plg_content_gmap/assets/css/gm_map.css');	


?>
<div style="width: <?php echo $map_width; ?>; height: <?php echo $map_height; ?>;">
<div id="<?php echo $map_id; ?>" class="gmap" style="background-image: url('components/com_gmap/assets/images/google_maps_logo.jpg'); background-repeat: no-repeat; background-position: center center; width: 100%; height: 100%; border: 1px solid #000;">{gm<?php echo $map_id; ?>}</div></div>