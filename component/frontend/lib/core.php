<?php
/**
 *  @package Virtualmoney
 *  @copyright Copyright (c)2013 JoomPROD
 *  @license GNU General Public License version 3, or later
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

include_once(JPATH_LIBRARIES . '/fof30/include.php');

if(is_file(JPATH_ROOT.'/libraries/juloalib/Lib.php')){
    include_once(JPATH_ROOT.'/libraries/juloalib/Lib.php');
}

class Flota
{
	public static function getCompanyById($flota_company_id)
	{
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select(array(
                $db->qn('name')
            ))
            ->from($db->qn('#__flota_companies'))
            ->where($db->qn('flota_company_id') . ' = ' . $flota_company_id);
        $db->setQuery($query);
        $res = $db->loadObject();
        return $res;
	}
}

