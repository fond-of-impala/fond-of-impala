<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchBusinessFactory getFactory()
 */
class ProductListConditionalAvailabilityPageSearchFacade extends AbstractFacade implements ProductListConditionalAvailabilityPageSearchFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    public function expandConditionalAvailabilityPeriodPageSearchTransferWithProductLists(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer {
        return $this->getFactory()->createConditionalAvailabilityPeriodPageSearchExpander()
            ->expandWithProductLists($conditionalAvailabilityPeriodPageSearchTransfer);
    }
}
