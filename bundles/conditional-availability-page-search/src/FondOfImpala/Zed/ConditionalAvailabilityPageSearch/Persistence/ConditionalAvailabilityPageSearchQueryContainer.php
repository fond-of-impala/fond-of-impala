<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityQuery;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityTableMap;
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
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FoiConditionalAvailabilityPeriodQuery {
        $FoiConditionalAvailabilityPeriodQuery = $this->queryConditionalAvailabilityPeriodsByConditionalAvailabilityIds($conditionalAvailabilityIds);

        $FoiConditionalAvailabilityPeriodQuery->useFoiConditionalAvailabilityQuery()
                ->innerJoinSpyProduct()
            ->endUse()
            ->withColumn(
                SpyProductTableMap::COL_SKU,
                static::VIRTUAL_COLUMN_SKU,
            )
            ->withColumn(
                FoiConditionalAvailabilityTableMap::COL_FK_PRODUCT,
                static::VIRTUAL_COLUMN_FK_PRODUCT,
            )
            ->withColumn(
                FoiConditionalAvailabilityTableMap::COL_WAREHOUSE_GROUP,
                static::VIRTUAL_COLUMN_WAREHOUSE_GROUP,
            )
            ->withColumn(
                FoiConditionalAvailabilityTableMap::COL_IS_ACCESSIBLE,
                static::VIRTUAL_COLUMN_IS_ACCESSIBLE,
            );

        return $FoiConditionalAvailabilityPeriodQuery;
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FoiConditionalAvailabilityPeriodQuery {
        $FoiConditionalAvailabilityPeriodQuery = $this->getFactory()
            ->getConditionalAvailabilityPeriodPropelQuery()
            ->clear();

        if (!$conditionalAvailabilityIds) {
            return $FoiConditionalAvailabilityPeriodQuery;
        }

        return $FoiConditionalAvailabilityPeriodQuery->filterByFkConditionalAvailability_In(
            $conditionalAvailabilityIds,
        );
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityQuery
     */
    public function queryConditionalAvailabilitiesByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FoiConditionalAvailabilityQuery {
        $FoiConditionalAvailabilityQuery = $this->getFactory()->getConditionalAvailabilityPropelQuery()
            ->clear();

        if (!$conditionalAvailabilityIds) {
            return $FoiConditionalAvailabilityQuery;
        }

        return $FoiConditionalAvailabilityQuery->filterByIdConditionalAvailability_In(
            $conditionalAvailabilityIds,
        );
    }
}
