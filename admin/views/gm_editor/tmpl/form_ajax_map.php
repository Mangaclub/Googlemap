<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.language.language' );
$a=1;
 
	
		$row = $this->map;
		if ($row->map_parameter !=''){	
			$teile = explode(",", $row->map_parameter);
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$parameter[0]] = $parameter[1];
			}
		}
		if ($row->street_view_parameter !=''){	
			$teile = explode(",", $row->street_view_parameter);
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$parameter[0]] = $parameter[1];
			}
		}
		$response['map_id'] = $row->id;
		$response['map_lat'] = $row->map_center_lat;
		$response['map_lng'] = $row->map_center_lng;
		$response['map_zoom'] = $row->map_zoom;
		$lang = $response['map_language'];
		
		if ($response['map_language'] == '0'){
			$lang = JFactory::getLanguage();
			$teile = explode("-", $lang->getTag());
			$lang =$teile[0];
			$response['map_language'] = $lang;
			}
	
    require_once( JPATH_COMPONENT.DS.'helpers'.DS.'json.php' );
   $json = new Services_JSON();
   echo $json->encode( $response );