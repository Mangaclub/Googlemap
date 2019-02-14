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

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Gmap Controller
 */
class GmapControllergm_editor extends JControllerAdmin
{

	function __construct()
	{	parent::__construct();
		// Register Extra tasks
		//$this->registerTask( 'save_map');
	}

	public function save_map()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->save_map();
	}
	public function save_marker()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->save_marker();
	}
	public function save_rectangle()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->save_rectangle();
	}
	public function save_circle()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->save_circle();
	}
	public function save_line()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->save_line();
	}
	public function save_polygon()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->save_polygon();
	}
	public function save_htmlbox()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->save_htmlbox();
	}
	public function remove_marker()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->remove_marker();
	}
	public function remove_rectangle()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->remove_rectangle();
	}
	public function remove_circle()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->remove_circle();
	}
	public function remove_line()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->remove_line();
	}
	public function remove_polygon()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->remove_polygon();
	}
	public function remove_htmlbox()
	{
		$model = $this->getModel( 'gm_editor' );
		$ergebnis=$model->remove_htmlbox();
	}
}
?>
