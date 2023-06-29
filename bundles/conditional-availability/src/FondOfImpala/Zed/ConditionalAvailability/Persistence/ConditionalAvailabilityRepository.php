<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityQuery;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityPeriodTableMap;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityPersistenceFactory getFactory()
 */
class ConditionalAvailabilityRepository extends AbstractRepository implements ConditionalAvailabilityRepositoryInterface
{
    /**
     * @var string
     */
    public const VIRTUAL_COLUMN_SKU = 'sku';

    /**
     * @var string
     */
    protected const RELATION_ALIAS_FOI_CONDITIONAL_AVAILABILITY_PERIOD = 'FoiConditionalAvailabilityPeriod';

    /**
     * @param int $idConditionalAvailability
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer|null
     */
    public function findConditionalAvailabilityById(int $idConditionalAvailability): ?ConditionalAvailabilityTransfer
    {
        $foiConditionalAvailability = $this->getFactory()
            ->createConditionalAvailabilityQuery()
            ->useFoiConditionalAvailabilityPeriodQuery()
                ->addAscendingOrderByColumn(FoiConditionalAvailabilityPeriodTableMap::COL_START_AT)
            ->endUse()
            ->with(static::RELATION_ALIAS_FOI_CONDITIONAL_AVAILABILITY_PERIOD)
            ->filterByIdConditionalAvailability($idConditionalAvailability)
            ->findOne();

        if (!$foiConditionalAvailability) {
            return null;
        }

        return $this->getFactory()
            ->createConditionalAvailabilityMapper()
            ->mapEntityToTransfer($foiConditionalAvailability, new ConditionalAvailabilityTransfer());
    }

