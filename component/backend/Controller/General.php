<?php
namespace Majem\Flota\Admin\Controller;


use FOF30\Container\Container;
use FOF30\Controller\Controller;
use FOF30\Controller\Mixin\PredefinedTaskList;
use JUri;

class General extends Controller
{
	use PredefinedTaskList;
	
	public function __construct(Container $container, array $config = array())
	{	
		parent::__construct($container, $config);
		
		$this->registerTask('overview', 'display');
		$this->setPredefinedTaskList(['main', 'save']);
		$this->cacheableTasks = array();
	}
}