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

jimport( 'joomla.application.component.view');
 
class GmapViewgm_editor extends JViewLegacy
{
function display($tpl = null)
	{
	$layout = JRequest::getVar('layout');
	if ($layout == 'form_ajax_marker'){
	  $marker = $this->get('AjaxDataMarker');
      $this->assignRef('marker', $marker);
	   $this->setLayout($layout);
	}
	if ($layout == 'form_ajax_rectangle'){
	  $data = $this->get('AjaxDataRectangle');
      $this->assignRef('data', $data);
	   $this->setLayout($layout);
	}
	if($layout == 'form_ajax_circle'){
	  		$circle = $this->get('AjaxDataCircle');
      		$this->assignRef('circle', $circle);
			 $this->setLayout($layout);
	}
	if($layout == 'form_ajax_htmlbox'){
	  		$htmlbox = $this->get('AjaxDataHtmlbox');
      		$this->assignRef('htmlbox', $htmlbox);
			 $this->setLayout($layout);
	}
	if($layout == 'form_ajax_line'){
	  		$line = $this->get('AjaxDataLine');
      		$this->assignRef('line', $line);
			 $this->setLayout($layout);
	}
	if($layout == 'form_ajax_polygon'){
	  		$polygon = $this->get('AjaxDataPolygon');
      		$this->assignRef('polygon', $polygon);
			 $this->setLayout($layout);
	}
	if($layout == 'form_ajax_kml'){
	  		$kml = $this->get('AjaxDataKml');
      		$this->assignRef('kml', $kml);
			 $this->setLayout($layout);
	}
	if($layout == 'form_ajax_line_style'){
	  		$line_style = $this->get('AjaxLineStyle');
      		$this->assignRef('line_style', $line_style);
			 $this->setLayout($layout);
	}
      parent::display($tpl);
 	}
	

}//class