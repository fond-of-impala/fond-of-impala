<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander;

use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;

class ProductConcretePageSearchExpander implements ProductConcretePageSearchExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade)
    {
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    public function expandProductConcretePageSearchTransferWithStockStatus(
        ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
    ): ProductConcretePageSearchTransfer {
        $productConcretePageSearchTransfer->requireFkProduct();

        $stockStatus = [
            'B2B' => 1
        ];

        $productConcretePageSearchTransfer->getConditionalAvailabilityMap()->setStockStatus($stockStatus);

        return $productConcretePageSearchTransfer;
    }
}
