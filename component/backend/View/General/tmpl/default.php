<?php
/**
 *  @package AkeebaSubs
 *  @copyright Copyright (c)2010-2017 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */
// Protect from unauthorized access
defined('_JEXEC') or die();

?>
<div class="span3 info-block">
	<div class="block-header"><?php echo JText::_('COM_FLOTA_CARS_TITLE') ?><i class="fa fa-car" aria-hidden="true"></i></div>
</div>

<div class="span3 info-block">
	<div class="block-header"><?php echo JText::_('COM_FLOTA_EMPLOYE_TITLE') ?><i class="fa fa-users" aria-hidden="true"></i></div>
	<div class="block-content">
		<ol>
			<?php foreach($this->employes as $employe): ?>
				<li><?php echo $employe; ?></li>
			<?php endforeach ?>
		</ol>
	</div>
</div>