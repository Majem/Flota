<?php
/**
 *  @package AkeebaSubs
 *  @copyright Copyright (c)2010-2017 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */
/** @var \FOF30\View\DataView\Form $this */
// Protect from unauthorized access
defined('_JEXEC') or die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');

// Include font-awesome
$this->addCssFile('media://com_flota/css/font-awesome.css');

echo $this->getRenderedForm();
?>