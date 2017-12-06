<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 23.11.2017
 * Time: 07:52
 */

namespace Majem\Flota\Admin\Helper;

use FOF30\Container\Container;

defined('_JEXEC') or die;

class Company
{
    public static function getCompanies()
    {
        static $companies  = null;

        if(is_null($companies))
        {
            $results = Container::getInstance('com_flota')->factory->model('Company')->tmpInstance()->getCompanies();

            foreach ($results as $result) {
                $companies[$result->flota_company_id] = $result;
            }
        }
        return $companies;
    }


    public static function getCompanyById($flota_company_id)
    {
        static $companies  = null;

        if(is_null($companies))
            $companies = self::getCompanies();

        if($companies[$flota_company_id])
            return $companies[$flota_company_id];
        else
            return null;
    }

}