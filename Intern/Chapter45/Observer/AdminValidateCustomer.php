<?php

namespace Intern\Chapter45\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Filesystem;
use Magento\Framework\Exception\LocalizedException;

class AdminValidateCustomer implements \Magento\Framework\Event\ObserverInterface
{

    public function execute(Observer $observer)
    {
        $request = ($observer->getData())['request'];
        $custome = ($observer->getData('customer'));
        $cu = $custome->getCustomAttributes('avatar');

        if(isset(($request->getParam('customer'))['avatar']))
        {
            if(isset(($request->getParam('customer'))['avatar']['0']['tmp_name']))
            {
                $filename = ($request->getParam('customer'))['avatar']['0']['tmp_name'];
                $array = explode ( '.' , $filename);
                $fileextension = array_pop($array);
                $validateImage = ['png', 'jpg', 'jpeg', 'gif'];
                if(in_array($fileextension, $validateImage) == false){
                    throw new LocalizedException(
                        __('Image format is not true.')
                    );
                }
            }
        }

        if(count($cu) > 0)
        {
            foreach($cu as $key => $value)
            {
                if($key == 'avatar')
                {
                    if(Is_string($cu['avatar']->getValue()) == false)
                    {
                        $cu['avatar']->setValue('');
                    }
                    if(strlen($cu['avatar']->getValue()) > 0)
                    {
                        $filename = $cu['avatar']->getValue();
                        $array = explode ( '.' , $filename);
                        $fileextension = array_pop($array);
                        $validateImage = ['png', 'jpg', 'jpeg', 'gif'];
                        if(in_array($fileextension, $validateImage) == false){
                            throw new LocalizedException(
                                __('Image format is not true.')
                            );
                        }
                    }
                }
            }
        }

        return $observer;
    }
}

