<?php
/**
 * Helper class for Hello World! module
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class ModGmapHelper
{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getHello($params)
    {
       // Obtain a database connection
		$db = JFactory::getDbo();
		// Retrieve the shout
		$query = $db->getQuery(true)
					->select($db->quoteName('map_titel'))
					->from($db->quoteName('#__gm_map'));
				//	->where('lang = ' . $db->Quote('en-GB'));
		// Prepare the query
		$db->setQuery($query);
		// Load the row.
		$result = $db->loadResult();
		// Return the Hello
		return $result;
    }
}