<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 23.11.2017
 * Time: 08:44
 */

namespace Majem\Flota\Admin\Helper;

use FOF30\Container\Container;

defined('_JEXEC') or die;

class Employe
{

    public static function getEmployes($separate_companies = false)
    {
        static $employes  = null;

        if(is_null($employes))
        {
            $results = Container::getInstance('com_flota')->factory->model('Employe')->tmpInstance()->getEmployes();

            if($separate_companies)
                foreach ($results as $result) {
                    $employes[$result->flota_company_id][] = $result;
                }
            else
                $employes = $results;
        }

        return $employes;
    }

    public static function getEmployeById($flota_employe_id)
    {
        static $employe  = null;
        static $employe_id;

        if(is_null($employe_id) || $employe_id != $flota_employe_id)
        {
            $employe = Container::getInstance('com_flota')->factory->model('Employe')->tmpInstance()->getEmployeById($flota_employe_id);
        }

        return $employe;
    }
}