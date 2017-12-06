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
class Car extends DataModel
{
    protected $registred_number;
    protected $flote_employe_id;

    public function __construct(Container $container, array $config = array())
    {
        parent::__construct($container, $config);


        // Always load the Filters behaviour
        $this->addBehaviour('Filters');
        $this->addBehaviour('RelationFilters');
    }


    public function onBeforeSave(&$data)
    {
        $flota_car_id = $data['flota_car_id'];

        $item = $this->getItem($flota_car_id);
        if(!is_null($item))
        {

            $this->prev_registred_number = $item->registration_number;
            $this->prev_flota_employe_id = $item->flota_employe_id;


        }
    }



    public function onAfterSave()
    {
        // Check if registred number was changed
        $container = $this->getContainer();
        $flota_car_id = $container->input->get('flota_car_id');


        $new_flota_employe_id = $container->input->get('flota_employe_id','','number');
        $prev_flota_employe_id = $this->prev_flota_employe_id;
        $new_registred_number = trim($container->input->get('registration_number','','string'));
        $prev_registred_number = trim($this->prev_registred_number);
        $user_id = ((( $container->input->get('modyfied_by') == 0 )) ? $container->input->get('created_by') : $container->input->get('modyfied_by') );


        // If usser change reg number
        if($new_registred_number != $prev_registred_number && !is_null($prev_registred_number)  )
        {
            $object = new \stdClass();
            $object->flota_car_id = $flota_car_id;
            $object->value = $prev_registred_number;
            $object->date = Date("Y-m-d");
            $object->user_id = $user_id;
            $this->InsertRegNumberHistory($object);
        }

        // If usser change enploye
        if($new_flota_employe_id != $prev_flota_employe_id && !is_null($prev_flota_employe_id)  )
        {
            echo $prev_flota_employe_id . ' ' . $new_flota_employe_id;


            $object = new \stdClass();
            $object->flota_car_id  = $flota_car_id;
            $object->value = $prev_flota_employe_id;
            $object->date = Date("Y-m-d");
            $this->InsertEmployeHistory($object);
        }
    }
    /**
     * Get history Registration Field
     */
    public function getItem($id)
    {
        // Get item previous save
        $db = $this->container->platform->getDbo();
        $query = $db->getQuery(true)
            ->select(array('*'))
            ->from($db->qn('#__flota_cars'))
            ->where($db->qn('flota_car_id') . '=' . $db->q($id));
        $db->setQuery($query);
        return $db->loadObject();
    }

    /**
     * Get car service history
     */
    public function getServiceHistory($id)
    {
        $db    = $this->getDbo();
        $query = $db->getQuery(true)
            ->select(array(
                $db->qn('h.id'),
                $db->qn('h.date_begin'),
                $db->qn('h.date_end'),
                $db->qn('h.mandatory'),
                $db->qn('h.description')
            ))
            ->from($db->qn('#__flota_cars_service_history','h'))
            ->where($db->qn('flota_car_id') . ' =  ' . $id);
        $db->setQuery($query);
        $res = $db->loadObjectList();
        return $res;
    }

    /**
     * Get history Registration Field
     */
    public function getEmployeHistory($id)
    {
        $db    = $this->getDbo();
        $query = $db->getQuery(true)
            ->select(array(
                $db->qn('e.user_id'),
                $db->qn('h.date')
            ))
            ->from($db->qn('#__flota_cars_employe_history','h'))
            ->join('INNER', $db->quoteName('#__flota_employes', 'e') . ' ON (' . $db->quoteName('h.value') . ' = ' . $db->quoteName('e.flota_employe_id') . ')')
            ->where($db->qn('flota_car_id') . ' =  ' . $id);
        $db->setQuery($query);
        $res = $db->loadObjectList();
        return $res;
    }

    /**
     * Insert registration history into database
     */
    private function InsertEmployeHistory($object)
    {
        return JFactory::getDbo()->insertObject('#__flota_cars_employe_history', $object);
    }

    /**
     * Get history Registration Field
     */
    public function getRegistrationNumberHistory($id)
    {
        $db    = $this->getDbo();
        $query = $db->getQuery(true)
            ->select(array(
                $db->qn('value'),
                $db->qn('date'),
                $db->qn('user_id'),
            ))
            ->from($db->qn('#__flota_cars_registration_number_history'))
            ->where($db->qn('flota_car_id') . ' =  ' . $id);
        $db->setQuery($query);
        $res = $db->loadObjectList();
        return $res;
    }

    /**
     * Insert registration history into database
     */
    private function InsertRegNumberHistory($object)
    {
        return JFactory::getDbo()->insertObject('#__flota_cars_registration_number_history', $object);
    }
}