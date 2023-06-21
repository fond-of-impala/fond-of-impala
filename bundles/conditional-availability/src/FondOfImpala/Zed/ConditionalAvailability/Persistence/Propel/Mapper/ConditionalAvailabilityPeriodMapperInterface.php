<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriod;
use Propel\Runtime\Collection\ObjectCollection;

interface ConditionalAvailabilityPeriodMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
     * @param \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriod $foiConditionalAvailabilityPeriod
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriod
     */
    public function mapTransferToEntity(
        ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer,
        FoiConditionalAvailabilityPeriod $foiConditionalAvailabilityPeriod
    ): FoiConditionalAvailabilityPeriod;

    /**
     * @param \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriod $foiConditionalAvailabilityPeriod
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer
     */
    public function mapEntityToTransfer(
        FoiConditionalAvailabilityPeriod $foiConditionalAvailabilityPeriod,
        ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
    ): ConditionalAvailabilityPeriodTransfer;

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $foiConditionalAvailabilityPeriods
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer
     */
    public function mapEntityCollectionToTransferCollection(
        ObjectCollection $foiConditionalAvailabilityPeriods,
        ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
    ): ConditionalAvailabilityPeriodCollectionTransfer;
}
