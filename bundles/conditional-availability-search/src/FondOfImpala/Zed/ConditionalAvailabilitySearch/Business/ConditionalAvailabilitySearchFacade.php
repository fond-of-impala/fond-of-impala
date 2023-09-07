<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business;

use Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer;
use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ConditionalAvailabilitySearchBusinessFactory getFactory()
 */
class ConditionalAvailabilitySearchFacade extends AbstractFacade implements ConditionalAvailabilitySearchFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<int> $concreteIds
     *
     * @return array<int>
     */
    public function getProductAbstractIdsByConcreteIds(array $concreteIds): array
    {
        return $this->getFactory()
            ->createProductAbstractReader()
            ->getProductAbstractIdsByConcreteIds($concreteIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $loadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageData(ProductPageLoadTransfer $loadTransfer): ProductPageLoadTransfer
    {
        return $this->getFactory()->createProductPageDataExpander()->expandProductPageData($loadTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer $conditionalAvailabilityMapTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer
     */
    public function mapProductDataToConditionalAvailabilityMapTransfer(
        array $productData,
        ConditionalAvailabilityMapTransfer $conditionalAvailabilityMapTransfer
    ): ConditionalAvailabilityMapTransfer {
        return $this->getFactory()
            ->createProductDataToConditionalAvailabilityMapTransferMapper()
            ->mapProductDataToConditionalAvailabilityMapTransfer($productData, $conditionalAvailabilityMapTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    public function expandProductConcretePageSearchTransferWithStockStatus(
        ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
    ): ProductConcretePageSearchTransfer {
        return $this->getFactory()
            ->createProductConcretePageSearchExpander()
            ->expandProductConcretePageSearchTransferWithStockStatus($productConcretePageSearchTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    public function expandProductAbstractPageSearchTransferWithStockStatus(
        ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
    ): ProductConcretePageSearchTransfer {
        return $this->getFactory()
            ->createProductConcretePageSearchExpander()
            ->expandProductConcretePageSearchTransferWithStockStatus($productConcretePageSearchTransfer);
    }
}
