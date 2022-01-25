<?php

namespace Intern\CustomizeInAdminhtml\Observer;

use Magento\Framework\Event\Observer;
use Intern\CustomizeInAdminhtml\Model\ReferencesLinkFactory;
use Intern\CustomizeInAdminhtml\Model\ReferencesFileFactory;
use Intern\CustomizeInAdminhtml\Ui\DataProvider\Product\Form\Modifier\References;
use Intern\CustomizeInAdminhtml\Model\ResourceModel\ReferencesLink\Collection as ReferencesLinkCollection;
use Intern\CustomizeInAdminhtml\Model\ResourceModel\ReferencesFile\Collection as ReferencesFileCollection;

class CatalogProductSave implements \Magento\Framework\Event\ObserverInterface
{
    private $referencesLinkFactory;
    private $referencesFileFactory;

    private $referencesLinkCollection;
    private $referencesFileCollection;

    const DIR_SAVE_IMAGE = "magenestimage";

    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $_uploaderFactory,
        ReferencesLinkFactory $referencesLinkFactory,
        ReferencesFileFactory $referencesFileFactory,
        ReferencesLinkCollection $referencesLinkCollection,
        ReferencesFileCollection $referencesFileCollection
    ) {
        $this->_uploaderFactory = $_uploaderFactory;
        $this->_varDirectory = $filesystem->getDirectoryWrite('media');
        $this->referencesLinkFactory = $referencesLinkFactory;
        $this->referencesFileFactory = $referencesFileFactory;
        $this->referencesLinkCollection = $referencesLinkCollection;
        $this->referencesFileCollection = $referencesFileCollection;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getData('product')->getdata();
        $originPath = $this->_varDirectory->getAbsolutePath();

        $this->referencesFileCollection->deleteDataByProductId($product['entity_id']);
        $this->referencesLinkCollection->deleteDataByProductId($product['entity_id']);

        if(isset($product['references_file']))
        {
            foreach ($product['references_file'] as $requestReferencesFile)
            {
                $newDataReferencesFile = [
                    'references_file_title' => $requestReferencesFile[References::FIELD_TITLE_NAME],
                    'references_file' => $requestReferencesFile[References::FIELD_FILE_NAME][0]['file'],
                    'references_file_name' => $requestReferencesFile[References::FIELD_FILE_NAME][0]['name'],
                    'references_file_size' => $requestReferencesFile[References::FIELD_FILE_NAME][0]['size'],
                    'references_file_status' => $requestReferencesFile[References::FIELD_FILE_NAME][0]['status'],
                    'product_entity_id' => $product['entity_id'],
                ];
                $referencesFile = $this->referencesFileFactory->create();
                $referencesFile->addData($newDataReferencesFile);
                $referencesFile->save();
                $this->_varDirectory->copyFile(
                    $originPath.static::DIR_SAVE_IMAGE.'/tmp'.$requestReferencesFile[References::FIELD_FILE_NAME][0]['file'],
                    $originPath.static::DIR_SAVE_IMAGE.$requestReferencesFile[References::FIELD_FILE_NAME][0]['file']
                );
            }
        }

        if(isset($product['references_link']))
        {
            foreach ($product['references_link'] as $requestReferencesLink)
            {
                $newDataReferencesLink = [
                    'references_link_title' => $requestReferencesLink[References::FIELD_TITLE_NAME],
                    'references_link' => $requestReferencesLink[References::FIELD_LINK_NAME],
                    'product_entity_id' => $product['entity_id'],
                ];
                $referencesLink = $this->referencesLinkFactory->create();
                $referencesLink->addData($newDataReferencesLink);
                $referencesLink->save();
            }
        }

    }
}
