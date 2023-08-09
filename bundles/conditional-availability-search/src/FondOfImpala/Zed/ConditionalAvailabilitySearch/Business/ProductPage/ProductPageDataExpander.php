<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ProductPage;

use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ProductPageLoadTransfer;

class ProductPageDataExpander implements ProductPageDataExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade)
    {
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $productPageLoadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageData(ProductPageLoadTransfer $productPageLoadTransfer): ProductPageLoadTransfer
    {
        /*$conditionalAvailability = $this->conditionalAvailabilityFacade
            ->getConditionalAvailabilitytIdsByProductAbstractIds($productPageLoadTransfer->getProductAbstractIds());

        $updatedPayloadTransfers = $this->updatePayloadTransfers(
            $productPageLoadTransfer->getPayloadTransfers(),
            $conditionalAvailability,
        );*/

        //$productPageLoadTransfer->setPayloadTransfers($updatedPayloadTransfers);

        return $productPageLoadTransfer;
    }

}
