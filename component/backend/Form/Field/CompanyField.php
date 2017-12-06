<?php
/**
 * @package   AkeebaSubs
 * @copyright Copyright (c)2010-2016 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 3, or later
 */

namespace Majem\Flota\Admin\Form\Field;

use Majem\Flota\Admin\Helper\Company as CompanyHelper;
use FOF30\Form\Field\GenericList;
use JText;
use JHtml;
defined('_JEXEC') or die;

/**
 * Renders the limits imposed on Coupon entries
 */
class CompanyField extends GenericList
{
    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since	Ordering is available since FOF 2.1.b2.
     */
    protected function getOptions()
    {
        $companies = CompanyHelper::getCompanies();

        foreach($companies as $company)
        {
            $disabled = ((!$company->enabled) ? true : false);

            $options[] = JHtml::_('select.option', (string)$company->flota_company_id ,$company->name, 'value', 'text',((string) $company->enabled == 'true'));

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
        if (isset($this->element['legacy']))
        {
            return $this->getInput();
        }


        // Get the company
        $company = CompanyHelper::getCompanyById($this->item->flota_company_id);
        $link_url      = $this->element['link_url'] ? $this->element['link_url'] : null; // check if Field is url

        $html = "";

        if($link_url)
        {
            // Replace variables
            $replacements = array(
                '[ITEM:COMPANY_ID]' => $company->flota_company_id
            );

            foreach ($replacements as $key => $value)
            {
                $link_url = str_replace($key, $value, $link_url);
            }

            $html .= '<a href="' . $link_url . '">';
        }

        $html .= '<span >' . $company->name . '</span>';

        if($link_url)
            $html .= '</a>';

        return $html;
	}
}