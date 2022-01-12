<?php

namespace Intern\Chapter45\Controller\Post;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Classname extends \Magento\Framework\App\Action\Action
{
    protected $fileFactory;
    protected $csvProcessor;
    protected $directoryList;

    protected $_pageFactory;

    protected $customerSession;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        PageFactory $pageFactory
    )
    {
        $this->fileFactory = $fileFactory;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        $this->_pageFactory = $pageFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        $fileName = 'csv_filename.csv';
        $filePath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)
            . "/" . $fileName;

        $customer = $this->_customerSession->getCustomer();
        $personalData = $this->getPresonalData($customer);

        $this->csvProcessor
            ->setDelimiter(';')
            ->setEnclosure('"')
            ->saveData(
                $filePath,
                $personalData
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

    protected function getPresonalData( \Magento\Customer\Model\Customer $customer )
    {
        $customerData = $customer->getData();
        $result[] = [
            'address_id',
            'firstname',
            'middlename',
            'lastname',
            'email',
            'company',
            'street',
            'telephone',
            'fax',
        ];

        $addressId = 1;
        foreach ($customer->getAddresses() as $address) {
            $result[] = [
                $addressId,
                $address['firstname'],
                $address['middlename'],
                $address['lastname'],
                $customerData['email'],
                $address['company'],
                $address['street'],
                $address['telephone'],
                $address['fax'],
            ];
            $addressId++;
        }

        return $result;
    }
}
