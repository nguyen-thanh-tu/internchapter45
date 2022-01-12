<?php

namespace Intern\Chapter45\Plugin\CheckoutCart;

use Magento\Checkout\Block\Cart\Item\Renderer;


class ImageAndName
{
    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Helper\ImageFactory $imageHelperFactory
    )
    {
        $this->_productRepository = $productRepository;
        $this->imageHelperFactory = $imageHelperFactory;
    }

    public function afterGetImage(Renderer $subject, $result)
    {
        $product = $subject->getProduct();
        if($product->getData("type_id") != "simple")
        {
            $subProductInCart = ($product->getCustomOptions())['simple_product']->getData();
            $subProduct = $this->_productRepository
                ->getById($subProductInCart['product_id']);
            $imageUrl = $this->imageHelperFactory
                ->create()
                ->init($subProduct, 'product_thumbnail_image')
                ->getUrl();
            $result->setImageUrl($imageUrl);
        }
        return $result;
    }

    public function afterGetProductName(Renderer $subject, $result)
    {
        $product = $subject->getProduct();
        if($product->getData("type_id") != "simple")
        {
            $subProductInCart = ($product->getCustomOptions())['simple_product']->getData();
            $subProduct = $this->_productRepository
                ->getById($subProductInCart['product_id'])
                ->getData();
            $result = $subProduct["name"];
        }
        return $result;
    }


}
