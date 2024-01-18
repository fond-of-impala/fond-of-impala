<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailability;
use Propel\Runtime\Collection\ObjectCollection;

class ConditionalAvailabilityMapper implements ConditionalAvailabilityMapperInterface
{
    /**
     * @var string
     */
    public const VIRTUAL_COLUMN_SKU = 'sku';

    protected ConditionalAvailabilityPeriodMapperInterface $conditionalAvailabilityPeriodMapper;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodMapperInterface $conditionalAvailabilityPeriodMapper
     */
    public function __construct(ConditionalAvailabilityPeriodMapperInterface $conditionalAvailabilityPeriodMapper)
    {
        $this->conditionalAvailabilityPeriodMapper = $conditionalAvailabilityPeriodMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     * @param \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailability $foiConditionalAvailability
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailability
     */
    public function mapTransferToEntity(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer,
        FoiConditionalAvailability $foiConditionalAvailability
    ): FoiConditionalAvailability {
        $foiConditionalAvailability->fromArray(
            $conditionalAvailabilityTransfer->modifiedToArray(false),
        );

        return $foiConditionalAvailability;
    }

    /**
     * @param \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailability $foiConditionalAvailability
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    public function mapEntityToTransfer(
        FoiConditionalAvailability $foiConditionalAvailability,
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityTransfer {
        $conditionalAvailabilityTransfer->fromArray(
            $foiConditionalAvailability->toArray(),
            true,
        );

        $foiConditionalAvailabilityPeriods = $this->conditionalAvailabilityPeriodMapper
            ->mapEntityCollectionToTransferCollection(
                $foiConditionalAvailability->getFoiConditionalAvailabilityPeriods(),
                new ConditionalAvailabilityPeriodCollectionTransfer(),
            );

        $conditionalAvailabilityTransfer->setConditionalAvailabilityPeriodCollection(
            $foiConditionalAvailabilityPeriods,
        );

        return $conditionalAvailabilityTransfer;
    }

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
    ): ArrayObject {
        foreach ($foiConditionalAvailabilities as $foiConditionalAvailability) {
            $virtualColumn = (string)$foiConditionalAvailability->getVirtualColumn($groupByVirtualColumn);

            if (!$groupedConditionalAvailabilityTransfers->offsetExists($virtualColumn)) {
                $groupedConditionalAvailabilityTransfers->offsetSet($virtualColumn, new ArrayObject());
            }

            $conditionalAvailabilityTransfer = $this->mapEntityToTransfer(
                $foiConditionalAvailability,
                new ConditionalAvailabilityTransfer(),
            );

            $groupedConditionalAvailabilityTransfers->offsetGet($virtualColumn)
                ->append($conditionalAvailabilityTransfer);
        }

        return $groupedConditionalAvailabilityTransfers;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $foiConditionalAvailabilities
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function mapEntityCollectionToTransferCollection(
        ObjectCollection $foiConditionalAvailabilities,
        ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransfer
    ): ConditionalAvailabilityCollectionTransfer {
        foreach ($foiConditionalAvailabilities as $foiConditionalAvailability) {
            $conditionalAvailabilityTransfer = $this->mapEntityToTransfer(
                $foiConditionalAvailability,
                new ConditionalAvailabilityTransfer(),
            );

            $conditionalAvailabilityCollectionTransfer->addConditionalAvailability($conditionalAvailabilityTransfer);
        }

        return $conditionalAvailabilityCollectionTransfer;
    }
}
