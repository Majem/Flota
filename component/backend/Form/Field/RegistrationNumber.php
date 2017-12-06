<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 24.11.2017
 * Time: 08:22
 */

namespace Majem\Flota\Admin\Form\Field;

use FOF30\Form\Field\Text;
use Majem\Flota\Admin\Helper\Car;
use Majem\Flota\Admin\Helper\Modal;
use \JHtml;
use JText;
use SimpleXMLElement;
defined('_JEXEC') or die;


class RegistrationNumber extends Text
{
    public function __get($name)
    {
        switch ($name)
        {
            case 'static':
                if (empty($this->static))
                {
                    $this->static = $this->getStatic();
                }
                return $this->static;
                break;
            case 'repeatable':
                if (empty($this->repeatable))
                {
                    $this->repeatable = $this->getRepeatable();
                }
                return $this->repeatable;
                break;
            case 'input':
                return $this->getInput();
                break;
            default:
                return parent::__get($name);
        }
    }

    public function getInput()
    {
        // Get model
        $model  = $this->form->getModel();
        $data = $model->toArray();

        // Get item id
        $item_id = $data['flota_car_id'];
        $value = $this->value;
        $name =  $this->name;
        $showHistory = $this->element['history'];
        $modalId = $name . '_modal';


        // Initialize some field attributes.
        $class       = $this->class ? $this->class : '';

        $html = '<input type="text"  name="' . $name . '" value="' . $value . '" class="' . $class . '">';

        if($showHistory && $item_id)
        {
            $history = Car::getRegistrationNumberHistory($item_id);

            if($history)
            {
                $modal_body = Car::generateRegNumberTable($history);

                $html .= '<button type="button" class="btn btn-secondary" data-modal="' . $modalId . '"><span class="icon-book"></span></button>';
                $html .= Modal::createModal(JText::_(strtoupper($modalId . '_TITLE')),$modal_body,$modalId);
            }
        }


        $html .= '</div>';

        return $html;
    }
}