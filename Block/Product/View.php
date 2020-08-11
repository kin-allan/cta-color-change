<?php

namespace Nimbus\CTAColorChange\Block\Product;

use Magento\Store\Model\ScopeInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Framework\Url\EncoderInterface as UrlEncoderInterface;
use Magento\Framework\Json\EncoderInterface as JsonEncoderInterface;
use Magento\Framework\Stdlib\StringUtils;
use Magento\Catalog\Helper\Product;
use Magento\Catalog\Model\ProductTypes\ConfigInterface;
use Magento\Framework\Locale\FormatInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Nimbus\CTAColorChange\Model\Config;

class View extends \Magento\Catalog\Block\Product\View {

    /**
     * @var Config
     */
    protected $config;

    /**
     * View constructor
     * @param Context                    $context
     * @param UrlEncoderInterface        $urlEncoder
     * @param JsonEncoderInterface       $jsonEncoder
     * @param StringUtils                $string
     * @param Product                    $productHelper
     * @param ConfigInterface            $productTypeConfig
     * @param FormatInterface            $localeFormat
     * @param CustomerSession            $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param PriceCurrencyInterface     $priceCurrency
     * @param Config                     $config
     * @param array                      $data
     */
    public function __construct(
        Context $context,
        UrlEncoderInterface $urlEncoder,
        JsonEncoderInterface $jsonEncoder,
        StringUtils $string,
        Product $productHelper,
        ConfigInterface $productTypeConfig,
        FormatInterface $localeFormat,
        CustomerSession $customerSession,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        Config $config,
        array $data = [])
    {
        $this->config = $config;

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

    /**
     * Check if the module is enabled
     * @return boolean
     */
    public function isCTAColorChangeEnable()
    {
        return $this->config->isEnabled();
    }

    /**
     * Get the button text color setting
     * @return string
     */
    public function getTextColor()
    {
        return "#" . ltrim($this->config->getTextColor(), "#");
    }

    /**
     * Get the button background text color setting
     * @return string
     */
    public function getBackgroundColor()
    {
        return "#" . ltrim($this->config->getBackgroundColor(), "#");
    }
}
