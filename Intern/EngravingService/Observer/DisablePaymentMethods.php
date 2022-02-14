<?php
namespace Intern\EngravingService\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
class DisablePaymentMethods implements ObserverInterface
{
    protected $_customerSession;
    protected $_logger;
    protected $_cart;
    protected $productRepository;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\API\ProductRepositoryInterface $productRepository,
        \Magento\Checkout\Model\Cart $_cart
    ) {
        $this->_customerSession = $customerSession;
        $this->_logger = $logger;
        $this->_cart = $_cart;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $result = $observer->getEvent()->getResult();
        $method_instance = $observer->getEvent()->getMethodInstance()->getCode();
        $quote = $observer->getEvent()->getQuote();
        $items = $this->_cart->getItems();
        foreach ($items as $item) {
            $product_id = $item->getData('product')->getData('entity_id');
            $engraving_service = $this->productRepository
                ->getById($product_id)
                ->getCustomAttribute('engraving_service');
            if($engraving_service != null)
            {
                if($engraving_service->getValue() == 1)
                {
                    if($method_instance == 'cashondelivery')
                    {
                        $customerGroupId = $this->getGroupId();
                        if($customerGroupId == 1)
                        {
                            $result->setData('is_available', false);
                        }
                    }
                }
            }
        }
    }

    public function getGroupId(){
        if($this->_customerSession->isLoggedIn()):
            return $customerGroup=$this->_customerSession->getCustomer()->getGroupId();
        endif;
    }
}
