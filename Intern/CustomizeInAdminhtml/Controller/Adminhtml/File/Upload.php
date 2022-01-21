<?php

namespace Intern\CustomizeInAdminhtml\Controller\Adminhtml\File;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Backend\App\Action\Context;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\Downloadable\Helper\File;
use Intern\CustomizeInAdminhtml\Ui\DataProvider\Product\Form\Modifier\References;

class Upload extends \Magento\Backend\App\Action
{
    public $_uploaderFactory;
    private $storageDatabase;

    public function __construct(
        Context $context,
        Filesystem $filesystem,
        UploaderFactory $_uploaderFactory,
        Database $storageDatabase,
        File $fileHelper
    )
    {
        parent::__construct($context);
        $this->_varDirectory = $filesystem->getDirectoryWrite('media');
        $this->_uploaderFactory = $_uploaderFactory;
        $this->storageDatabase = $storageDatabase;
        $this->_fileHelper = $fileHelper;
    }

    public function execute()
    {
        try {
            $tmpPath ='magenestimage/tmp';
            $uploader = $this->_uploaderFactory->create(['fileId' => References::GRID_OPTIONS_NAME]);

            $result = $this->_fileHelper->uploadFromTmp($tmpPath, $uploader);

            if (!$result) {
                throw new FileSystemException(
                    __('File can not be moved from temporary folder to the destination folder.')
                );
            }

            unset($result['tmp_name'], $result['path']);

            if (isset($result['file'])) {
                $relativePath = rtrim($tmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->storageDatabase->saveFile($relativePath);
            }
        } catch (\Throwable $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
