<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 24.11.2017
 * Time: 08:22
 */

namespace Majem\Flota\Admin\Form\Field;

use FOF30\Form\Field\GenericList ;
use FOF30\Form\FieldInterface;
use FOF30\Form\Form;
use FOF30\Model\DataModel;
use FOF30\Utils\StringHelper;
use Joomla\Utilities\ArrayHelper;
use \JText;
use \JHtml;
use Majem\Flota\Admin\Helper\Car;
use Majem\Flota\Admin\Helper\Employe;
use Majem\Flota\Admin\Helper\Company;
use Majem\Flota\Admin\Helper\Modal;
defined('_JEXEC') or die;


class EmployeSelect extends GenericList
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

        // Render select
        $html = parent::getInput();

        if($showHistory && !is_null($item_id))
        {

            // Get item history
            $history = Car::getEmployeHistory($item_id);

            // If history count > 0
            if($history)
            {
                // History button
                $html .= '<button type="button" class="btn btn-secondary" data-modal="' . $modalId . '"><span class="icon-book"></span></button>';
                $modal_body = Car::generateEmployeTable($history);
                $html .= Modal::createModal(JText::_(strtoupper($modalId . '_TITLE')),$modal_body,$modalId);
            }
        }

        return $html;
    }

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since	Ordering is available since FOF 2.1.b2.
     */
    protected function getOptions()
    {
        // Get all employes
        $employes = Employe::getEmployes(true);
        $companies = Company::getCompanies();



        foreach($companies as $company)
        {
            // Insert disable options for separate companies
            $options[] = JHtml::_('select.option', (string)0 , $company->name, 'value', 'text', ((string) 'true'));
            if($employes[$company->flota_company_id])
            {
                foreach ($employes[$company->flota_company_id] as $employe)
                {

                    $options[] = JHtml::_('select.option', (string)$employe->flota_employe_id , $employe->name, 'value', 'text');
                }
            }
        }
        reset($options);
        return $options;
    }

    /**
     * Get the rendering of this field type for a repeatable (grid) display,
     * e.g. in a view listing many item (typically a "browse" task)
     *
     * @since 2.0
     *
     * @return  string  The field HTML
     */
    public function getRepeatable()
    {
        // Get attributes
        $link_url = $this->element['link_url'];

        if (isset($this->element['legacy']))
        {
            return $this->getInput();
        }

        // Get user data
        $flota_employe_id = $this->value;
        $employe = Employe::getEmployeById($flota_employe_id);


        $html = "";

        if(!is_null($employe))
        {
            if ($link_url)
            {
                $replacements = array(
                    '[ITEM:EMPLOYE_ID]' => $flota_employe_id,
                );

                foreach ($replacements as $key => $value)
                {
                    $link_url = str_replace($key, $value, $link_url);
                }

                $html .= '<a href="' . $link_url . '">';
            }


            $html .= $employe->name;

            if($link_url)
                $html .= '</a>';
        }


        return $html;
    }
}