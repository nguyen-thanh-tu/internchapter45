<?php

namespace Intern\CustomizeInAdminhtml\Controller\Adminhtml\Sales;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class ExportAllItems extends \Magento\Backend\App\Action
{
    protected $_pageFactory;
    protected $_orderCollectionFactory;
    private $storeManager;
    private $groupRepository;
    private $websiteRepository;

    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Model\GroupRepository $groupRepository,
        \Magento\Store\Model\WebsiteRepository $websiteRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->_pageFactory = $pageFactory;
        $this->fileFactory = $fileFactory;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->storeManager = $storeManager;
        $this->groupRepository = $groupRepository;
        $this->websiteRepository = $websiteRepository;

        parent::__construct($context);
    }

    public function execute()
    {
        $itemData[] = [
            'ID Order',
            'Purchase Point',
            'Purchase Date',
            'Product Id',
            'SKU',
            'Name',
            'Price',
            'Qty Ordered',
            'Tax Amount',
            'Tax Percent',
            'Discount Amount',
            'Row Total'
        ];

        $orders = $this->_orderCollectionFactory->create()->getData();
        foreach($orders as $order)
        {
            $storeData = $this->storeManager->getStore($order['store_id']);
            $website_id = $storeData->getData('website_id');
            $group_id = $storeData->getData('group_id');
            $websiteData = $this->websiteRepository->getById($website_id);
            $groupData = $this->groupRepository->get($group_id);
            $storeNane = $storeData->getData('name');
            $groupName = $groupData->getData('name');
            $websiteName = $websiteData->getData('name');
            $purchasePoint = $websiteName.'->'.$groupName.'->'.$storeNane;
            $_items = $this->getOrderItemCollection($order['entity_id']);
            $i = 0;
            foreach ($_items as $_item){
                if ($_item->getParentItem()){
                    continue;
                }else {
                    $i++;
                }
                $itemData[] = [
                    $order['increment_id'],
                    $purchasePoint,
                    $order['created_at'],
                    $_item->getData('product_id'),
                    $_item->getData('sku'),
                    $_item->getData('name'),
                    $_item->getData('price'),
                    $_item->getData('qty_ordered'),
                    $_item->getData('tax_amount'),
                    $_item->getData('tax_percent'),
                    $_item->getData('discount_amount'),
                    $_item->getData('row_total')
                ];
            }
        }
        $fileName = 'csv_items_order.csv';
        $filePath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)
            . "/" . $fileName;
        $this->csvProcessor
            ->setDelimiter(';')
            ->setEnclosure('"')
            ->saveData(
                $filePath,
                $itemData
            );

        return $this->fileFactory->create(
            $fileName,
            [
                'type' => "filename",
                'value' => $fileName,
                'rm' => true,
            ],
            \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR,
            'application/octet-stream'
        );
    }

    public function getOrderItemCollection($orderId)
    {
        return $this->orderRepository->get($orderId)->getItemsCollection();
    }
}
