<?php
namespace Majem\Flota\Admin\View\General;

use FOF30\View\DataView\Html as FOFHtml;

class Html extends FOFHtml
{
	protected function onBeforeMain($tpl = null)
	{
		$this->cars = 5;
		$this->employes = array('Mateusz Maciejewski','Mariusz Zyguła','Katarzyna Brychcy');
	}
}