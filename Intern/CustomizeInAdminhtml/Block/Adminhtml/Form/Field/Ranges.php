<?php

namespace Intern\CustomizeInAdminhtml\Block\Adminhtml\Form\Field;

use Intern\CustomizeInAdminhtml\Block\Adminhtml\Form\Field\CustomerGroupColumn;
use Intern\CustomizeInAdminhtml\Block\Adminhtml\Form\Field\DateField;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Ranges
 */
class Ranges extends AbstractFieldArray
{
    /**
     * @var CustomerGroupColumn
     */
    private $taxRenderer;

    private $_dateRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('customer_group', [
            'label' => __('Customer Group'),
            'renderer' => $this->getCustomerGroupRenderer()
        ]);
        $this->addColumn('course_start', [
            'label' => __('Start'),
            'id' => 'course_start',
            'class' => 'daterecuring',
            'style' => 'width:200px'
        ]);
        $this->addColumn('course_end', [
            'label' => __('End'),
            'id' => 'course_end',
            'class' => 'daterecuring',
            'style' => 'width:200px'
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

//        $tax = $row->getTax();
//        if ($tax !== null) {
//            $options['option_' . $this->getCustomerGroupRenderer()->calcOptionHash($tax)] = 'selected="selected"';
//        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return CustomerGroupColumn
     * @throws LocalizedException
     */
    private function getCustomerGroupRenderer()
    {
        if (!$this->taxRenderer) {
            $this->taxRenderer = $this->getLayout()->createBlock(
                CustomerGroupColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->taxRenderer;
    }
//
//    protected function _getDateColumnRenderer() {
//        if( !$this->_dateRenderer ) {
//            $this->_dateRenderer = $this->getLayout()->createBlock(
//                DateField::class,
//                '',
//                [
//                    'data' => [
//                        'is_render_to_js_template' => true,
//                        'date_format'              => 'dd/mm/Y'
//                    ]
//                ]
//            );
//        }
//
//        return $this->_dateRenderer;
//    }
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = parent::_getElementHtml($element);

        $script = '<script type="text/javascript">
                require([
                    "jquery",
                    "jquery/ui",
                    "mage/calendar"
                    ], function ($) {
                    $(function(){
                        function bindDatePicker() {
                            setTimeout(function() {
                                $(".daterecuring").datetimepicker( {
                                dateFormat: "mm/dd/yy",
                                minDate: 8,
                                maxDate: 12,
                                timeFormat: "HH:mm:ss",
                                showTime: true,
                                showHour: true,
                                showMinute: true,
                                } );
                            }, 50);
                        }
                        bindDatePicker();
                        $("button.action-add").on("click", function(e) {
                            bindDatePicker();
                        });
                    });
                });
            </script>';
        $html .= $script;
        return $html;
    }
}
