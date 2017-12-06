<?php
/**
 * @package     Akeeba\Compatibility\Site\Dispatcher
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace Majem\Flota\Admin\Dispatcher;


use FOF30\Container\Container;
use FOF30\Dispatcher\Dispatcher as FOFDispatcher;

class Dispatcher extends FOFDispatcher
{
	public function __construct(Container $container, array $config = array())
	{
		$this->defaultView = 'General';
		
		parent::__construct($container, $config);
	}
	
	public function onBeforeDispatch()
	{
		// Render submenus as drop-down navigation bars powered by Bootstrap
		$this->container->renderer->setOption('linkbar_style', 'flota');
		// Load common CSS and JavaScript
		\JHtml::_('jquery.framework');
		$this->container->template->addCSS('media://com_flota/css/font-awesome.min.css', $this->container->mediaVersion);
		$this->container->template->addCSS('media://com_flota/css/backend.css', $this->container->mediaVersion);
		$this->container->template->addJS('media://com_akeebasubs/js/backend.js', false, false, $this->container->mediaVersion);
	}

}