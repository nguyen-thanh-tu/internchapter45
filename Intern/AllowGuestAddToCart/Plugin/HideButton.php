<?php
namespace Intern\AllowGuestAddToCart\Plugin;

use Magento\Catalog\Model\Product;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Customer\Model\Session;
class HideButton
{
    const ENABLEGUESTADDTOCART = 'checkout/cart/guest_add_to_cart';

    private $scopeConfig;
    private $session;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Session $session
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->session = $session;
    }

    public function afterIsSaleable(Product $product, $result)
    {
        $enable = $this->scopeConfig->getValue(static::ENABLEGUESTADDTOCART);
        if($enable == 1 && $this->session->isLoggedIn())
        {
            return $result;
        }
        return [];
    }
}
