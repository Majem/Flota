<?php
namespace Majem\Flota\Admin\Controller;

// Protect from unauthorized access
defined('_JEXEC') or die();

use FOF30\Controller\DataController;
use FOF30\Inflector\Inflector;


class Company extends DataController
{
	public function publish()
	{
		parent::publish();
		$this->noop();
	}
	public function unpublish()
	{
		parent::unpublish();
		$this->noop();
	}
	public function archive()
	{
		parent::archive();
		$this->noop();
	}
	public function noop()
	{		
		// CSRF prevention
		$this->csrfProtection();
		// Redirect
		if ($customURL = $this->input->getBase64('returnurl', ''))
		{
			$customURL = base64_decode($customURL);
		}
		$url = !empty($customURL) ? $customURL : 'index.php?option=' . $this->container->componentName . '&view=' . $this->container->inflector->pluralize($this->view) . $this->getItemidURLSuffix();
		$this->setRedirect($url);
	}
	
	
	protected function onBeforeBrowse()
	{
		$this->getModel()->blacklistFilters(['created_on', 'created_by']);
		$this->getModel()->setState('id', []);
	}
}