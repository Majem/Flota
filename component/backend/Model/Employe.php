<?php
/**
 * @package   AkeebaSubs
 * @copyright Copyright (c)2010-2017 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 3, or later
 */

namespace Majem\Flota\Admin\Model;

defined('_JEXEC') or die;

use FOF30\Container\Container;
use FOF30\Date\Date;
use FOF30\Model\DataModel;
use JLoader;
use \JText;


class Employe extends DataModel
{

	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);


		// Always load the Filters behaviour
		$this->addBehaviour('Filters');
		$this->addBehaviour('RelationFilters');
	}

    public function save($data = null, $orderingFilter = '', $ignore = null, $resetRelations = true)
    {
        $user_id = $data['user_id'];
        $flota_company_id = $data['flota_company_id'];
       // $this->userExistInCompany($user_id,$flota_company_id);
      //  throw new \RuntimeException(JText::_('COM_FLOTA_EMPLOYE_EXISTS_MSG','as'));
        parent::save($data,$orderingFilter,$ignore,$resetRelations);
	}


    /**
     * Build the SELECT query for returning records. Overridden to apply custom filters.
     *
     * @param   \JDatabaseQuery  $query           The query being built
     * @param   bool             $overrideLimits  Should I be overriding the limit state (limitstart & limit)?
     *
     * @return  void
     */
    public function onAfterBuildQuery(\JDatabaseQuery $query, $overrideLimits = false)
    {
        $db = $this->getDbo();


        // Search by user name
        $name = $this->getState('name', null, 'string');
        if (!empty($name))
        {
            $search = '%' . $name . '%';


            // Get all users with name equals value
            $subs = $this->container->factory->model('JoomlaUsers')->tmpInstance();
            $users = $subs->where(
                'name','like',$search
            )->get();


            // Convert to ids array
            $filteredIDs = $subs->get(true)->modelKeys();
            $filteredIDs = empty($filteredIDs) ? [-1] : $filteredIDs;
            $filteredIDs = array_unique($filteredIDs);

            $ids = array();

            foreach ($filteredIDs as $id)
            {
                $id = (int)$id;
                if ($id == 0)
                {
                    continue;
                }
                $ids[] = $db->q($id);
            }


            if (!empty($ids))
            {
                $query->where(
                    $db->qn('user_id') . ' IN (' .
                    implode(',', $ids) . ')'
                );
            }
        }

        // Search by company name
        $company = $this->getState('company', null, 'string');
        if (!empty($company))
        {
            $search = '%' . $company . '%';

            // Get all companies with name
            $subs = $this->container->factory->model('Company')->tmpInstance();
            $companies = $subs->where(
                'name','like',$search
            )->get();


            $filteredIDs = $subs->get(true)->modelKeys();
            $filteredIDs = empty($filteredIDs) ? [-1] : $filteredIDs;
            $filteredIDs = array_unique($filteredIDs);

            $ids = array();

            foreach ($filteredIDs as $id)
            {
                $id = (int)$id;
                if ($id == 0)
                {
                    continue;
                }
                $ids[] = $db->q($id);
            }


            if (!empty($ids))
            {
                $query->where(
                    $db->qn('flota_company_id') . ' IN (' .
                    implode(',', $ids) . ')'
                );
            }
        }

    }

    // Get Joomla user by employe id
    public function getEmployeById($flota_employe_id)
    {
        // Get item previous save
        $db = $this->container->platform->getDbo();
        $query = $db->getQuery(true)
            ->select(array('e.flota_employe_id','e.flota_company_id','u.name'))
            ->from($db->qn('#__flota_employes','e'))
            ->join('INNER', $db->quoteName('#__users', 'u') . ' ON (' . $db->quoteName('e.user_id') . ' = ' . $db->quoteName('u.id') . ')')
            ->where( $db->qn('e.flota_employe_id') . ' = ' . $flota_employe_id );
        $db->setQuery($query);
        return $db->loadObject();
    }

    // Get all employes
    public function getEmployes()
    {
        // Get item previous save
        $db = $this->container->platform->getDbo();
        $query = $db->getQuery(true)
            ->select(array('e.flota_employe_id','e.flota_company_id','u.name'))
            ->from($db->qn('#__flota_employes','e'))
            ->join('INNER', $db->quoteName('#__users', 'u') . ' ON (' . $db->quoteName('e.user_id') . ' = ' . $db->quoteName('u.id') . ')');
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    // Check user exists in company
    private function userExistInCompany($user_id,$company_id)
    {
        // Get item previous save
        $db = $this->container->platform->getDbo();
        $query = $db->getQuery(true)
            ->select(array(' user_id'))
            ->from($db->qn('#__flota_employes'))
            ->where($db->qn('user_id') . '=' . $db->q($user_id) . ' AND ' . $db->qn('flota_company_id') . '=' . $db->q($company_id));
        $db->setQuery($query);
        $emp = $db->loadObject();

        if(!is_null($emp))
            return true;
        else
            return false;
    }
}