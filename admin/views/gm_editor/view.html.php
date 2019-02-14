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

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Gmaps View
 */
class GmapViewgm_editor extends JViewLegacy
{
	/**
	 * display method of Gmaps view
	 * @return void
	 */
	public function display($tpl = null)
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
		$config	= $this->get('Config');
		$script = $this->get('Script');
		$this->loadJSLanguageKeys('/administrator/components/com_gmap/assets/js/main.js');
		$this->loadJSLanguageKeys('/administrator/components/com_gmap/assets/js/form.js');
		$this->loadJSLanguageKeys('/administrator/components/com_gmap/assets/js/marker.js');
		$this->loadJSLanguageKeys('/administrator/components/com_gmap/assets/js/rectangle.js');
		$this->loadJSLanguageKeys('/administrator/components/com_gmap/assets/js/circle.js');
		$this->loadJSLanguageKeys('/administrator/components/com_gmap/assets/js/line.js');
		$this->loadJSLanguageKeys('/administrator/components/com_gmap/assets/js/polygon.js');
		$this->loadJSLanguageKeys('/administrator/components/com_gmap/assets/js/kml.js');
		$this->loadJSLanguageKeys('/administrator/components/com_gmap/assets/js/text.js');
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		};

		// Assign the variables
		$this->form = $form;
		$this->item = $item;
		$this->config = $config;
		$this->script = $script;
		$this->item->conf_api_key ='';
			$teile = explode(",", $this->item->map_parameter);
			if (count( $teile ) > '1'){
				for ($a=0, $b=count( $teile ); $a < $b; $a++){
					$parameter = explode(":", $teile[$a]);
					$this->item->{$parameter[0]} = $parameter[1];
				}
			}
			
			if (!empty($this->config->conf_parameter)){
			$teile = explode(";", $this->config->conf_parameter);
			if (count( $teile ) > '0'){
				for ($a=0, $b=count( $teile ); $a < $b; $a++){
					$parameter = explode("|", $teile[$a]);
					$this->config->{$parameter[0]} = $parameter[1];
				}
			}
			}
		$lang = JFactory::getLanguage();
		$teile = explode("-", $lang->getTag());
		$part1 = "'https://joomla-24.de/?option=com_content&view=article&id=";
		$part2 = "&tmpl=component&print=1' rel=\"help_group\"";
		//Assign the Help Link
		if ($teile[0] == 'de'){
			$this->config->help_map_editor = $part1."313".$part2;
			$this->config->help_map_setup = $part1."312".$part2;
			$this->config->help_marker = $part1."309".$part2;
			$this->config->help_rectangle = $part1."307".$part2;
			$this->config->help_circle = $part1."306".$part2;
			$this->config->help_line = $part1."305".$part2;
			$this->config->help_polygon = $part1."299".$part2;
			$this->config->help_html_box = $part1."304".$part2;
			$this->config->help_kml = $part1."297".$part2;
		}else{
			$this->config->help_map_editor = $part1."226".$part2;
			$this->config->help_map_setup = $part1."225".$part2;
			$this->config->help_marker = $part1."222".$part2;
			$this->config->help_rectangle = $part1."220".$part2;
			$this->config->help_circle = $part1."219".$part2;
			$this->config->help_line = $part1."218".$part2;
			$this->config->help_polygon = $part1."212".$part2;
			$this->config->help_html_box = $part1."217".$part2;
			$this->config->help_kml = $part1."239".$part2;
		}
		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}


	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId	= $user->id;
		$isNew = $this->item->id == 0;
		$canDo = GmapHelper::getActions($this->item->id);
		JToolBarHelper::title(JText::_('COM_GMAP_VIEW_GM_MAP_EDIT_TITLE'), 'gm_map_edit');
		
		// Built the actions existing records.
			if ($canDo->get('core.edit')){
			};
	}


	protected function setDocument()
	{
		$apikey = '';
		if ( @$this->config->conf_api_key >''){
			$apikey = 'key='.$this->config->conf_api_key;
		}
		$isNew = ($this->item->id < 1);
		JHtml::_('bootstrap.framework');
		JHtml::_('jquery.framework');
		JHtml::_('jquery.ui');
		JHtml::_('behavior.framework', false);
		$document = JFactory::getDocument();
		$document->addScript('https://www.google.com/jsapi');
		$document->setTitle(JText::_('COM_GMAP_VIEW_GM_MAP_EDIT_TITLE'));
		$document->addScript(JURI::root() . $this->script);
		if (@$this->item->map_language == 'auto'){
			$lang = JFactory::getLanguage();
			$teile = explode("-", $lang->getTag());
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.20&language='.$teile[0].'&libraries=places,drawing,geometry&'.$apikey);
		}
		if (@$this->item->map_language == '0' and $this->item->custom_map_language != '' ){
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.20&language='.$this->item->custom_map_language.'&libraries=places,drawing,geometry&'.$apikey);
		}
		if (@$this->item->map_language != 'auto' and @$this->item->map_language != '0' ){
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.20&language='.@$this->item->map_language.'&libraries=places,drawing,geometry&'.$apikey);
		}
		if (@$this->item->map_language == '0' and $this->item->custom_map_language == '' ){
			$lang =& JFactory::getLanguage();
			$teile = explode("-", $lang->getTag());
			$document->addScript('https://maps.googleapis.com/maps/api/js?v=3.20&language='.$teile[0].'&libraries=weather,places,drawing,geometry&'.$apikey);
		}
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/jquery-ui.min.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/jquery.fancybox-1.3.4.pack.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/ajax.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/text.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/form.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/main.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/map.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/marker.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/rectangle.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/circle.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/line.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/polygon.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/kml.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/picker.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/control_tab.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/screenfull.js' );
		$document->addScript( JURI::root(true).'/administrator/components/com_gmap/assets/js/markerclusterer_min.js' );
		$document->addStyleSheet('components/com_gmap/assets/css/map_button.css');
		$document->addStyleSheet('components/com_gmap/assets/css/jquery-ui.structure.min.css');
		$document->addStyleSheet('components/com_gmap/assets/css/jquery-ui.theme.min.css');
		$document->addStyleSheet('components/com_gmap/assets/css/jquery-ui.css');
		$document->addStyleSheet('components/com_gmap/assets/css/tab.css');
		JText::script('gmaps not acceptable. Error');
		$js = "	google.load('visualization', '1', {packages: ['table','corechart']});
				var assetsBase = '".JURI::root()."administrator/components/com_gmap/assets';
				var URIBase = '".JURI::root()."';";
		$document->addScriptDeclaration( $js );
				$js3 = "
			jQuery(document).ready(function() {
			jQuery('a[rel=help_group]').fancybox({
				'width'				: '90%',
				'height'			: '90%',
				'autoScale'			: true,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
				'type'				: 'iframe'
			});});
			";
		$document->addScriptDeclaration( $js3 );
		$document->addStyleSheet( JURI::root(true).'/administrator/components/com_gmap/assets/css/fancy_box/jquery.fancybox-1.3.4.css');	

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
	
}
?>