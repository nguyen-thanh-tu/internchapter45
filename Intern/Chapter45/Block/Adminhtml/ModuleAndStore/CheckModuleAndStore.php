<?php

namespace Intern\Chapter45\Block\Adminhtml\ModuleAndStore;

class CheckModuleAndStore extends \Magento\Framework\View\Element\Template
{
    protected $fullModuleList;
    protected $customerFactory;
    protected $productFactory;
    protected $orderFactory;
    protected $invoiceRepository;
    protected $creditmemoRepository;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Module\FullModuleList $fullModuleList,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Sales\Api\InvoiceRepositoryInterface $invoiceRepository,
        \Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository,
        array $data = []
    ) {
        $this->fullModuleList = $fullModuleList;
        $this->customerFactory = $customerFactory;
        $this->productFactory = $productFactory;
        $this->orderFactory = $orderFactory;
        $this->invoiceRepository = $invoiceRepository;
        $this->creditmemoRepository = $creditmemoRepository;
        parent::__construct($context, $data);
    }

    public function modulesList()
    {

        $customer = $this->customerFactory->create()->getCollection()->addAttributeToSelect("*")->load();
        $product = $this->productFactory->create()->getCollection()->addAttributeToSelect("*")->load();
        $order = $this->orderFactory->create()->getCollection()->addAttributeToSelect("*")->load();
        $invoice = $this->invoiceRepository->create()->getCollection()->addAttributeToSelect("*")->load();
        $creditmemo = $this->creditmemoRepository->create()->getCollection()->addAttributeToSelect("*")->load();

        $allModules = $this->fullModuleList->getAll();

        $totalCustomer = count($customer->getItems());
        $totalProduct = count($product->getItems());
        $totalOrder = count($order->getItems());
        $totalInvoice = count($invoice->getItems());
        $totalCreditmemo = count($creditmemo->getItems());
        $totalModule = count($allModules);

        $total = [];
        $total['totalModule'] = $totalModule;
        $total['allModules'] = $allModules;
        $total['totalCustomer'] = $totalCustomer;
        $total['totalProduct'] = $totalProduct;
        $total['totalOrder'] = $totalOrder;
        $total['totalInvoice'] = $totalInvoice;
        $total['totalCreditmemo'] = $totalCreditmemo;

        $moduleName = $this->fullModuleList->getNames();
        $total_module_non_magento = 0;
        foreach($moduleName as $name)
        {
            if (strlen(strstr($name, 'Magento_')) == 0) {
                $total_module_non_magento++;
            }
        }
        $total['total_module_non_magento'] = $total_module_non_magento;
        return $total;
    }
}
