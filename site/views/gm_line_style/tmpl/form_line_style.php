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
	for ($i=0, $n=count( $this->line_style ); $i < $n; $i++)
	{
		$row = $this->line_style[$i];
		
		$response[$i]['id'] = $row->id;
		$response[$i]['title'] = $row->title;
		$response[$i]['path'] = str_replace(array("\r\n", "\r", "\n"), ' ', $row->path);
		$response[$i]['anchor_x'] = $row->anchor_x;
		$response[$i]['anchor_y'] = $row->anchor_y;
		$response[$i]['fillColor'] = $row->fillColor;
		$response[$i]['fillOpacity'] = $row->fillOpacity;
		$response[$i]['strokeColor'] = $row->strokeColor;
		$response[$i]['strokeWeight'] = $row->strokeWeight;
		$response[$i]['strokeOpacity'] = $row->strokeOpacity;
		$response[$i]['rotation'] = $row->rotation;
	}
	
	if (count( $this->line_style ) != '0'){
   require_once( JPATH_COMPONENT.'/helpers/json.php' );
   $json = new Services_JSON();
   echo $json->encode( $response );
   	}
