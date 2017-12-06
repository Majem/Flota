<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 23.11.2017
 * Time: 12:02
 */

namespace Majem\Flota\Admin\Model;

use FOF30\Container\Container;
use FOF30\Date\Date;
use FOF30\Model\DataModel;
use JLoader;
use JFactory;

class Mailing extends DataModel
{
    public function __construct(Container $container, array $config = array())
    {
        parent::__construct($container, $config);


        // Always load the Filters behaviour
        $this->addBehaviour('Filters');
        $this->addBehaviour('RelationFilters');
    }
}