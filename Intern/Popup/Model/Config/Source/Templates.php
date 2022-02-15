<?php
/**
 * Intern LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.Intern.com/Intern-LICENSE-COMMUNITY.txt
 *
 ********************************************************************
 * @category   Intern
 * @package    Intern_Popup
 * @copyright  Copyright (c) Intern LLC. (http://www.Intern.com)
 * @license    http://store.Intern.com/Intern-LICENSE-COMMUNITY.txt
 */
namespace Intern\Popup\Model\Config\Source;

/**
 * Class Templates
 * @package Intern\Popup\Model\Config\Source
 */
class Templates implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $templatePath = BP . '/pub/media/promopopup/templates/';
        $files = array_slice(scandir($templatePath), 2);
        $index = [];
        foreach ($files as $file) {
            $fileParts = explode('_',$file);
            $holidayName = ucwords($fileParts[1]);
            $holidayId =  strtolower(str_replace(['_','.html'],[' ',''],$fileParts[1]));
            $typeId = strtolower(str_replace(['_','.html'],[' ',''],$fileParts[2]));
            $content = file_get_contents($templatePath.$file);
            $index[$typeId][$holidayId] = (isset($index[$typeId]) && isset( $index[$typeId][$holidayId])) ? $index[$typeId][$holidayId]+1 : 1;
            $options[] = ['value'=>$content,'label'=>'Template '.$index[$typeId][$holidayId],'holiday'=>$holidayName,'holidayId'=>$holidayId,'typeId'=>$typeId];

        }
        return $options;
    }
}
