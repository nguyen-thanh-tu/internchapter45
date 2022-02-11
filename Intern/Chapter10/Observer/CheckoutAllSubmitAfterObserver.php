<?php

namespace Intern\Chapter10\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CheckoutAllSubmitAfterObserver implements ObserverInterface
{
    /**
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        if(!$order->getId()) {
            return $this;
        }
        if($order->getData('grand_total') == 0)
        {
            $invoice = $this->helper->createInvoice($order);
            if($invoice) {
                $this->helper->createShipment($order, $invoice);
            }
        }

        return $this;
    }
}
