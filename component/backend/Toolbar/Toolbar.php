<?php
namespace Majem\Flota\Admin\Toolbar;

use FOF30\Inflector\Inflector;
use JToolbarHelper;
use JText;

class Toolbar extends \FOF30\Toolbar\Toolbar
{
    /**
     * Renders the toolbar for the current view and task
     *
     * @param   string   $view  The view of the component
     * @param   string   $task  The exact task of the view
     *
     * @return  void
     */
    public function renderToolbar($view = null, $task = null)
    {
        $input = $this->container->input;
        // If tmpl=component the default behaviour is to not render the toolbar
        if ($input->getCmd('tmpl', '') == 'component')
        {
            $render_toolbar = false;
        }
        else
        {
            $render_toolbar = true;
        }
        // If there is a render_toolbar=0 in the URL, do not render a toolbar
        $render_toolbar = $input->getBool('render_toolbar', $render_toolbar);
        if (!$render_toolbar)
        {
            return;
        }
        // Get the view and task
        $controller = $this->container->dispatcher->getController();
        $autoDetectedView = 'cpanel';
        $autoDetectedTask = 'main';
        if (is_object($controller) && ($controller instanceof Controller))
        {
            $autoDetectedView = $controller->getName();
            $autoDetectedTask = $controller->getTask();
        }
        if (empty($view))
        {
            $view = $input->getCmd('view', $autoDetectedView);
        }
        if (empty($task))
        {
            $task = $input->getCmd('task', $autoDetectedTask);
        }
        // If there is a fof.xml toolbar configuration use it and return
        $view = $this->container->inflector->pluralize($view);
        $toolbarConfig = $this->container->appConfig->get('views.' . ucfirst($view) . '.toolbar.' . $task);
        $oldValues = array(
            'renderFrontendButtons' => $this->renderFrontendButtons,
            'renderFrontendSubmenu' => $this->renderFrontendSubmenu,
            'useConfigurationFile'  => $this->useConfigurationFile,
        );
        $newValues = array(
            'renderFrontendButtons' => $this->container->appConfig->get(
                'views.' . ucfirst($view) . '.config.renderFrontendButtons',
                $oldValues['renderFrontendButtons']
            ),
            'renderFrontendSubmenu' => $this->container->appConfig->get(
                'views.' . ucfirst($view) . '.config.renderFrontendSubmenu',
                $oldValues['renderFrontendSubmenu']
            ),
            'useConfigurationFile'  => $this->container->appConfig->get(
                'views.' . ucfirst($view) . '.config.useConfigurationFile',
                $oldValues['useConfigurationFile']
            ),
        );
        foreach ($newValues as $k => $v)
        {
            $this->$k = $v;
        }
        if (!empty($toolbarConfig) && $this->useConfigurationFile)
        {
            $this->renderFromConfig($toolbarConfig);
            return;
        }
        // Check for an onViewTask method
        $methodName = 'on' . ucfirst($view) . ucfirst($task);

        if (method_exists($this, $methodName))
        {
            $this->$methodName();
            return;
        }
        // Check for an onView method
        $methodName = 'on' . ucfirst($view);
        if (method_exists($this, $methodName))
        {
            $this->$methodName();
            return;
        }
        // Check for an onTask method
        $methodName = 'on' . ucfirst($task);
        if (method_exists($this, $methodName))
        {
            $this->$methodName();
            return;
        }
    }

	public function renderSubmenu()
	{
		// All Menu
		$views = array(
			'ControlPanel' => array(
				'General',
				'Companies',
				'Employes',
				'Cars'
			),
            'Mailing' => array(
                'MailingCycles'
            )
		);

		$activeView = $this->container->input->getCmd('view', 'cpanel');

		foreach($views as $label => $view)
		{
			if(!is_array($view))
			{
				$this->addSubmenuLink($view);
				continue;
			}

			$label = JText::_(strtoupper($this->container->componentName) . '_' . strtoupper($label) . '_TITLE');
			$this->appendLink($label, '', false);

			foreach($view as $v)
				$this->addSubmenuLink($v,$label);
		}
	}


	public function onGeneralsMain()
	{
		$this->renderSubmenu();

		JToolBarHelper::title(JText::_('COM_FLOTA'));
		JToolBarHelper::preferences($option);
		JToolBarHelper::back('JTOOLBAR_BACK', 'index.php?option=com_flota');
	}

	/**
	 * Adds a link to the submenu (toolbar links)
	 *
	 * @param string $view   The view we're linking to
	 * @param array  $parent The parent view
	 */
	private function addSubmenuLink($view, $parent = null)
	{
		static $activeView = null;


		if (empty($activeView))
		{
			$activeView = $this->container->input->getCmd('view', 'cpanel');
		}

		$name = JText::_(strtoupper($this->container->componentName) . '_' . strtoupper($view) . '_TITLE');
		$link = 'index.php?option=' . $this->container->componentName . '&view=' . $view;
		$active = $view == $activeView;
		$this->appendLink($name, $link, $active, null, $parent);
	}
}