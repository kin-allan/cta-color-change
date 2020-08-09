<?php

namespace Nimbus\CTAColorChange\Block\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\ScopeInterface;

class View extends \Magento\Catalog\Block\Product\View {

    protected $scopeConfig;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = [])
    {
        $this->scopeConfig = $scopeConfig;

        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $data
        );
    }

    public function isCTAColorChangeEnable()
    {
        return $this->scopeConfig->getValue("nimbus_cta_color_change/general/enabled", ScopeInterface::SCOPE_STORE) == 1 ? true : false;
    }

    public function getTextColor()
    {
        return "#" . ltrim($this->scopeConfig->getValue("nimbus_cta_color_change/general/color", ScopeInterface::SCOPE_STORE), "#");
    }

    public function getBackgroundColor()
    {
        return "#" . ltrim($this->scopeConfig->getValue("nimbus_cta_color_change/general/bg_color", ScopeInterface::SCOPE_STORE), "#");
    }
}
