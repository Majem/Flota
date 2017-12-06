<?php
/**
 *  @package AkeebaSubs
 *  @copyright Copyright (c)2010-2017 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */
/** @var \FOF30\View\DataView\Form $this */
// Protect from unauthorized access
defined('_JEXEC') or die();
$this->addJavascriptFile('media://com_akeebasubs/js/blockui.js');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
echo $this->getRenderedForm();
?>