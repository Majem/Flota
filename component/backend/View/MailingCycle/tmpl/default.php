<?php
/**
 *  @package Flota
 *  @copyright Copyright (c)2010-2017 Mateusz Maciejewski
 *  @license GNU General Public License version 3, or later
 */
/** @var \FOF30\View\DataView\Form $this */
// Protect from unauthorized access
defined('_JEXEC') or die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');


echo $this->getRenderedForm();
?>