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

	
	for ($i=0, $n=count( $this->texte ); $i < $n; $i++)
	{
		$row = &$this->texte[$i];
		
		$response[$i]['text_id'] = $row->id;
		$response[$i]['text_text'] = $row->text_text;
		$response[$i]['text_lat'] = $row->text_lat;
		$response[$i]['text_lng'] = $row->text_lng;
		$teile = explode("|", $row->text_parameter);
			for ($a=0, $b=count( $teile ); $a < $b; $a++){
				$parameter = explode(":", $teile[$a]);
				$response[$i][$parameter[0]] = $parameter[1];
			}
	}
	
    require_once( JPATH_COMPONENT.'/helpers/json.php' );
   $json = new Services_JSON();
   echo $json->encode( $response );