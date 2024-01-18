<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailability;
use Propel\Runtime\Collection\ObjectCollection;

interface ConditionalAvailabilityMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     * @param \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailability $foiConditionalAvailability
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailability
     */
    public function mapTransferToEntity(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer,
        FoiConditionalAvailability $foiConditionalAvailability
    ): FoiConditionalAvailability;

    /**
     * @param \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailability $foiConditionalAvailability
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    public function mapEntityToTransfer(
        FoiConditionalAvailability $foiConditionalAvailability,
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityTransfer;

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $foiConditionalAvailabilities
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function mapEntityCollectionToTransferCollection(
        ObjectCollection $foiConditionalAvailabilities,
        ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransfer
    ): ConditionalAvailabilityCollectionTransfer;

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $foiConditionalAvailabilities
     * @param \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilityTransfers
     * @param string $groupByVirtualColumn
     *
     * @return \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>>
     */
    public function mapEntityCollectionToGroupedTransfers(
        ObjectCollection $foiConditionalAvailabilities,
        ArrayObject $groupedConditionalAvailabilityTransfers,
        string $groupByVirtualColumn
    ): ArrayObject;
}
