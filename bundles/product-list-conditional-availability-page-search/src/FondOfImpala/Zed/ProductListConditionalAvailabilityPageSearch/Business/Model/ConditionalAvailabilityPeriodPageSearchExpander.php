<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model;

use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Generated\Shared\Transfer\ProductListMapTransfer;

class ConditionalAvailabilityPeriodPageSearchExpander implements ConditionalAvailabilityPeriodPageSearchExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface
     */
    protected $productListFacade;

    /**
     * @param \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface $productListFacade
     */
    public function __construct(
        ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface $productListFacade
    ) {
        $this->productListFacade = $productListFacade;
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

        $whitelists = $this->productListFacade->getProductWhitelistIdsByIdProduct($idProduct);

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

        $blacklists = $this->productListFacade->getProductBlacklistIdsByIdProduct($idProduct);

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
