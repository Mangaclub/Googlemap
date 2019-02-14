<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/

// no direct access

defined('_JEXEC') or die('Restricted access');
 
class com_gmapInstallerScript
{	
	private $release = '4.2.3';
	private $msg = '';
	private $oldversion = '';
	
	function install($parent) 
	{	
		//$this->install_module_plugins();							
		require_once(dirname(__FILE__) .'/admin/updates/views/install_4.2.html');
		echo '<p> Installation der Google Map Landkarten Version ' .JText::_($this->release) .' erfolgreich abgeschlossen!</p>';
		echo $this->msg;
	}

	function uninstall($parent) 
	{
		$db = JFactory::getDbo();
		jimport('joomla.installer.installer');
        // Content Plugin
        $db->setQuery('SELECT `extension_id` FROM #__extensions WHERE `type` = "plugin" AND `element` = "plg_content_gmap" ');
        $id = $db->loadResult();
        if($id){
            $installer = new JInstaller;
            $result = $installer->uninstall('plugin',$id,1);
        } 
		// Content Editor Button       
        $db->setQuery('SELECT `extension_id` FROM #__extensions WHERE `type` = "plugin" AND `element` = "plg_editors_xtd_gmap" ');
        $id = $db->loadResult();
        if($id){
            $installer = new JInstaller;
            $result = $installer->uninstall('plugin',$id,1);
        } 
		// Search Plugin       
        $db->setQuery('SELECT `extension_id` FROM #__extensions WHERE `type` = "plugin" AND `element` = "plg_search_gmap" ');
        $id = $db->loadResult();
        if($id){
            $installer = new JInstaller;
            $result = $installer->uninstall('plugin',$id,1);
        }
		//Master Modul only      
        $db->setQuery('SELECT `extension_id` FROM #__extensions WHERE `type` = "module" AND `element` = "mod_gmap" ');
        $id = $db->loadResult();
        if($id){
            $installer = new JInstaller;
            $result = $installer->uninstall('module',$id,1);
        }        
		echo $this->msg;	
	}

	function update($parent) 
	{
		$this->release=$parent->get("manifest")->version;
		$mainframe = JFactory::getApplication();
		if (version_compare($this->release, $this->oldRelease, '>')) {
			if ($this->oldRelease >= '4.1.4') {
				//$this->update_to_4_2();
				$this->install_module_plugins();
				require_once(JPATH_ADMINISTRATOR.'/components/com_gmap/updates/views/update_from_4.1.4_to_4.2.html');
				$this->msg.= '<p> Updat auf Google Map Landkarten Version ' .JText::_($this->release) .' erfolgreich abgeschlossen!</p>';
				echo $this->msg;
			}else{
				Jerror::raiseWarning(null, 'Ihre Version '.JText::_($this->oldRelease).' kann mit der Version '.JText::_($this->release) .' nicht aktualisiert werden!');
				return false;
			}
		}
	}

	function preflight( $type, $parent ) {
		if ( $type == 'update' ){
		$this->oldRelease = $this->getParam('version');
		if (version_compare($this->oldRelease,'4.1.4', '<')) {
			Jerror::raiseWarning(null, 'Ihre Version '.JText::_($this->oldRelease).' kann mit der Version '.JText::_($this->release) .' nicht aktualisiert werden!');
				return false;
			}
		$jversion = new JVersion();
		$this->release=$parent->get("manifest")->version;
		$this->minimum_joomla_release = $parent->get( "manifest" )->attributes()->version;
		if( version_compare( $jversion->getShortVersion(), $this->minimum_joomla_release, 'lt' ) ) {
                Jerror::raiseWarning(null, 'Cannot install Google Map Landkarten in a Joomla release prior to '.$this->minimum_joomla_release.'</br>Für diese Komponente ist min. Joomla! '.$this->minimum_joomla_release.' erforderlich!');
                return false;
        }
		}
	} 
	/**
	 * method to run after an install/update/discover_install method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{	if ( $type == 'install' ){
			JFolder::copy(JPATH_ADMINISTRATOR.'/components/com_gmap/com_gmap',JPATH_ROOT.'/images/stories/com_gmap','',true);
			$this->install_module_plugins();
			require_once(dirname(__FILE__) .'/admin/updates/views/install_4.2.html');
			echo '<p> Installation der Google Map Landkarten Version ' .JText::_($this->release) .' erfolgreich abgeschlossen!</p>';
			echo $this->msg;
		}
		if ( $type == 'update' ){
		}
		if ( $type == 'discover_install' ){
			JFolder::copy(JPATH_ADMINISTRATOR.'/components/com_gmap/com_gmap',JPATH_ROOT.'/images/stories/com_gmap','',true);
			$this->install_module_plugins();
			echo '<p> Discover Installation der Google Map Landkarten Version ' .JText::_($this->release) .' erfolgreich abgeschlossen!</p>';
		}
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
	}
		function getParam( $name ) {
		$db = JFactory::getDbo();
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE element = '.$db->quote('com_gmap'));
		$manifest = json_decode( $db->loadResult(), true );
		return $manifest[ $name ];
		}
		
		function install_module_plugins (){
			/*
			/ install modules and plugins
			*/
			jimport('joomla.installer.installer');
			// plugins
			$db = JFactory::getDbo();
			$installer = new JInstaller;
			$result = $installer->install(dirname(__FILE__).'/plugins/plg_content_gmap');
			$this->msg .= '<p>Plugin Content für Google Map Landkarten wurde installiert und aktiviert!</p>';
				$db->setQuery("UPDATE #__extensions SET enabled = '1' WHERE `element` = 'plg_content_gmap' AND `type` = 'plugin'");
				$db->execute();
	
			$installer = new JInstaller;
			$result = $installer->install(dirname(__FILE__).'/plugins/plg_editors_xtd_gmap');
			$this->msg .= '<p>Plugin Editor Button für Google Map Landkarten wurde installiert und aktiviert!</p>';
				$db->setQuery("UPDATE #__extensions SET enabled = '1' WHERE `element` = 'plg_editors_xtd_gmap' AND `type` = 'plugin'");
				$db->execute();

			$installer = new JInstaller;
			$result = $installer->install(dirname(__FILE__).'/plugins/plg_search_gmap');
			$this->msg .= '<p>Plugin Search für Google Map Landkarten wurde installiert und aktiviert!</p>';
				$db->setQuery("UPDATE #__extensions SET enabled = '1' WHERE `element` = 'plg_search_gmap' AND `type` = 'plugin'");
				$db->execute();
			$installer = new JInstaller;
			$result = $installer->install(dirname(__FILE__).'/module/mod_gmap');
			$this->msg .= '<p>Modul für die Integration von Google Map Landkarten in Modulen wurde installiert!</p>';
		}
}

