<?php

namespace Intern\CustomizeInAdminhtml\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddProductAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $setup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * AccountPurposeCustomerAttribute constructor.
     * @param ModuleDataSetupInterface $setup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $setup,
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->setup = $setup;
    }

    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->setup]);

        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'course_start');
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'course_start',
            [
                'label' => 'Course Start',
                'group' => 'Course Schedule',
                'type' => 'datetime',
                'input' => 'date',
                'class' => 'validate-date',
                'backend' => \Magento\Catalog\Model\Attribute\Backend\Startdate::class,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => true,
                'filterable' => true,
                'filterable_in_search' => true,
                'visible_in_advanced_search' => true,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'course_end');
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'course_end',
            [
                'label' => 'Course End',
                'group' => 'Course Schedule',
                'type' => 'datetime',
                'input' => 'date',
                'class' => 'validate-date',
                'backend' => \Magento\Catalog\Model\Attribute\Backend\Startdate::class,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => true,
                'filterable' => true,
                'filterable_in_search' => true,
                'visible_in_advanced_search' => true,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );
//        $attributeSetId = $eavSetup->getDefaultAttributeSetId(\Magento\Catalog\Model\Product::ENTITY);
//        $attributeGroupName = 'Course Schedule';
//
//        // your custom attribute group/tab
//        $eavSetup->addAttributeGroup(
//            \Magento\Catalog\Model\Product::ENTITY,
//            $attributeSetId,
//            $attributeGroupName, // attribute group name
//            10 // sort order
//        );
//
//        // add attribute to group
//        $eavSetup->addAttributeToGroup(
//            \Magento\Catalog\Model\Product::ENTITY,
//            $attributeSetId,
//            $attributeGroupName, // attribute group
//            'course_start', // attribute code
//            10 // sort order
//        );
//
//        // add attribute to group
//        $eavSetup->addAttributeToGroup(
//            \Magento\Catalog\Model\Product::ENTITY,
//            $attributeSetId,
//            $attributeGroupName, // attribute group
//            'course_end', // attribute code
//            20 // sort order
//        );
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
