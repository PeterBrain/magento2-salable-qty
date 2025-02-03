<?php
namespace PeterBrain\SalableQty\Block;

use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;
use Magento\InventorySalesApi\Api\StockResolverInterface;
use Magento\InventorySalesApi\Api\Data\SalesChannelInterface;
use PeterBrain\SalableQty\Helper\SalableQtyHelper as SalableQtyHelper;

/**
 * Class SalableQuantityBlock
 * salable quantity processing block
 *
 * @author PeterBrain <peter.loecker@live.at>
 * @copyright Copyright (c) PeterBrain (https://peterbrain.com/)
 */
class SalableQuantityBlock extends Template
{
    /**
     * @var Http
     */
    protected $_request;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var StockResolverInterface
     */
    protected $_stockResolver;

    /**
     * @var GetProductSalableQtyInterface
     */
    protected $_saleableQty;

    /**
     * @var SalableQtyHelper
     */
    protected $_salableQtyHelper;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Http $request
     * @param StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     * @param StockResolverInterface $stockResolver
     * @param GetProductSalableQtyInterface $saleableQty
     * @param SalableQtyHelper $salableQtyHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Http $request,
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository,
        StockResolverInterface $stockResolver,
        GetProductSalableQtyInterface $saleableQty,
        SalableQtyHelper $salableQtyHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_request = $request;
        $this->_storeManager = $storeManager;
        $this->_productRepository = $productRepository;
        $this->_stockResolver = $stockResolver;
        $this->_saleableQty = $saleableQty;
        $this->_salableQtyHelper = $salableQtyHelper;
    }

    /**
     * @return boolean
     */
    public function isEnabled(): bool
    {
        return $this->_salableQtyHelper->isEnabled();
    }

    /**
     * @return boolean
     */
    public function getDisableAddToCartButton(): bool
    {
        return $this->_salableQtyHelper->getDisableAddToCartButton();
    }

    /**
     * @return boolean
     */
    public function getEnableIcon(): bool
    {
        return $this->_salableQtyHelper->getEnableIcon();
    }

    /**
     * Return the actual salable quantity
     *
     * @return int|string
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getSalableQuantity()
    {
        $websiteCode = $this->_storeManager->getWebsite()->getCode();
        $stock = $this->_stockResolver->execute(SalesChannelInterface::TYPE_WEBSITE, $websiteCode);
        $stockId = $stock->getStockId();
        $productId = $this->_request->getParam('id');
        $product = $this->_productRepository->getById($productId);
        $type = $product->getTypeId();

        if ($type != 'configurable' && $type != 'bundle' && $type != 'grouped') {
            $sku = $product->getSku();
            $salableQty = $this->_saleableQty->execute($sku, $stockId);
            return $salableQty;
        } else {
            return $type;
        }
    }

    /**
     * Return message depending on salable quantity
     *
     * @return string
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getSalableQuantityMessage(): string
    {
        $salable_qty = $this->getSalableQuantity();

        if (is_numeric($salable_qty)) {
            $message_enabled = $this->_salableQtyHelper->getEnableMessage();
            $message_zero = $this->_salableQtyHelper->getMessageSalableQtyEq0();
            $threshold_enabled = $this->_salableQtyHelper->getEnableQtyThreshold();
            $message_threshold = $this->_salableQtyHelper->getMessageSalableQtyThreshold();
            $threshold = $this->_salableQtyHelper->getSalableQtyThreshold();

            if ($message_enabled) {
                if ($salable_qty < 1) {
                    return __($message_zero);
                } elseif ($threshold_enabled && ($salable_qty <= $threshold)) {
                    return __($message_threshold, $salable_qty);
                }
            }
        }

        return '';
    }
}
