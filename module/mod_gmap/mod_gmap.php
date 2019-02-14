<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2016. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla-24.de
-------------------------------------------------------------------------*/

 
// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
$map_id = $params->get('map_titel', '1');
$map_width = $params->get('map_width', '100%');
$map_height = $params->get('map_height', '200px');
$map_iframe = $params->get('map_iframe', 'false');
//$hello    = modGmapHelper::getHello( $map_id );

if ($map_iframe == 'true'){
require JModuleHelper::getLayoutPath('mod_gmap','default_iframe');
};
if ($map_iframe == 'false'){
require JModuleHelper::getLayoutPath('mod_gmap','default');
};
