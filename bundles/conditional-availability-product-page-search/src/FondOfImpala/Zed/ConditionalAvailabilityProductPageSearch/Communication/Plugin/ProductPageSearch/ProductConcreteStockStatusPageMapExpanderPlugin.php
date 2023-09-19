<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductConcretePageMapExpanderPluginInterface;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchFacadeInterface getFacade()
 */
class ProductConcreteStockStatusPageMapExpanderPlugin extends AbstractPlugin implements ProductConcretePageMapExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands provided PageMapTransfer with stock status.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expand(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer
    ): PageMapTransfer {
        if (!isset($productData[ProductPageSearchTransfer::STOCK_STATUS])) {
            return $pageMapTransfer;
        }

        return $this->setStockStatusData($pageMapTransfer, $productData);
    }

    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array<string, mixed> $productData
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    protected function setStockStatusData(PageMapTransfer $pageMapTransfer, array $productData): PageMapTransfer
    {
        return $pageMapTransfer->setStockStatus($productData[ProductPageSearchTransfer::STOCK_STATUS]);
    }
}
