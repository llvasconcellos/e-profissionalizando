<?php
/**
* @package   ZOO Component
* @file      init.php
* @version   2.0.0 May 2010
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2010 YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// load config
require_once(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php');

// load mootools
JHTML::_('behavior.mootools');

// load plugins
JPluginHelper::importPlugin('zoo');

// set Itemid
$router = JFactory::getApplication()->getRouter();
if (!$router->getVar('Itemid')) {

	$menu    = JSite::getMenu(true);
	$default = $menu->getDefault();
	$active  = $menu->getActive();
		
	if ($active && $active->id == $default->id) {
		$router->setVar('Itemid', $default->id);
	}
}

try {

	// load and dispatch application
	if ($app = Zoo::getApplication()) {
		$app->dispatch();
	}

} catch (YException $e) {
	JError::raiseError(500, $e);
}