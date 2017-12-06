<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 23.11.2017
 * Time: 11:46
 */

namespace Majem\Flota\Admin\Model;

defined('_JEXEC') or die;
use FOF30\Container\Container;
use FOF30\Model\DataModel;
use JApplicationHelper;
use JComponentHelper;
use JFactory;
use JLoader;
use JUser;
use JUserHelper;

class JoomlaUsers extends DataModel
{
    /**
     * Override the constructor since I need to attach to a core table and add the Filters behaviour
     *
     * @param Container $container
     * @param array     $config
     */
    public function __construct(Container $container, array $config = array())
    {
        $config['tableName'] = '#__users';
        $config['idFieldName'] = 'id';
        parent::__construct($container, $config);
        // Always load the Filters behaviour
        $this->addBehaviour('Filters');
        // Do not run automatic value validation of data before saving it.
        $this->autoChecks = false;
    }
}