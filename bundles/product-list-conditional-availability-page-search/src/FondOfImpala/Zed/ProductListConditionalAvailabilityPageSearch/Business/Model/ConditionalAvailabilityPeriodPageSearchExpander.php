<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model;

use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Reader\ProductListReaderInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Generated\Shared\Transfer\ProductListMapTransfer;

class ConditionalAvailabilityPeriodPageSearchExpander implements ConditionalAvailabilityPeriodPageSearchExpanderInterface
{
    protected ProductListReaderInterface $productListReader;

    /**
     * @param \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Reader\ProductListReaderInterface $productListReader
     */
    public function __construct(
        ProductListReaderInterface $productListReader
    ) {
        $this->productListReader = $productListReader;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    public function expandWithProductLists(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer {
        $conditionalAvailabilityPeriodPageSearchTransfer->requireFkProduct();

        $conditionalAvailabilityPeriodPageSearchTransfer = $this->sanitize(
            $conditionalAvailabilityPeriodPageSearchTransfer,
        );

        $conditionalAvailabilityPeriodPageSearchTransfer = $this->expandWithWhitelistIds(
            $conditionalAvailabilityPeriodPageSearchTransfer,
        );

        $conditionalAvailabilityPeriodPageSearchTransfer = $this->expandWithBlacklistIds(
            $conditionalAvailabilityPeriodPageSearchTransfer,
        );

        return $conditionalAvailabilityPeriodPageSearchTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected function expandWithWhitelistIds(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer {
        $idProduct = $conditionalAvailabilityPeriodPageSearchTransfer->getFkProduct();

        $whitelists = $this->productListReader->getWhitelistIdsByIdProduct($idProduct);

        if ($whitelists) {
            $conditionalAvailabilityPeriodPageSearchTransfer->getProductListMap()->setWhitelists($whitelists);
        }

        return $conditionalAvailabilityPeriodPageSearchTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected function expandWithBlacklistIds(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer {
        $idProduct = $conditionalAvailabilityPeriodPageSearchTransfer->getFkProduct();

        $blacklists = $this->productListReader->getBlacklistIdsByIdProduct($idProduct);

        if ($blacklists) {
            $conditionalAvailabilityPeriodPageSearchTransfer->getProductListMap()->setBlacklists($blacklists);
        }

        return $conditionalAvailabilityPeriodPageSearchTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected function sanitize(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer {
        if ($conditionalAvailabilityPeriodPageSearchTransfer->getProductListMap() === null) {
            $conditionalAvailabilityPeriodPageSearchTransfer->setProductListMap(new ProductListMapTransfer());
        }

        return $conditionalAvailabilityPeriodPageSearchTransfer;
    }
}
