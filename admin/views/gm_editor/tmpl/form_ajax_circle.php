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
$a=1;
	for ($i=0, $n=count( $this->circle ); $i < $n; $i++)
	{
		$row = &$this->circle[$i];
		$response[$i]['circle_id'] = $row->id;
		$response[$i]['circle_farbe_linie'] = $row->circle_farbe_linie;
		$response[$i]['circle_linie_breite'] = $row->circle_linie_breite;
		$response[$i]['circle_transparent_linie'] = $row->circle_transparent_linie;
		$response[$i]['circle_farbe_fuellung'] = $row->circle_farbe_fuellung;
		$response[$i]['circle_transparent_fuellung'] = $row->circle_transparent_fuellung;
		$response[$i]['circle_position1_lat'] = $row->circle_position1_lat ;
		$response[$i]['circle_position1_lng'] = $row->circle_position1_lng ;
		$response[$i]['circle_radius'] = $row->circle_radius ;
		$response[$i]['circle_beschreibung'] = $row->circle_beschreibung ;
		$response[$i]['access_group'] = $row->access_group;
		if ($row->circle_parameter !=''){
			$teile = explode("|", $row->circle_parameter);
			if (count( $teile ) > '0'){
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$i][$parameter[0]] = $parameter[1];
			}
			}
		}
	}
	if (count( $this->circle ) != '0'){
   	require_once( JPATH_COMPONENT.DS.'helpers'.DS.'json.php' );
   	$json = new Services_JSON();
 	 echo $json->encode( $response );
	}
