<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 01.12.2017
 * Time: 11:40
 */

namespace Majem\Flota\Admin\Form\Field;

use FOF30\Form\Exception\DataModelRequired;
use FOF30\Form\FieldInterface;
use FOF30\Form\Form;
use FOF30\Model\DataModel;
use \JHtml;
use \JText;

defined('_JEXEC') or die;


class Availability extends \JFormFieldList implements FieldInterface
{
    /**
     * @var  string  Static field output
     */
    protected $static;
    /**
     * @var  string  Repeatable field output
     */
    protected $repeatable;
    /**
     * The Form object of the form attached to the form field.
     *
     * @var    Form
     */
    protected $form;
    /**
     * A monotonically increasing number, denoting the row number in a repeatable view
     *
     * @var  int
     */
    public $rowid;
    /**
     * The item being rendered in a repeatable form field
     *
     * @var  DataModel
     */
    public $item;
    /**
     * Method to get certain otherwise inaccessible properties from the form field object.
     *
     * @param   string  $name  The property name for which to the the value.
     *
     * @return  mixed  The property value or null.
     *
     * @since   2.0
     */
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

    protected function getConfig()
    {
       return array(
            'COM_FLOTA_AVAILABILITY_AVAILABLE'  => array(
                'icon' => 'check',
                'value' => 1),
            'COM_FLOTA_AVAILABILITY_IN_REPAIR'	=> array(
                'icon' => 'wrench',
                'value' => 2),
            'COM_FLOTA_AVAILABILITY_SOLD'		 => array(
                'icon' => 'usd',
                'value' => 3),
        );
    }


    /**
     * Method to get the field options.
     *
     * @since 2.0
     *
     * @return  array  The field option objects.
     */
    protected function getOptions()
    {
        // Get config
        $config = $this->getConfig();

        $stack = array();
        foreach($config as $lang_var => $value)
        {
            $stack[] = JHtml::_('select.option', $value['value'], JText::_($lang_var));
        }
        return $stack;
    }
    /**
     * Get the rendering of this field type for static display, e.g. in a single
     * item view (typically a "read" task).
     *
     * @since 2.0
     *
     * @return  string  The field HTML
     */
    public function getStatic()
    {
        $class = $this->class ? ' class="' . $this->class . '"' : '';
        return '<span id="' . $this->id . '" ' . $class . '>' .
            htmlspecialchars(GenericList::getOptionName($this->getOptions(), $this->value), ENT_COMPAT, 'UTF-8') .
            '</span>';
    }
    /**
     * Get the rendering of this field type for a repeatable (grid) display,
     * e.g. in a view listing many item (typically a "browse" task)
     *
     * @since 2.0
     *
     * @return  string  The field HTML
     *
     * @throws  DataModelRequired
     */
    public function getRepeatable()
    {
        $options = $this->getConfig();
        $selected = $this->value;


        foreach ($options as $lang_var => $data)
        {
            if($selected == $data['value'])
            {
                $tooltip = $lang_var;
                $icon = $data['icon'];
            }
        }

        return '<button class="btn active hasTooltip" onclick="return false" title="" data-original-title="' . JText::_($tooltip) . '"><i class="fa fa-' . $icon . '" aria-hidden="true"></i></button>';
    }
}