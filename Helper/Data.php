<?php

namespace PeterBrain\SalableQty\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const CONFIG_MODULE_PATH = 'pb_salableqty';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @param string $code
     * @param null $storeId
     *
     * @return mixed
     */
    public function getConfigGeneral($code = '', $storeId = null)
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
    public function getConfigGeneralMessage($code = '', $storeId = null)
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
    public function getConfigGeneralThreshold($code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getConfigValue(static::CONFIG_MODULE_PATH . '/threshold' . $code, $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return bool
     */
    public function isEnabled($storeId = null)
    {
        return $this->getConfigGeneral('enable', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return bool
     */
    public function getDisableAddToCartButton($storeId = null)
    {
        return $this->getConfigGeneral('disable_add2cart_button', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return bool
     */
    public function getEnableMessage($storeId = null)
    {
        return $this->getConfigGeneralMessage('enable_message', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getMessageSalableQtyEq0($storeId = null)
    {
        return $this->getConfigGeneralMessage('message_qty_zero', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return bool
     */
    public function getEnableQtyThreshold($storeId = null)
    {
        return $this->getConfigGeneralThreshold('enable_qty_threshold', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return string
     */
    public function getMessageSalableQtyThreshold($storeId = null)
    {
        return $this->getConfigGeneralThreshold('message_qty_threshold', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return int
     */
    public function getSalableQtyThreshold($storeId = null)
    {
        return $this->getConfigGeneralThreshold('salable_qty_threshold', $storeId);
    }

}
