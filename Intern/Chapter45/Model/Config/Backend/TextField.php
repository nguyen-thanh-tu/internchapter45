<?php

namespace Intern\Chapter45\Model\Config\Backend;

class TextField extends \Magento\Framework\App\Config\Value
{
    const CUSTOM_OPTION_STRING_PATH = 'setting/post/age';

    protected $_configValueFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Config\ValueFactory $configValueFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param string $runModelPath
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Config\ValueFactory $configValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_configValueFactory = $configValueFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function beforeSave()
    {
        $label = $this->getData('field_config/label');
        $textvalue = $this->getValue();

        $this->_eventManager->dispatch("intern_chapter45_save_textfield", ['textvalue' => $this]);

//        if ($this->getValue() == 'Ping') {
//            $textvalue = 'Pong';
//        }

        $this->setValue($textvalue);

        parent::beforeSave();
    }

    public function afterSave()
    {
        $value = 'Intern Chapter45';

        try {
            $this->_configValueFactory->create()->load(
                self::CUSTOM_OPTION_STRING_PATH,
                'path'
            )->setValue(
                $value
            )->setPath(
                self::CUSTOM_OPTION_STRING_PATH
            )->save();
        } catch (\Exception $e) {
            throw new \Exception(__('We can\'t save new option.'));
        }

        return parent::afterSave();
    }
}
