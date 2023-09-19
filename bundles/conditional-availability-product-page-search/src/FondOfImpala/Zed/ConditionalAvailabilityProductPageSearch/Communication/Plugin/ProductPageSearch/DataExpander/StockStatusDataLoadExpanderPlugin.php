<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch\DataExpander;

use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

class StockStatusDataLoadExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return void
     */
    public function expandProductPageData(
        array $productData,
        ProductPageSearchTransfer $productAbstractPageSearchTransfer
    ): void {
        $stockStatus = $this->getStockStatus($productData);

        $productAbstractPageSearchTransfer->setStockStatus([]);

        if (!count($stockStatus)) {
            return;
        }

        $this->expandProductPageDataWithStockStatus($productAbstractPageSearchTransfer, $stockStatus);
    }

    /**
     * @param array<string, mixed> $productData
     *
     * @return array<string>
     */
    protected function getStockStatus(array $productData): array
    {
        return $this->getProductPayload($productData)->getStockStatus();
    }

    /**
     * @param array<string, mixed> $productData
     *
     * @return \Generated\Shared\Transfer\ProductPayloadTransfer
     */
    protected function getProductPayload(array $productData): ProductPayloadTransfer
    {
        return $productData[ProductPageSearchConfig::PRODUCT_ABSTRACT_PAGE_LOAD_DATA];
    }

    /**
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     * @param array<string> $stockStatus
     *
     * @return void
     */
    protected function expandProductPageDataWithStockStatus(
        ProductPageSearchTransfer $productAbstractPageSearchTransfer,
        array $stockStatus
    ): void {
        $productAbstractPageSearchTransfer->setStockStatus($stockStatus);
    }
}
