<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication\Plugin\ProductPageSearch\DataExpander;

use Generated\Shared\Transfer\ProductListMapTransfer;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;
use Orm\Zed\ProductList\Persistence\Map\SpyProductListTableMap;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

/**
 * @method \Spryker\Zed\ProductListSearch\Business\ProductListSearchFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductListSearch\Communication\ProductListSearchCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductListSearch\ProductListSearchConfig getConfig()
 */
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
    public function expandProductPageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer): void
    {
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
        return $this->getProductPayload($productData)->getStockStatus() ?? [];
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
     * @param array<string> $stockstatus
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
