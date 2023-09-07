<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ProductPage;


use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;

class ProductPageDataExpander implements ProductPageDataExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
     */
    protected $productFacade;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacade;

    /**
     * @param ConditionalAvailabilitySearchToProductFacadeInterface $productFacade
     * @param ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(
        ConditionalAvailabilitySearchToProductFacadeInterface $productFacade,
        ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
    ){
        $this->productFacade = $productFacade;
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $productPageLoadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageData(ProductPageLoadTransfer $productPageLoadTransfer): ProductPageLoadTransfer
    {
        $updatedPayloadTransfers = $this->updatePayloadTransfers($productPageLoadTransfer->getPayloadTransfers());

        $productPageLoadTransfer->setPayloadTransfers($updatedPayloadTransfers);

        return $productPageLoadTransfer;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductPayloadTransfer> $payloadTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductPayloadTransfer>
     */
    protected function updatePayloadTransfers(array $payloadTransfers): array
    {
        /** @var \Generated\Shared\Transfer\ProductPayloadTransfer $payloadTransfer */
        foreach ($payloadTransfers as $payloadTransfer) {
            $stockStatuses = [];
            $stockStatus = [];
            $productConcreteTransfers = $this->productFacade->getConcreteProductsByAbstractProductId(
                $payloadTransfer->getIdProductAbstract()
            );

            /** @var \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer */
            foreach ($productConcreteTransfers as $productConcreteTransfer) {
                $conditionalAvailabilityCriteriaFilterTransfer = (new ConditionalAvailabilityCriteriaFilterTransfer())
                    ->setSkus([$productConcreteTransfer->getSku()]);

                $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityFacade
                    ->findConditionalAvailabilities($conditionalAvailabilityCriteriaFilterTransfer);

                if (!$conditionalAvailabilityCollectionTransfer) {
                    continue;
                }

                foreach ($conditionalAvailabilityCollectionTransfer->getConditionalAvailabilities() as $conditionalAvailabilityTransfer) {
                    $status = $this->getStockStatus( $conditionalAvailabilityTransfer);

                    if (!array_key_exists($conditionalAvailabilityTransfer->getChannel(), $stockStatuses)) {
                        $stockStatuses[$conditionalAvailabilityTransfer->getChannel()] = $this->getStockStatus( $conditionalAvailabilityTransfer);
                        continue;
                    }

                    if ($status === 2 &&  $stockStatuses[$conditionalAvailabilityTransfer->getChannel()] !== 2 ) {
                        $stockStatuses[$conditionalAvailabilityTransfer->getChannel()] = 2;
                        continue;
                    }

                    if ($status === 1 &&  $stockStatuses[$conditionalAvailabilityTransfer->getChannel()] == 0 ) {
                        $stockStatuses[$conditionalAvailabilityTransfer->getChannel()] = 1;
                        continue;
                    }
                }

            }

            foreach ($stockStatuses as $channel => $status) {
                $stockStatus[] =  $channel . '-' . $status;
            }

            $payloadTransfer->setStockStatus($stockStatus);
        }

        return $payloadTransfers;
    }


    /**
     * @param ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return int
     */
    protected function getStockStatus(ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer): int
    {
        $conditionalAvailabilityPeriods =
            $this->sortConditionalAvailabilityPeriodCollection(
                $conditionalAvailabilityTransfer->getConditionalAvailabilityPeriodCollection()
            );

        foreach ($conditionalAvailabilityPeriods as $timestamp => $conditionalAvailabilityPeriodTransfer) {
            /** @var \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer */
            if ($conditionalAvailabilityPeriodTransfer->getQuantity() <= 0) {
                return 1;
                continue;
            }

            if ($conditionalAvailabilityPeriodTransfer->getQuantity() > 0) {
                return 2;
                continue;
            }
        }

        return 0;
    }

    /**
     * @param Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
     *
     * @return array<string, Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>
     */
    protected function sortConditionalAvailabilityPeriodCollection(
        ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
    ): array
    {
        $conditionalAvailabilityPeriods = [];

        foreach ($conditionalAvailabilityPeriodCollectionTransfer->getConditionalAvailabilityPeriods() as $conditionalAvailabilityPeriodTransfer) {
            $conditionalAvailabilityPeriods[$conditionalAvailabilityPeriodTransfer->getStartAt()] = $conditionalAvailabilityPeriodTransfer;
        }

        ksort($conditionalAvailabilityPeriods);

        return $conditionalAvailabilityPeriods;
    }
}
