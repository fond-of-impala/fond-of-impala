<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityPeriodQuery;
use Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityQuery;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FosConditionalAvailabilityTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchPersistenceFactory getFactory()
 */
class ConditionalAvailabilityPageSearchQueryContainer extends AbstractQueryContainer implements ConditionalAvailabilityPageSearchQueryContainerInterface
{
    /**
     * @var string
     */
    public const VIRTUAL_COLUMN_SKU = 'sku';

    /**
     * @var string
     */
    public const VIRTUAL_COLUMN_FK_PRODUCT = 'fk_product';

    /**
     * @var string
     */
    public const VIRTUAL_COLUMN_WAREHOUSE_GROUP = 'warehouse_group';

    /**
     * @var string
     */
    public const VIRTUAL_COLUMN_IS_ACCESSIBLE = 'is_accessible';

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FosConditionalAvailabilityPeriodQuery {
        $fosConditionalAvailabilityPeriodQuery = $this->queryConditionalAvailabilityPeriodsByConditionalAvailabilityIds($conditionalAvailabilityIds);

        $fosConditionalAvailabilityPeriodQuery->useFosConditionalAvailabilityQuery()
                ->innerJoinSpyProduct()
            ->endUse()
            ->withColumn(
                SpyProductTableMap::COL_SKU,
                static::VIRTUAL_COLUMN_SKU,
            )
            ->withColumn(
                FosConditionalAvailabilityTableMap::COL_FK_PRODUCT,
                static::VIRTUAL_COLUMN_FK_PRODUCT,
            )
            ->withColumn(
                FosConditionalAvailabilityTableMap::COL_WAREHOUSE_GROUP,
                static::VIRTUAL_COLUMN_WAREHOUSE_GROUP,
            )
            ->withColumn(
                FosConditionalAvailabilityTableMap::COL_IS_ACCESSIBLE,
                static::VIRTUAL_COLUMN_IS_ACCESSIBLE,
            );

        return $fosConditionalAvailabilityPeriodQuery;
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FosConditionalAvailabilityPeriodQuery {
        $fosConditionalAvailabilityPeriodQuery = $this->getFactory()
            ->getConditionalAvailabilityPeriodPropelQuery()
            ->clear();

        if (!$conditionalAvailabilityIds) {
            return $fosConditionalAvailabilityPeriodQuery;
        }

        return $fosConditionalAvailabilityPeriodQuery->filterByFkConditionalAvailability_In(
            $conditionalAvailabilityIds,
        );
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityQuery
     */
    public function queryConditionalAvailabilitiesByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FosConditionalAvailabilityQuery {
        $fosConditionalAvailabilityQuery = $this->getFactory()->getConditionalAvailabilityPropelQuery()
            ->clear();

        if (!$conditionalAvailabilityIds) {
            return $fosConditionalAvailabilityQuery;
        }

        return $fosConditionalAvailabilityQuery->filterByIdConditionalAvailability_In(
            $conditionalAvailabilityIds,
        );
    }
}
