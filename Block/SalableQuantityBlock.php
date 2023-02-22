<?php

namespace PeterBrain\SalableQty\Block;

use PeterBrain\SalableQty\Helper\Data as Helper;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;
use Magento\InventorySalesApi\Api\StockResolverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\InventorySalesApi\Api\Data\SalesChannelInterface;

/**
 * Class SalableQuantityBlock
 * @package PeterBrain\SalableQty\Block
 */
class SalableQuantityBlock extends Template
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var GetProductSalableQtyInterface
     */
    protected $saleableQty;

    /**
     * @var StockResolverInterface
     */
    protected $stockResolver;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Http
     */
    protected $request;

    /**
     * @var ScopeConfigInterface
     */
    //protected $scopeConfig;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface $storeManager
     * @param GetProductSalableQtyInterface $saleableQty
     * @param Http $request
     * @param StockResolverInterface $stockResolver
     * @param Context $context
     * @param Helper $helper
     * @param array $data
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        GetProductSalableQtyInterface $saleableQty,
        Http $request,
        StockResolverInterface $stockResolver,
        Context $context,
        Helper $helper,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->saleableQty = $saleableQty;
        $this->stockResolver = $stockResolver;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Return the actual salable quantity
     *
     * @return int|string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getSalableQuantity()
    {
        $websiteCode = $this->storeManager->getWebsite()->getCode();
        $stock = $this->stockResolver->execute(SalesChannelInterface::TYPE_WEBSITE, $websiteCode);
        $stockId = $stock->getStockId();
        $productId = $this->request->getParam('id');
        $product = $this->productRepository->getById($productId);
        $type = $product->getTypeId();

        if ($type != 'configurable' && $type != 'bundle' && $type != 'grouped') {
            $sku = $product->getSku();
            $salableQty = $this->saleableQty->execute($sku, $stockId);
            return $salableQty;
        } else {
            return '';
        }
    }

    /**
     * Return message depending on salable quantity
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getSalableQuantityMessage()
    {
        $salable_qty = $this->getSalableQuantity();

        $message_enabled = $this->helper->getEnableMessage();
        $message_zero = $this->helper->getMessageSalableQtyEq0();
        $threshold_enabled = $this->helper->getEnableQtyThreshold();
        $message_threshold = $this->helper->getMessageSalableQtyThreshold();
        $threshold = $this->helper->getSalableQtyThreshold();

        if ($message_enabled) {
            if ($salable_qty < 1) {
                return __($message_zero);
            } else if ($threshold_enabled && ($salable_qty <= $threshold)) {
                return __($message_threshold, $salable_qty);
            }
        }

        return '';
    }
}
