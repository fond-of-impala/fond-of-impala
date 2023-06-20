<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriod;
use Propel\Runtime\Collection\ObjectCollection;

class ConditionalAvailabilityPeriodMapper implements ConditionalAvailabilityPeriodMapperInterface
{
    /**
     * @inheritDoc
     */
    public function mapTransferToEntity(
        ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer,
        FoiConditionalAvailabilityPeriod $foiConditionalAvailabilityPeriod
    ): FoiConditionalAvailabilityPeriod {
        $foiConditionalAvailabilityPeriod->fromArray(
            $conditionalAvailabilityPeriodTransfer->modifiedToArray(false),
        );

        return $foiConditionalAvailabilityPeriod;
    }

    /**
     * @inheritDoc
     */
    public function mapEntityToTransfer(
        FoiConditionalAvailabilityPeriod $foiConditionalAvailabilityPeriod,
        ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
    ): ConditionalAvailabilityPeriodTransfer {
        return $conditionalAvailabilityPeriodTransfer->fromArray(
            $foiConditionalAvailabilityPeriod->toArray(),
            true,
        );
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $foiConditionalAvailabilityPeriods
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer
     */
    public function mapEntityCollectionToTransferCollection(
        ObjectCollection $foiConditionalAvailabilityPeriods,
        ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
    ): ConditionalAvailabilityPeriodCollectionTransfer {
        foreach ($foiConditionalAvailabilityPeriods as $foiConditionalAvailabilityPeriod) {
            $conditionalAvailabilityPeriodTransfer = $this->mapEntityToTransfer(
                $foiConditionalAvailabilityPeriod,
                new ConditionalAvailabilityPeriodTransfer(),
            );

            $conditionalAvailabilityPeriodCollectionTransfer->addConditionalAvailabilityPeriod(
                $conditionalAvailabilityPeriodTransfer,
            );
        }

        return $conditionalAvailabilityPeriodCollectionTransfer;
    }
}
