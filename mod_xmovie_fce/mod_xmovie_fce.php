<?php
/*
 * @package Joomla 3.0
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component XMovie Component
 * @copyright Copyright (C) Dana Harris optikool.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */ 
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

require_once (JPATH_SITE.DS.'components'.DS.'com_xmovie'.DS.'router.php');
require_once (JPATH_SITE.DS.'components'.DS.'com_xmovie'.DS.'helpers'.DS.'movie.php');


MovieHelper::setCookieParams();	
$list = modXMovieFCEHelper::getList($params);
//$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
//$showMovie = $params->get('show_movie', 0);
//$loadJQuery = $params->get('load_jquery', 0);
//$loadCss = $params->get('load_css', 0);
//$xmovieFceDirection = $params->get('display_direction', 'vertical');

/*
if($xmovieFceDirection == 'horizontal') {
	$divWidth = modXMovieFCEHelper::getDivWidth($params);	
} else {
	$divWidth = '';
}

$document = &JFactory::getDocument();

if($loadCss) {
	$document->addStyleSheet(JURI::base(true).'/modules/mod_xmovie_fce/css/'.$xmovieFceDirection.'-style.css');
}

if($showMovie) {
	if($loadJQuery) {
		$document->addScript(JURI::base(true).'/components/com_xmovie/js/jquery.min.js');
	}
	$document->addScript(JURI::base(true).'/components/com_xmovie/js/flowplayer.min.js');
	$document->addStyleSheet(JURI::base(true).'/components/com_xmovie/css/flowplayer-style.css');

	$jQueryJS = '  			
  			if($===jQuery){jQuery.noConflict();};
  			';
	$document->addScriptDeclaration($jQueryJS);
}
*/
require JModuleHelper::getLayoutPath('mod_xmovie_fce', $params->get('layout', 'default'));
