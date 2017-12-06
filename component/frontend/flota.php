<?php
// Protect from unauthorized access
defined('_JEXEC') or die();

if (!defined('FOF30_INCLUDED') && !@include_once(JPATH_ROOT.'/components/com_flota/lib/core.php'))
{
	throw new RuntimeException('FOF 3.0 is not installed', 500);
}

$dispatcher = FOF30\Container\Container::getInstance('com_flota')->dispatcher;

print_r($dispatcher);