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
	for ($i=0, $n=count( $this->data ); $i < $n; $i++)
	{
		$row = &$this->data[$i];
		
		$response[$i]['rectangle_id'] = $row->id;
		$response[$i]['rectangle_farbe_linie'] = $row->rectangle_farbe_linie;
		$response[$i]['rectangle_linie_breite'] = $row->rectangle_linie_breite;
		$response[$i]['rectangle_transparent_linie'] = $row->rectangle_transparent_linie;
		$response[$i]['rectangle_farbe_fuellung'] = $row->rectangle_farbe_fuellung;
		$response[$i]['rectangle_transparent_fuellung'] = $row->rectangle_transparent_fuellung;
		$response[$i]['rectangle_position1_lat'] = $row->rectangle_position1_lat ;
		$response[$i]['rectangle_position1_lng'] = $row->rectangle_position1_lng ;
		$response[$i]['rectangle_position2_lat'] = $row->rectangle_position2_lat ;
		$response[$i]['rectangle_position2_lng'] = $row->rectangle_position2_lng ;
		$response[$i]['rectangle_beschreibung'] = $row->rectangle_beschreibung ;
		$response[$i]['access_group'] = $row->access_group;
		if ($row->rectangle_parameter !=''){	
			$teile = explode("|", $row->rectangle_parameter);
			if (count( $teile ) > '0'){
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$i][$parameter[0]] = $parameter[1];
			}
			}
		}
	}
	
	if (count( $this->data ) != '0'){
   	require_once( JPATH_COMPONENT.DS.'helpers'.DS.'json.php' );
   	$json = new Services_JSON();
 	 echo $json->encode( $response );
	}
