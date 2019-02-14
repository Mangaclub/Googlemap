<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2016. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla-24.de
-------------------------------------------------------------------------*/

//-- No direct access
defined('_JEXEC') or die('Restricted access');
$lang = JFactory::getLanguage();
$extension = 'com_gmap';
$base_dir = JPATH_SITE;
$app = JFactory::getApplication();
$app->setTemplate('protostar', null);
$reload = true;
$lang->load($extension, $base_dir, $language_tag, $reload);
function loadJSLanguageKeys($jsFile){
    if (isset($jsFile)){
        $jsFile = JPATH_ROOT. $jsFile;
    }else{
        return false;
    }

    if ($jsContents = file_get_contents($jsFile)){
        $languageKeys = array();
        preg_match_all('/Joomla\.JText\._\(\'(.*?)\'\)\)?/', $jsContents, $languageKeys);
        $languageKeys = $languageKeys[1];

        foreach ($languageKeys as $lkey){
            JText::script($lkey);
        }
    }
}
loadJSLanguageKeys('/plugins/content/plg_content_gmap/gm_map.js');
	$document =& JFactory::getDocument();

JHTML::_('behavior.core', true);
JHtml::_('jquery.framework');
JHtml::_('jquery.ui');
JHtml::_('bootstrap.framework');
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

	$map=JRequest::getVar('map');
	$iframe=JRequest::getVar('iframe','false');
	$document->addScriptDeclaration( $js1 );		
	$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.21&sensor=false&language='.$this->map_parameter['map_language'].'&libraries=drawing,geometry&'.$apikey);
	$document->addScript( JURI::root(true).'/plugins/content/plg_content_gmap/ajax.js' );
	$document->addScript( JURI::root(true).'/plugins/content/plg_content_gmap/gm_map.js' );
	$document->addScript( JURI::root(true).'/plugins/content/plg_content_gmap/assets/js/markerclusterer_min.js' );
	$document->addStyleSheet('plugins/content/plg_content_gmap/assets/css/modal.css');
		$document->addStyleSheet('plugins/content/plg_content_gmap/assets/css/map_button_pc.css'); 
	$document->addStyleSheet('plugins/content/plg_content_gmap/assets/css/jquery.fancybox-1.3.4.css');	

$js1 = 'jQuery(document).ready(function() {';
if ($iframe == 'true'){
	$js1 .= "gm_initialize('".$map."','true');";	
}else{
	$js1 .= "gm_initialize('".$map."');";
};
$js1 .= '});';
$document->addScriptDeclaration( $js1 );
		
		$js = "var URIBase = '".JURI::root()."';
				document.open();
     			document.write('<html><body><div id=".$map." style=\'width: 100%; height: 100%; \'></div></body></html>');
     			document.close();

				";
		$document->addScript('https://www.google.com/jsapi');
		$document->addScriptDeclaration( $js );		
		$js2 = "google.load('visualization', '1', {packages: ['table','corechart']});
				var URIBase = '".JURI::root()."';";
		$document->addScriptDeclaration( $js2 );	
		
?>
