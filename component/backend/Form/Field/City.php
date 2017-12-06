<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 05.12.2017
 * Time: 08:09
 */

namespace Majem\Flota\Admin\Form\Field;

use FOF30\Form\Field\Text;
use Majem\Flota\Admin\Helper\Car;
use Majem\Flota\Admin\Helper\Modal;
use \JHtml;
use JText;
use SimpleXMLElement;
defined('_JEXEC') or die;

class City extends Text
{

    // Generate js for city autocomplete
    private function getJs($input_id)
    {
        $this->form->getContainer()->template->addJSInline('jQuery( document ).ready(function() {
            jQuery(\'input#' . $input_id . '\').cityAutocomplete();
});');
    }


    public function getInput()
    {

        $container = $this->form->getContainer();
        $template = $container->template;

        // Get google api key
        $google_key = $container->params->get('google_api');

        // Include important css and js
        $template->addJS('https://maps.googleapis.com/maps/api/js?key=' . $google_key . '&libraries=places');
        $template->addJS('media://com_flota/js/jquery.city-autocomplete.js');
        $template->addCSS('media://com_flota/css/city-autocomplete.css');


        // Get attributes
        $autocomplete = $this->element['autocomplete'];
        $data_country = $this->element['data-country'];
        $required = $this->element['required'];
        $disabled = $this->element['disabled'];
        $input_value = $this->value;
        $input_name =  $this->name;
        $input_id = $this->id;

        // Generate city input
        $html = '<input type="text" id="' . $input_id . '" name="' . $input_name . '" value="' . $input_value . '" autocomplete="' . $autocomplete . '" data-country="' . $data_country . '" ' . (($disabled) ? 'disabled' : '') . ' ' . (($required) ? 'required="true"' : '') . ' >';
        // Include inline css
        $this->getJs($input_id);

        return $html;
    }
}