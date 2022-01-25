<?php

namespace Intern\CustomizeInAdminhtml\Plugin;

class ExportItemsOrder
{
    public function __construct(
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    )
    {
        $this->fileFactory = $fileFactory;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
    }

    public function afterGetItemsCollection(\Magento\Sales\Block\Adminhtml\Order\View\Items $subject, $result)
    {
        $i = 0;
        $_items = $subject->getData('order')->getData('items');
        $itemData[] = [
            'product_id',
            'sku',
            'name',
            'price',
        ];
        foreach ($_items as $_item){
            if ($_item->getParentItem()) {
                continue;
            }else{
                $i++;
            }
            $itemData[] = [
                $_item->getData('product_id'),
                $_item->getData('sku'),
                $_item->getData('name'),
                $_item->getData('price'),
            ];
        }

        $fileName = 'csv_items.csv';
        $filePath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)
            . "/" . $fileName;
        $this->csvProcessor
            ->setDelimiter(';')
            ->setEnclosure('"')
            ->saveData(
                $filePath,
                $itemData
            );

        $create = $this->fileFactory->create(
            $fileName,
            [
                'type' => "filename",
                'value' => $fileName,
                'rm' => true,
            ],
            \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR,
            'application/octet-stream'
        );
        return $result;
    }
}
