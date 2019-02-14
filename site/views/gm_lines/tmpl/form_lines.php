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

	
	for ($i=0, $n=count( $this->lines ); $i < $n; $i++)
	{
		$row = &$this->lines[$i];
		
		$response[$i]['line_id'] = $row->id;
		$response[$i]['line_titel'] = $row->line_titel;
		$response[$i]['line_farbe'] = $row->line_farbe;
		$response[$i]['line_breite'] = $row->line_breite;
		$response[$i]['line_transparent'] = $row->line_transparent;
		$response[$i]['line_beschreibung'] = $row->line_beschreibung ;
		$punkt = explode("|", $row->line_punkte);
			for ($c=0, $m=count( $punkt )-1; $c < $m; $c++){
				$punkt_lat_lng = explode(",", $punkt[$c]);
				$response[$i]['line_punkt_lat'][$c] = $punkt_lat_lng[0] ;
				$response[$i]['line_punkt_lng'][$c] = $punkt_lat_lng[1] ;
			}
		$teile = explode("|", $row->line_parameter);
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$i][$parameter[0]] = $parameter[1];
			}
	}
	
    require_once( JPATH_COMPONENT.'/helpers/json.php' );
   $json = new Services_JSON();
   echo $json->encode( $response );