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
$a=1;

	for ($i=0, $n=count( $this->markers ); $i < $n; $i++)
	{
		
		$row = &$this->markers[$i];
			$teile = explode(",", $row->marker_parameter);
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$i][$parameter[0]] = $parameter[1];
			}
		$response[$i]['markerid'] = $row->id;
		$response[$i]['markertitel'] = $row->marker_titel;
		$response[$i]['markerstrasse'] = $row->marker_strasse;
		$response[$i]['markerplz'] = $row->marker_plz;
		$response[$i]['markerort'] = $row->marker_ort;
		$response[$i]['markerbeschreibung'] = $row->marker_beschreibung;
		$response[$i]['markericon'] = $row->marker_icon ;
		$response[$i]['markerlng'] = $row->marker_lng;
		$response[$i]['markerlat'] = $row->marker_lat;
	}
	
   require_once( JPATH_COMPONENT.'/helpers/json.php' );
   $json = new Services_JSON();
   echo $json->encode( $response );