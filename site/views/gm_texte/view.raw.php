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
 
class gmapViewgm_texte extends JViewLegacy
{
function display($tpl = null)
	{
	$layout = JRequest::getVar('layout');
      $texte = $this->get('Data');
      $this->assignRef('texte', $texte);
	  $circle = $this->get('Datatext');
      $this->assignRef('texte', $texte);
       $this->setLayout($layout);
      parent::display($tpl);
 	}
	

}//class