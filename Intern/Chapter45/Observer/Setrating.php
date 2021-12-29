<?php

namespace Intern\Chapter45\Observer;

use Magento\Framework\Event\Observer;

class Setrating implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(Observer $observer)
    {
        $data = $observer->getData('movieData');
        $data->setData('rating', 0);
        $observer->setData('movieData', $data);
    }
}
