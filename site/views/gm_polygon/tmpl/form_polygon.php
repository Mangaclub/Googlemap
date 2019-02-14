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

	
	for ($i=0, $n=count( $this->polygon ); $i < $n; $i++)
	{
		$row = &$this->polygon[$i];
		
		$response[$i]['polygon_color_line'] = $row->polygon_color_line;
		$response[$i]['polygon_transparent_line'] = $row->polygon_transparent_line;
		$response[$i]['polygon_width_line'] = $row->polygon_width_line;
		$response[$i]['polygon_color_fill'] = $row->polygon_color_fill;
		$response[$i]['polygon_transparent_fill'] = $row->polygon_transparent_fill;
		$response[$i]['polygon_beschreibung'] = $row->polygon_beschreibung ;
		$punkt = explode("|", $row->polygon_path);
			for ($c=0, $m=count( $punkt )-1; $c < $m; $c++){
				$punkt_lat_lng = explode(",", $punkt[$c]);
				$response[$i]['polygon_punkt_lat'][$c] = $punkt_lat_lng[0] ;
				$response[$i]['polygon_punkt_lng'][$c] = $punkt_lat_lng[1] ;
			}
		$teile = explode("|", $row->polygon_parameter);
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$i][$parameter[0]] = $parameter[1];
			}
	}
	
    require_once( JPATH_COMPONENT.'/helpers/json.php' );
   $json = new Services_JSON();
   echo $json->encode( $response );