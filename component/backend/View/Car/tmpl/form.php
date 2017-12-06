<?php
/**
 *  @package AkeebaSubs
 *  @copyright Copyright (c)2010-2017 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */
/** @var \FOF30\View\DataView\Form $this */
// Protect from unauthorized access
defined('_JEXEC') or die();

$this->addCssFile('media://com_flota/css/backend.css');


JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', '#flota_employe_id', '#company_id', array(
    'disable_search_threshold' => 0
));


echo $this->getRenderedForm();
$services = $this->getServiceHistory();
if($services) :?>
<hr>
<h3><?php echo JText::_('COM_FLOTA_CAR_SERVICE_HISTORY_ITEM')  ?></h3>

    <div class="panel-group" id="accordion">
        <?php foreach ($services as $service): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <?php echo $service->date_begin . (($service->date_end) ? ' - ' . $service->date_end : '') . ' ( ' . $service->mandatory . ' )'?>
                        <a data-toggle="collapse" data-parent="#accordion" href="#service<?php echo $service->id ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </h4>
                </div>
                <div id="service<?php echo $service->id ?>" class="panel-collapse collapse">
                    <?php echo  JFactory::getUser($item->user_id)->name ?><div class="panel-body"><blockquote><?php echo $service->description ?></blockquote></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<script>
    jQuery(document).ready(function($){

        var owner = $("#ownership_type");
        check_owner(owner.val());

        owner.on('change',function () {

            check_owner($(this).val());
        });






        $("button[data-modal]").on('click',function () {
            var modal_id = $(this).attr('data-modal');
            console.log(modal_id);
            $("#" + modal_id).modal();
        });

        $('#accordion .panel-collapse').on('show.bs.collapse', function () {
            $(this).prev().find(".fa").removeClass("fa-plus").addClass("fa-minus");
        });

//The reverse of the above on hidden event:

        $('#accordion .panel-collapse').on('hidden.bs.collapse', function () {
            $(this).prev().find(".fa").removeClass("fa-minus").addClass("fa-plus");
        });


        function check_owner(owner)
        {
            if(owner == 3)
            {
                $("#company_id").prop('disabled', false).trigger("liszt:updated");
                $("input[name=owner]").prop('disabled', true);

            }
            else
            {
                $("input[name=owner]").prop('disabled', false);
                $("#company_id").prop('disabled', true).trigger("liszt:updated");
            }
        }
    });



</script>


