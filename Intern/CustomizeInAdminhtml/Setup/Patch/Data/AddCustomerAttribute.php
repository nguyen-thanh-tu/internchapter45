<?php

namespace Intern\CustomizeInAdminhtml\Setup\Patch\Data;

use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCustomerAttribute implements DataPatchInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $setup;

    /**
     * @var Config
     */
    private $eavConfig;

    private $file;
    private $dir;
    /**
     * AccountPurposeCustomerAttribute constructor.
     * @param ModuleDataSetupInterface $setup
     * @param Config $eavConfig
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        File $file,
        DirectoryList $dir,
        ModuleDataSetupInterface $setup,
        Config $eavConfig,
        CustomerSetupFactory $customerSetupFactory
    )
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->setup = $setup;
        $this->eavConfig = $eavConfig;
        $this->file = $file;
        $this->dir = $dir;
    }

    public function apply()
    {
        $images = $this->dir->getPath('media').'/magenestimage/tmp';
        if ( ! file_exists($images)) {
            $this->file->mkdir($images);
        }

        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerSetup->getDefaultAttributeSetId($customerEntity->getEntityTypeId());
        $attributeGroup = $customerSetup->getDefaultAttributeGroupId($customerEntity->getEntityTypeId(), $attributeSetId);
        $customerSetup->removeAttribute(Customer::ENTITY, 'imagessss');
        $customerSetup->addAttribute(Customer::ENTITY, 'imagessss', [
            'type' => 'text',
            'input' => 'file',
            'label' => 'My Avatar',
            'required' => false,
            'visible' => false,
            'user_defined' => false,
            'system' => false,
            'backend' => '',
            'position' => 300
        ]);
        $newAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'imagessss');
        $newAttribute->addData([
            'used_in_forms' => ['adminhtml_checkout','adminhtml_customer','customer_account_edit','customer_account_create'],
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroup
        ]);
        $newAttribute->save();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    public static function getVersion()
    {
        return '1.0.1';
    }
}
