<?php

namespace Nimbus\CTAColorChange\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config {

    /**
     * Path to config value, wich sets if the moduel is enabled or not
     */
    CONST XML_PATH_ENABLED  = 'nimbus_cta_color_change/general/enabled';

    /**
     * Path to config value, wich sets the button text color of product view add to cart
     */
    CONST XML_PATH_COLOR    = 'nimbus_cta_color_change/general/color';

    /**
     * Path to config value, wich sets the button background color of product view add to cart
     */
    CONST XML_PATH_BGCOLOR  = 'nimbus_cta_color_change/general/bg_color';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    protected $scopeConfig;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check if the moduel is enabled
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE) == 1;
    }

    /**
     * Gets the text color to apply on the button add to cart in the product page
     * @return string
     */
    public function getTextColor()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_COLOR, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Gets the background color to apply on the button add to cart in the product page
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_BGCOLOR, ScopeInterface::SCOPE_STORE);
    }

}
