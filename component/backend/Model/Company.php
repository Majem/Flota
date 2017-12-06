<?php
/**
 * @package   AkeebaSubs
 * @copyright Copyright (c)2010-2017 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 3, or later
 */

namespace Majem\Flota\Admin\Model;

defined('_JEXEC') or die;

use FOF30\Container\Container;
use FOF30\Model\DataModel;
use JLoader;

/**
 * Model class
 *
 * @property  int		$flota_company_id
 * @property  string    $name
 * @property  string    $nip
 * @property  bool      $enabled
 * @property  int       $ordering
 * @property  string      $created_on
 * @property  int      $created_by
 * @property  string      $modified_on
 * @property  string      $modified_by
 *
 */
class Company extends DataModel
{

	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);
		
		// Always load the Filters behaviour
		$this->addBehaviour('Filters');
		$this->addBehaviour('RelationFilters');
	}

    /**
     * Get company by id
     */
	public function getCompanies()
    {
        $db    = $this->getDbo();
        $query = $db->getQuery(true)
            ->select(array(
                $db->qn('flota_company_id'),
                $db->qn('name'),
                $db->qn('enabled')

            ))
            ->from($db->qn('#__flota_companies'));
        $db->setQuery($query);
        $res = $db->loadObjectList('flota_company_id');
        return $res;
    }
}