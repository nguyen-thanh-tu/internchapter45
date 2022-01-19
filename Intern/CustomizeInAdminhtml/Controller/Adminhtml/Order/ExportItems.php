<?php

namespace Intern\CustomizeInAdminhtml\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class ExportItems extends \Magento\Backend\App\Action
{
    protected $_pageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    )
    {
        $this->orderRepository = $orderRepository;
        $this->_pageFactory = $pageFactory;
        $this->fileFactory = $fileFactory;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        parent::__construct($context);
    }

    public function execute()
    {
        $order_id = $this->getRequest()->getParam('order_id');
        $_items = $this->getOrderItemCollection($order_id);
        $itemData[] = [
            'product_id',
            'sku',
            'name',
            'price',
            'qty_ordered',
            'tax_amount',
            'tax_percent',
            'discount_amount',
            'row_total'
        ];
        $i = 0;
        foreach ($_items as $_item){
            if ($_item->getParentItem()){
                continue;
            }else {
                $i++;
            }
            $itemData[] = [
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

        $fileName = 'csv_items_orderid_'.$order_id.'.csv';
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


