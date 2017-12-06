<?php
namespace Majem\Flota\Admin\View\Car;

use Majem\Flota\Admin\Model\Car;
use Majem\Flota\Admin\Helper\Car as CarHelper;

class Form extends \FOF30\View\DataView\Form
{
    protected $flota_car_id;


    public function onBeforeEdit($tpl = null)
    {
        /** @var DataModel $model */
        $model = $this->getModel();

        $data = $model->toArray();

        $this->flota_car_id = $data['flota_car_id'];
    }


    public function getServiceHistory()
    {
        $item_id = $this->flota_car_id;

        return CarHelper::getServiceHistory($item_id);
    }

}