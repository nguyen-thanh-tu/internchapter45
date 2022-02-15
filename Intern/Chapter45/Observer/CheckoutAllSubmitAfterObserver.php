<?php
namespace Intern\Chapter45\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CheckoutAllSubmitAfterObserver implements ObserverInterface
{
    /**
     *
     * @var \Intern\Chapter45\Helper\Data
     */
    protected $helper;

    /**
     * @param \Intern\Chapter45\Helper\Data $helper
     */
    public function __construct(
        \Intern\Chapter45\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        if(!$this->helper->isEnabled()) {
            return $this;
        }

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
