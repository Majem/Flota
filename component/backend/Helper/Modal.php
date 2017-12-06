<?php
/**
 * Created by PhpStorm.
 * User: m.maciejewski
 * Date: 24.11.2017
 * Time: 10:10
 */

namespace Majem\Flota\Admin\Helper;


defined('_JEXEC') or die;

class Modal
{


    public static function createModal($title,$body,$id)
    {
        $html = '
        <div id="' . $id . '" class="modal fade flota-modal" data-modal-width="20%" role="dialog">
            <div class="modal-header">
                <button type="button" class="close novalidate" data-dismiss="modal">×</button>
                <h3>' . $title . '</h3>
	        </div>
            <div class="modal-body">' . $body . '</div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal">Anuluj</a>
            </div>
        </div>';

        return $html;
    }
}