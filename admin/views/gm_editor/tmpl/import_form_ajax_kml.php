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
//jimport( 'joomla.language.language' );

		$row = &$this->kml;
		//$response['coordinates'] = $row->coordinaten;
			$punkt = explode("|", $row->coordinaten);
			for ($c=0, $m=count( $punkt )-1; $c < $m; $c++){
				$punkt_lat_lng = explode(",", $punkt[$c]);
				$response['line_punkt_lat'][$c] = $punkt_lat_lng[0] ;
				$response['line_punkt_lng'][$c] = $punkt_lat_lng[1] ;
			}

	if (count( $this->kml ) != '0'){
   	require_once( JPATH_COMPONENT.DS.'helpers'.DS.'json.php' );
   	$json = new Services_JSON();
 	 echo $json->encode( $response );
	}
