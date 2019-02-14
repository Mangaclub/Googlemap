<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
class JFormFieldslider extends JFormField
{

	protected $type = 'slider';

	protected function getInput()
	{
		
		$name		= (string) $this->element['name'];
		$table		= (string) $this->element['table'];
		$min		= (string) $this->element['min'];
		$max		= (string) $this->element['max'];
		$value		= (string) $this->element['value'];
		$orientation= (string) $this->element['orientation'];
		$style		= (string) $this->element['style'];
		$onchange	= (string) $this->element['onchange'];
		$range		= (string) $this->element['range'];
		$range_label= (string) $this->element['range_label'];
		
		//$var = isset($var) ? $value : 'default value';
		
		if ($table!= ''){
			$id = JRequest::getVar('id');
			$db = JFactory::getDBO();
			$query = "SELECT ".$name." FROM #__".$table." WHERE id = '$id'";
			$db->setQuery( $query );
			$item = $db->loadObject();
			if (isset($item) === true ){
				$value = $item->$name;
			}
		}
		if ($range == ''){
			$script = array();
				$script[] = 'jQuery(document).ready(function (){';
				$script[] = 'jQuery( "#'.$name.'" ).slider({';
				$script[] = ' orientation: "'.$orientation.'",';
				$script[] = ' min: '.$min.',';
				$script[] = ' max: '.$max.',';
				$script[] = ' value: '.$value.',';
				$script[] = 'slide: function( event, ui ) {';
				$script[] = 'jQuery( "#'.$name.' span" ).html( ui.value );';
				$script[] = 'jQuery( "#jform_'.$name.'" ).val( ui.value );';
					if (isset($onchange)){
						$script[] = $onchange.'(ui.value);';
					}
				$script[] = '}';
				$script[] = '});';
				$script[] = 'jQuery( "#'.$name.' span" ).html("'.$value.'");';
				$script[] = 'jQuery( "#'.$name.' span" ).css("text-align","center");';
				$script[] = '});';
			JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));	
			
			$html	= array();
				$html[] = '<div id="'.$name.'" style="'.$style.'"></div>';
				$html[] = '<input type="hidden" id="jform_'.$name.'" name="jform['.$name.']" value="'.$value.'" />';
			
			return implode("\n", $html);
		}
//////////////Range Slider//////////////////		
		if ($range != ''){
			$val = explode(",", $value);
			$script = array();
				$script[] = 'jQuery(document).ready(function (){';
				$script[] = 'jQuery( "#'.$name.'" ).slider({';
				$script[] = ' orientation: "'.$orientation.'",';
				$script[] = ' range: true,';
				$script[] = ' min: '.$min.',';
				$script[] = ' max: '.$max.',';
				$script[] = ' values: ['.$value.'],';
				$script[] = 'slide: function( event, ui ) {';
				$script[] = 'jQuery( "#'.$name.' span:nth-child(2)" ).html(ui.values[0]);';
				$script[] = 'jQuery( "#'.$name.' span:nth-child(3)" ).html(ui.values[1]);';
				$script[] = 'jQuery( "#jform_'.$name.'" ).val([ui.values[0] , ui.values[1]] );';
					if (isset($onchange)){
						$script[] = $onchange.'(ui.values[0], ui.values[1]);';
					}
				$script[] = '}';
				$script[] = '});';
				$script[] = 'jQuery( "#'.$name.' div:nth-child(1)" ).html("<div style=\"margin-top:-2px; text-align: center;\">'.JText::_($range_label).'</div>");';
				$script[] = 'jQuery( "#'.$name.' span:nth-child(2)" ).html('.$val[0].');';
				$script[] = 'jQuery( "#'.$name.' span:nth-child(3)" ).html('.$val[1].');';
				$script[] = 'jQuery( "#'.$name.' span" ).css("text-align","center");';
				$script[] = '});';
			JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));	
			
			$html	= array();
				$html[] = '<div id="'.$name.'" style="'.$style.'"></div>';
				$html[] = '<input type="hidden" id="jform_'.$name.'" name="jform['.$name.']" value="'.$value.'" />';
			
			return implode("\n", $html);
		}
	}
}
?>