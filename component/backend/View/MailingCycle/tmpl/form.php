<?php
/**
 *  @package Flota
 *  @copyright Copyright (c)2010-2017 Mateusz Maciejewski
 *  @license GNU General Public License version 3, or later
 */
/** @var \FOF30\View\DataView\Form $this */
// Protect from unauthorized access
defined('_JEXEC') or die();

$this->addCssFile('media://com_flota/css/backend.css');


JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', '#flota_employe_id', '#company_id', array(
    'disable_search_threshold' => 0
));


echo $this->getRenderedForm();
?>


