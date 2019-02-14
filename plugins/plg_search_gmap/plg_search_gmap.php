<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2015. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla-24.de
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSearchplg_search_gmap extends JPlugin
{
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}
	function onContentSearchAreas()
	{
		$gm_label		= $this->params->get('gm_label','Google Map Landkarten');
		$areas = array();
    	$areas['gmap'] = $gm_label;

		return $areas;
	}

	function onContentSearch($text, $phrase='', $ordering='', $areas=null)
	{
		$db		= JFactory::getDbo();
		$app	= JFactory::getApplication();
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->getAuthorisedViewLevels());
		$limit = $this->params->def('search_limit', 50);
		if (is_array($areas)) {
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) {
				return array();
			}
		}

		$text = trim($text);
		if ($text == '') {
			return array();
		}

		$wheres = array();
	switch ($phrase)
	{
		case 'exact':
			$text = $db->quote('%' . $db->escape($text, true) . '%', false);
			$wheres2 	= array();
			$wheres2[] = 'LOWER(m.marker_beschreibung) LIKE LOWER(' . $text . ')';
			$where 		= '(' . implode( ') OR (', $wheres2 ) . ')';
			break;

		case 'all':
		case 'any':
		default:
			$words 	= explode( ' ', $text );
			$wheres = array();
			foreach ($words as $word)
			{
				$word = $db->quote('%' . $db->escape($word, true) . '%', false);
				$wheres2 	= array();
				$wheres2[] = 'LOWER(m.marker_beschreibung) LIKE LOWER(' . $word . ')';
				$wheres[] 	= implode( ' OR ', $wheres2 );
			}
			$where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
			break;
	}

		$gm_label		= $this->params->get('gm_label','Google Map');
		$rows = array();
		$query	= $db->getQuery(true);
		$query = "SELECT marker_beschreibung, id_map, id,"
				." '2' AS browsernav"
				." FROM #__gm_marker AS m "
				. ' WHERE ('. $where .')';
		//echo $query;
			$db->setQuery($query,0, $limit);
			$ergebnis = $db->loadObjectList();
			
			$query = "SELECT * FROM #__content WHERE introtext LIKE '%{gm%}%' OR introtext LIKE '%{secureviewgm%}%'";
			$db->setQuery( $query );
			$items = $db->loadObjectList();
			
		foreach($ergebnis as $key => $row) {
			$karte = $ergebnis[$key]->id_map;
			$mid = $ergebnis[$key]->id;
			$regex1 = '/{gm'.$karte.'}/';
			$regex2 = '/{secureviewgm'.$karte.'}/';
				foreach($items as $item) {
					
					if (preg_match ($regex1, $item->introtext, $karte1)) {
						$link = ContentHelperRoute::getArticleRoute( $item->id).'&mid='.$mid;
						$a = $item->id;
						$ergebnis2[$key] = new stdClass();
						$ergebnis2[$key]->href = $link;
						$ergebnis2[$key]->title =$item->title;
						$ergebnis2[$key]->section = $gm_label;
						$ergebnis2[$key]->created = $item->created;
						$ergebnis2[$key]->text = $item->introtext;
					}
					if (preg_match ($regex2, $item->introtext, $karte1)) {
						$link = ContentHelperRoute::getArticleRoute( $item->id).'&mid='.$mid;
						$a = $item->id;
						$ergebnis2[$key] = new stdClass();
						$ergebnis2[$key]->href = $link;
						$ergebnis2[$key]->title =$item->title;
						$ergebnis2[$key]->section = $gm_label;
						$ergebnis2[$key]->created = $item->created;
						$ergebnis2[$key]->text = $item->introtext;
					}
				}
		}
		return $ergebnis2;
	}
}
