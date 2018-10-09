<?php
/*
 * @package Joomla 2.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component XMovie Component
 * @copyright Copyright (C) Dana Harris optikool.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */ 
defined('_JEXEC') or die('Restricted access');

class modXMovieFCEHelper {
	protected $_num_movies;
	protected $_movies_per_row;
	protected $_category_id;
	protected $_sort_method;
	protected $_query;
	protected $_data;
	protected $_div_width;
	protected $_moduleclass_sfx;
	protected $_show_thumb;
	protected $_show_name;
	protected $_show_quicktake;
	protected $_show_date;
	protected $_show_hits;
	protected $_thumb_width;
	protected $_thumb_height;
	protected $_catslug;
	protected $_movslug;
	protected $_params;
			
	public function __construct(&$params) {			
		$this->_num_movies = $params->get('num_movies', 5);
		$this->_category_id = $params->get('cat_id', '');
		$this->_movie_id = $params->get('movie_id');
		$this->_sort_method = $params->get('sort_method');
		$this->_movies_per_row = $params->get('movies_per_row');
		$this->_moduleclass_sfx = $params->get('moduleclass_sfx');
		$this->_show_thumb = $params->get('show_thumb');
		$this->_show_name = $params->get('show_name');
		$this->_show_quicktake = $params->get('show_quicktake');
		$this->_show_date = $params->get('show_date');
		$this->_show_hits = $params->get('show_hits');
		$this->_thumb_width = $params->get('thumb_width');
		$this->_thumb_height = $params->get('thumb_height');
		$this->_div_width = "";
		$this->_show_arrows = $params->get('show_arrows', 0);
		$this->_params = $params;
	}
	
	public static function getList(&$params) {
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->getAuthorisedViewLevels());
		$cat_ids = implode(',', $params->get('cat_id'));
		$itemids = MovieHelper::getItemIds();
		$tmpRows = array();
		$cTime = time();
		$sort_method = $params->get('sort_method');
		$cLimit = $params->get('num_movies');
		$items = array();
				
		// Create a new query object.
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		// Select required fields from the categories.
		$query->select('a.*');
		$query->from($db->quoteName('#__xmovie_movies').' AS a');
		
		// Join over the categories.
		$query->select('c.alias AS catalias');
		$query->join('LEFT', $db->quoteName('#__categories') . ' AS c ON c.id = a.catid');
		
		$query->where('a.access IN ('.$groups.')');
		$query->where('a.catid IN ('.$cat_ids.')');
				
		$query->where('a.published = 1');
		
		switch($sort_method) {
			case 'popular':
				$sort_method = "hits DESC";
				break;
			case 'oldest':
				$sort_method = "creation_date ASC";
				break;
			case 'random':
				$sort_method= "RAND()";
				break;
			case 'newest':
			default:
				$sort_method= "creation_date DESC";
				break;
		}
			
		$query->order($sort_method);
		
		$db->setQuery($query, 0, $cLimit);
		$rows = $db->loadObjectList();
		
		// Convert the params field into an object, saving original in _params
		for ($i = 0; $i < $cLimit; $i++) {
			$items[$i] = $rows[$i];
			$cid = $items[$i]->catid;			
			$user = JFactory::getUser($items[$i]->user_id);			
			$items[$i]->submitter = $user->username;
			if(isset($itemids[$cid]['itemId']) && $itemids[$cid]['itemId'] != '') {
				$items[$i]->itemId = $itemids[$cid]['itemId'];
			} else {
				$items[$i]->itemId = $itemids[0]['itemId'];
			}
			
			$link = $params->get('show_movie');
			if($params->get('show_movie', 0)) {
				$randCount = rand(0, $cTime);
				$items[$i]->embed = MovieHelper::getShadowboxCode($items[$i], $randCount, $link);
			}			
		}
		
		unset($rows);
		$rows = $items;
		
		return $rows;
	}

	public static function getDivWidth(&$params) {
		$div_width = intval(100 / intval($params->get('movies_per_row')));
		$browser = MovieHelper::getBrowserType();
		if($browser['browser'] == 'IE') {
			$div_width = $div_width - 1;
		}
		return $div_width;
	}
}	
?>