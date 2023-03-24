<?php
namespace PeterBrain\SalableQty\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class SalableQtyHelper
 *
 * @author PeterBrain <peter.loecker@live.at>
 * @copyright Copyright (c) PeterBrain (https://peterbrain.com/)
 * @package PeterBrain\SalableQty\Helper
 */
class SalableQtyHelper extends AbstractHelper
{
    const CONFIG_MODULE_PATH = 'pb_salableqty';

    /**
     * @param string $code
     * @param null $storeId
     *
     * @return mixed
     */
    public function getConfigGeneral(string $code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getConfigValue(static::CONFIG_MODULE_PATH . '/general' . $code, $storeId);
    }

    /**
     * @param string $code
     * @param null $storeId
     *
     * @return mixed
     */
    public function getConfigGeneralMessage(string $code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getConfigValue(static::CONFIG_MODULE_PATH . '/general/message' . $code, $storeId);
    }

    /**
     * @param string $code
     * @param null $storeId
     *
     * @return mixed
     */
    public function getConfigGeneralThreshold(string $code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getConfigValue(static::CONFIG_MODULE_PATH . '/threshold' . $code, $storeId);
    }

    /**
     * @param string $configPath
     * @param null $storeId
     *
     * @return string
     */
    public function getConfigValue(string $configPath, $storeId = null): string
    {
        return $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function isEnabled($storeId = null): string
    {
        return $this->getConfigGeneral('enable', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getDisableAddToCartButton($storeId = null): string
    {
        return $this->getConfigGeneral('disable_add2cart_button', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getEnableIcon($storeId = null): string
    {
        return $this->getConfigGeneral('enable_add2cart_icon', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getEnableMessage($storeId = null): string
    {
        return $this->getConfigGeneralMessage('enable_message', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getMessageSalableQtyEq0($storeId = null): string
    {
        return $this->getConfigGeneralMessage('message_qty_zero', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getEnableQtyThreshold($storeId = null): string
    {
        return $this->getConfigGeneralThreshold('enable_qty_threshold', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getMessageSalableQtyThreshold($storeId = null): string
    {
        return $this->getConfigGeneralThreshold('message_qty_threshold', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return int
     */
    public function getSalableQtyThreshold($storeId = null): int
    {
        return $this->getConfigGeneralThreshold('salable_qty_threshold', $storeId);
    }
}
