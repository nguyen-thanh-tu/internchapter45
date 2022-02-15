<?php

namespace Intern\CustomizeInAdminhtml\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Intern\CustomizeInAdminhtml\Model\ResourceModel\ReferencesLink\Collection as ReferencesLinkCollection;
use Intern\CustomizeInAdminhtml\Model\ResourceModel\ReferencesFile\Collection as ReferencesFileCollection;
use Magento\Store\Model\StoreManagerInterface;
class SendOrderEmailObserver extends \Magento\Framework\App\Helper\AbstractHelper implements ObserverInterface
{
    const DIR_SAVE_IMAGE = "magenestimage";

    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $storeManager;

    private $referencesLinkCollection;
    private $referencesFileCollection;

    public function __construct(
        Context $context,
        \Magento\Framework\Filesystem $filesystem,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        ReferencesLinkCollection $referencesLinkCollection,
        ReferencesFileCollection $referencesFileCollection,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->referencesLinkCollection = $referencesLinkCollection;
        $this->referencesFileCollection = $referencesFileCollection;
        $this->_varDirectory = $filesystem->getDirectoryWrite('media');
        $this->storeManager = $storeManager;
        $this->logger = $context->getLogger();
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $dataOrder = $observer->getData('order')->getData();
        $customer_email = $dataOrder['customer_email'];
        $items = $dataOrder['items'];

        $stringHtml = '';

        $originPath = $_SERVER['HTTP_ORIGIN'].'/media/';
        foreach($items as $item)
        {
            $product_id = $item->getData('product_id');
            $dataLinks = $this->referencesLinkCollection->getDataByProductId($product_id);
            $dataFiles = $this->referencesFileCollection->getDataByProductId($product_id);

            if(count($dataLinks) > 0 || count($dataFiles) > 0)
            {
                $stringHtml = $stringHtml.'Khóa học : '.$item->getData('name').' ';
            }

            if(count($dataLinks) > 0)
            {
                foreach($dataLinks as $dataLink)
                {
                    $stringHtml = $stringHtml.$dataLink['references_link_title'].' Link kham khảo: '.$dataLink['references_link']. ' ';
                }
            }
            if(count($dataFiles) > 0)
            {
                foreach($dataFiles as $dataFile)
                {
                    $file_link = $originPath.static::DIR_SAVE_IMAGE.$dataFile['references_file'];
                    $stringHtml = ' '.$stringHtml.$dataFile['references_file_title'].' '.$file_link.' ';
                }
            }
        }
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Test'),
                'email' => $this->escaper->escapeHtml('humorgodfather9x02@gmail.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('customizeadminhtml_order_template')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'templateVar'  => 'My Topic',
                    'templateHtml'  => $stringHtml,
                ])
                ->setFrom($sender)
                ->addTo($customer_email)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}

