<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 24.11.2017
 * Time: 10:59
 */

namespace Majem\Flota\Admin\Helper;

use FOF30\Container\Container;
use JText;
use JFactory;

defined('_JEXEC') or die;

class Car
{

    public static function getRegistrationNumberHistory($id)
    {
        static $history  = null;

        if(is_null($history))
            $history = Container::getInstance('com_flota')->factory->model('Car')->tmpInstance()->getRegistrationNumberHistory($id);

        return $history;
    }

    public static function getEmployeHistory($id)
    {
        static $history  = null;

        if(is_null($history))
            $history = Container::getInstance('com_flota')->factory->model('Car')->tmpInstance()->getEmployeHistory($id);

        return $history;
    }

    public static function getServiceHistory($id)
    {
        static $history  = null;

        if(is_null($history))
            $history = Container::getInstance('com_flota')->factory->model('Car')->tmpInstance()->getServiceHistory($id);

        return $history;
    }

    public static function generateRegNumberTable($data)
    {
        if(is_array($data))
        {
            $html = '
            <div class="table-responsive">
            <table class="table table-bordered">';

            $html .= '
                <thead>
                    <tr>
                        <th>#</th>
                        <th>' . JText::_('COM_FLOTA_CAR_REGISTRATION_NUMBER_LBL') . '</th>
                        <th>' . JText::_('COM_FLOTA_MODYFICATION_DATE') . '</th>
                        <th>' . JText::_('COM_FLOTA_USER') . '</th>
                    </tr>
                </thead>
                <tbody>';
            $i = 1;
            foreach ($data as $item) {
                $html .= '
                    <tr>
                        <td>' . $i . '</td>
                        <td>' . $item->value . '</td>
                        <td>' . $item->date . '</td>
                        <td>' . JFactory::getUser($item->created_by)->name . '</td>
                    </tr>';
            }

            $html .= '
                </tbody>
            </table></div>';
        }

        return $html;
    }

    public static function generateEmployeTable($data)
    {
        if(is_array($data))
        {
            $html = '
            <div class="table-responsive">
            <table class="table table-bordered">';

            $html .= '
                <thead>
                    <tr>
                        <th>' . JText::_('COM_FLOTA_USER') . '</th>
                        <th>' . JText::_('COM_FLOTA_MODYFICATION_DATE') . '</th>
                    </tr>
                </thead>
                <tbody>';
            $i = 1;
            foreach ($data as $item) {
                $html .= '
                    <tr>
                        <td>' . JFactory::getUser($item->user_id)->name . '</td>
                        <td>' . $item->date . '</td>
                    </tr>';
            }

            $html .= '
                </tbody>
            </table></div>';
        }

        return $html;
    }
}