    /**
     * @param int $fkConditionalAvailability
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer
     */
    public function findConditionalAvailabilityPeriodsByFkConditionalAvailability(
        int $fkConditionalAvailability
    ): ConditionalAvailabilityPeriodCollectionTransfer {
        $foiConditionalAvailabilityPeriods = $this->getFactory()
            ->createConditionalAvailabilityPeriodQuery()
            ->filterByFkConditionalAvailability($fkConditionalAvailability)
            ->addAscendingOrderByColumn(FoiConditionalAvailabilityPeriodTableMap::COL_START_AT)
            ->find();

        $conditionalAvailabilityPeriodCollectionTransfer = new ConditionalAvailabilityPeriodCollectionTransfer();

        foreach ($foiConditionalAvailabilityPeriods as $foiConditionalAvailabilityPeriod) {
            $conditionalAvailabilityPeriodTransfer = $this->getFactory()
                ->createConditionalAvailabilityPeriodMapper()
                ->mapEntityToTransfer($foiConditionalAvailabilityPeriod, new ConditionalAvailabilityPeriodTransfer());

            $conditionalAvailabilityPeriodCollectionTransfer
                ->addConditionalAvailabilityPeriod($conditionalAvailabilityPeriodTransfer);
        }

        return $conditionalAvailabilityPeriodCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function findConditionalAvailabilities(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ConditionalAvailabilityCollectionTransfer {
        $foiConditionalAvailabilityQuery = $this->getFactory()
            ->createConditionalAvailabilityQuery();

        $foiConditionalAvailabilityQuery = $this->applyFilters(
            $foiConditionalAvailabilityQuery,
            $conditionalAvailabilityCriteriaFilterTransfer,
        );

        /** @var \Propel\Runtime\Collection\ObjectCollection $foiConditionalAvailabilityCollection */
        $foiConditionalAvailabilityCollection = $foiConditionalAvailabilityQuery->find();

        return $this->getFactory()
            ->createConditionalAvailabilityMapper()
            ->mapEntityCollectionToTransferCollection(
                $foiConditionalAvailabilityCollection,
                new ConditionalAvailabilityCollectionTransfer(),
            );
    }

    /**
     * @param \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityQuery $foiConditionalAvailabilityQuery
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityQuery
     */
    protected function applyFilters(
        FoiConditionalAvailabilityQuery $foiConditionalAvailabilityQuery,
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): FoiConditionalAvailabilityQuery {
        $skus = $conditionalAvailabilityCriteriaFilterTransfer->getSkus();

        if (count($skus) !== 0) {
            $foiConditionalAvailabilityQuery->useSpyProductQuery()
                ->filterBySku_In($conditionalAvailabilityCriteriaFilterTransfer->getSkus())
                ->endUse();
        } else {
            $foiConditionalAvailabilityQuery->innerJoinWithSpyProduct();
        }

        if ($conditionalAvailabilityCriteriaFilterTransfer->getWarehouseGroup() !== null) {
            $foiConditionalAvailabilityQuery->filterByWarehouseGroup(
                $conditionalAvailabilityCriteriaFilterTransfer->getWarehouseGroup(),
            );
        }

        if ($conditionalAvailabilityCriteriaFilterTransfer->getChannel() !== null) {
            $foiConditionalAvailabilityQuery->filterByChannel(
                $conditionalAvailabilityCriteriaFilterTransfer->getChannel(),
            );
        }

        if ($conditionalAvailabilityCriteriaFilterTransfer->getMinimumQuantity() !== null) {
            $foiConditionalAvailabilityQuery->useFoiConditionalAvailabilityPeriodQuery()
                ->filterByQuantity(
                    $conditionalAvailabilityCriteriaFilterTransfer->getMinimumQuantity(),
                    Criteria::GREATER_EQUAL,
                )->addAscendingOrderByColumn(FoiConditionalAvailabilityPeriodTableMap::COL_START_AT)
                ->endUse();
        } else {
            $foiConditionalAvailabilityQuery->useFoiConditionalAvailabilityPeriodQuery()
                ->addAscendingOrderByColumn(FoiConditionalAvailabilityPeriodTableMap::COL_START_AT)
                ->endUse();
        }

        $foiConditionalAvailabilityQuery->with(static::RELATION_ALIAS_FOI_CONDITIONAL_AVAILABILITY_PERIOD);

        return $foiConditionalAvailabilityQuery;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>>
     */
    public function findGroupedConditionalAvailabilities(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ArrayObject {
        $foiConditionalAvailabilityQuery = $this->getFactory()
            ->createConditionalAvailabilityQuery();

        $foiConditionalAvailabilityQuery = $this->applyFilters(
            $foiConditionalAvailabilityQuery,
            $conditionalAvailabilityCriteriaFilterTransfer,
        );

        $foiConditionalAvailabilityQuery = $foiConditionalAvailabilityQuery->withColumn(
            SpyProductTableMap::COL_SKU,
            static::VIRTUAL_COLUMN_SKU,
        );

        /** @var \Propel\Runtime\Collection\ObjectCollection $foiConditionalAvailabilityCollection */
        $foiConditionalAvailabilityCollection = $foiConditionalAvailabilityQuery->find();

        return $this->getFactory()
            ->createConditionalAvailabilityMapper()
            ->mapEntityCollectionToGroupedTransfers($foiConditionalAvailabilityCollection, new ArrayObject());
    }

    /**
     * @param array<int> $productConcreteIds
     *
     * @return array<int>
     */
    public function getConditionalAvailabilityIdsByProductConcreteIds(array $productConcreteIds): array
    {
        $foiConditionalAvailabilityQuery = $this->getFactory()
            ->createConditionalAvailabilityQuery();

        $columnsToSelect = [FoiConditionalAvailabilityTableMap::COL_ID_CONDITIONAL_AVAILABILITY];

        /** @var \Propel\Runtime\Collection\ArrayCollection $foiConditionalAvailabilityCollection */
        $foiConditionalAvailabilityCollection = $foiConditionalAvailabilityQuery->select($columnsToSelect)
            ->filterByFkProduct_In($productConcreteIds)
            ->distinct()
            ->find();

        return $foiConditionalAvailabilityCollection->toArray();
    }
}
