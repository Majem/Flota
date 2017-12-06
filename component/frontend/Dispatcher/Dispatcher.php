<?php
/**
 * @package     Akeeba\Compatibility\Site\Dispatcher
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace Majem\Flota\Site\Dispatcher;


use FOF30\Container\Container;
use FOF30\Dispatcher\Dispatcher as FOFDispatcher;

class Dispatcher extends FOFDispatcher
{
	private function getDefaultView($groups)
	{	
		return $groups;
	}
	
	public function __construct(Container $container, array $config = array())
	{
		print_r( $this->getDefaultView($container->params->get('admin_group', 8)));
		exit();
		
		$this->defaultView = 'Company';

		parent::__construct($container, $config);
	}

}