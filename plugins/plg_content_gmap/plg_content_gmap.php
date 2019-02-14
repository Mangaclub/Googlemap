<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/

//-- No direct access
defined('_JEXEC') or die('Restricted access');

class plgContentplg_content_gmap extends JPlugin
{ 
	protected $autoloadLanguage = true;
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadJSLanguageKeys('/plugins/content/plg_content_gmap/gm_map.js');
		
		
	}

protected function loadJSLanguageKeys($jsFile)
{
    if (isset($jsFile))
    {
        $jsFile = JPATH_ROOT. $jsFile;
    }
    else
    {
        return false;
    }

    if ($jsContents = file_get_contents($jsFile))
    {
        $languageKeys = array();
        preg_match_all('/Joomla\.JText\._\(\'(.*?)\'\)\)?/', $jsContents, $languageKeys);
        $languageKeys = $languageKeys[1];

        foreach ($languageKeys as $lkey)
        {
            JText::script($lkey);
        }
    }
}

public function onContentPrepare($context, &$row, &$params, $page = 0)
{	

	
	$document = JFactory::getDocument();
	$db			= JFactory::getDBO();
	//Karte identifizieren		
	$regex1 = '/{gm.+?}/';
	preg_match_all ($regex1, $row->text, $karten,PREG_SET_ORDER);
	if (count($karten) > 0){
		$js = "google.load('visualization', '1', {packages: ['table','corechart']});
				var URIBase = '".JURI::root()."';";
		$document->addScriptDeclaration( $js );	
		$js1 = 'jQuery(document).ready(function() {';
		for ($i=0, $n=count($karten); $i < $n; $i++){
			$karte = trim($karten[$i][0], "\{gm"); 
			$id = trim($karte, "\}");
			$js1 .= "gm_initialize('".$id."');";
		};
      	$js1 .= '});';
	$document->addScriptDeclaration( $js1 );
	///Filter für nur eine Map APi///
	$treffer = '0';
	$headData = $document->getHeadData();
	$scripts = $headData['scripts'];
	$api = '/https:\/\/maps.googleapis.com\/maps\/api\/.+?/';
	foreach ($scripts as $key => $value) {
		if ( preg_match($api, $key) ){
			$treffer = '1';
		}
	}
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
		if ($treffer == '0'){
	
		$query = "SELECT * FROM #__gm_map WHERE id= '$id' ORDER BY id ASC";
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
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.21&sensor=false&language='.$teile[0].'&libraries=drawing,geometry&'.$apikey);
		}
		if ($map_parameter['map_language'] == '0' and $map_parameter['custom_map_language'] != '' ){
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.21&sensor=false&language='.$map_parameter['custom_map_language'].'&libraries=drawing,geometry&'.$apikey);
		}
		if ($map_parameter['map_language'] != 'auto' and $map_parameter['map_language'] != '0' ){
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.21&sensor=false&language='.$map_parameter['map_language'].'&libraries=drawing,geometry&'.$apikey);
		}
		if ($map_parameter['map_language'] == '0' and $map_parameter['custom_map_language'] == '' ){
			$lang = JFactory::getLanguage();
			$teile = explode("-", $lang->getTag());
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.21&sensor=false&language='.$teile[0].'&libraries=drawing,geometry&'.$apikey);
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

				$replacement =  '';
				$map = '/{gm'.$id.'}/';
				$row->text = preg_replace( $map, $replacement, $row->text );

	
	}
	
	//Secure View Karte identifizieren		
	$regex1 = '/{secureviewgm.+?}/';
	preg_match_all ($regex1, $row->text, $karten,PREG_SET_ORDER);
	if (count($karten) > 0){
		for ($i=0, $n=count($karten); $i < $n; $i++){
			$karte = trim($karten[$i][0], "\{secureviewgm"); 
			$id = trim($karte, "\}");
			$replacement =  '<iframe name="Google Map" src="index.php?option=com_gmap&amp;view=gm_modal&amp;tmpl=component&amp;layout=default&amp;map='.$id.'&amp;iframe=true" width="100%" height="100%"></iframe>';
			$map = '/{secureviewgm'.$id.'}/';
			$row->text = preg_replace( $map, $replacement, $row->text );
		};
	
	}
	
	//Kartenlinks identifizieren
	$regex2 = '/com_gmap&amp;view=gm_modal/';
preg_match_all ($regex2, $row->text, $karten,PREG_SET_ORDER);
	if (count($karten) > 0){
		JHTML::_('behavior.core', true);
		JHtml::_('jquery.framework');
		JHtml::_('jquery.ui');
		$js3 = "
			jQuery(document).ready(function() {
			jQuery('a[rel=example_group]').fancybox({
				'width'				: '90%',
				'height'			: '90%',
				'autoScale'			: true,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
				'type'				: 'iframe'
			});});
			";
		$document->addScriptDeclaration( $js3 );
	$document->addScript( JURI::root(true).'/plugins/content/plg_content_gmap/assets/js/jquery.fancybox-1.3.4.pack.js' );
	$document->addScript( JURI::root(true).'/plugins/content/plg_content_gmap/assets/js/markerclusterer_min.js' );
		$document->addStyleSheet('plugins/content/plg_content_gmap/assets/css/map_button_pc.css'); 
	$document->addStyleSheet('plugins/content/plg_content_gmap/assets/css/jquery.fancybox-1.3.4.css');
	$document->addStyleSheet('plugins/content/plg_content_gmap/assets/css/gm_map.css');		

	}
}//function
}