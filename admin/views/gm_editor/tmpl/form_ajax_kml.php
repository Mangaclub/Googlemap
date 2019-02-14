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
	for ($i=0, $n=count( $this->kml ); $i < $n; $i++)
	{
		$row = $this->kml[$i];
		
		$response[$i]['kml_id'] = $row->id;
		$response[$i]['kml_pfad'] = $row->kml_pfad;
		$response[$i]['kml_beschreibung'] = $row->kml_beschreibung;
		if ($row->kml_parameter !=''){	
			$teile = explode("|", $row->kml_parameter);
			if (count( $teile ) > '0'){
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$i][$parameter[0]] = $parameter[1];
			}
			}
		}
	}
	
	if (count( $this->kml ) != '0'){
   	require_once( JPATH_COMPONENT.DS.'helpers'.DS.'json.php' );
   	$json = new Services_JSON();
 	 echo $json->encode( $response );
	}
