<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @codeCoverageIgnore
 *
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
    public const VIRTUAL_COLUMN_CHANNEL = 'channel';

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FoiConditionalAvailabilityPeriodQuery {
        $query = $this->queryConditionalAvailabilityPeriodsByConditionalAvailabilityIds($conditionalAvailabilityIds);

        $query->useFoiConditionalAvailabilityQuery()
            ->innerJoinSpyProduct()
            ->endUse()
            ->withColumn(
                SpyProductTableMap::COL_SKU,
                static::VIRTUAL_COLUMN_SKU,
            )->withColumn(
                FoiConditionalAvailabilityTableMap::COL_FK_PRODUCT,
                static::VIRTUAL_COLUMN_FK_PRODUCT,
            )->withColumn(
                FoiConditionalAvailabilityTableMap::COL_WAREHOUSE_GROUP,
                static::VIRTUAL_COLUMN_WAREHOUSE_GROUP,
            )->withColumn(
                FoiConditionalAvailabilityTableMap::COL_CHANNEL,
                static::VIRTUAL_COLUMN_CHANNEL,
            );

        return $query;
    }

    /**
     * @param array<string> $keys
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByKeys(
        array $keys
    ): FoiConditionalAvailabilityPeriodQuery {
        $query = $this->queryConditionalAvailabilityPeriodsByKeys($keys);

        $query->useFoiConditionalAvailabilityQuery()
            ->innerJoinSpyProduct()
            ->endUse()
            ->withColumn(
                SpyProductTableMap::COL_SKU,
                static::VIRTUAL_COLUMN_SKU,
            )->withColumn(
                FoiConditionalAvailabilityTableMap::COL_FK_PRODUCT,
                static::VIRTUAL_COLUMN_FK_PRODUCT,
            )->withColumn(
                FoiConditionalAvailabilityTableMap::COL_WAREHOUSE_GROUP,
                static::VIRTUAL_COLUMN_WAREHOUSE_GROUP,
            )->withColumn(
                FoiConditionalAvailabilityTableMap::COL_CHANNEL,
                static::VIRTUAL_COLUMN_CHANNEL,
            );

        return $query;
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FoiConditionalAvailabilityPeriodQuery {
        $query = $this->getFactory()
            ->getConditionalAvailabilityPeriodPropelQuery()
            ->clear();

        if (!$conditionalAvailabilityIds) {
            return $query;
        }

        return $query->filterByFkConditionalAvailability_In(
            $conditionalAvailabilityIds,
        );
    }

    /**
     * @param array<string> $keys
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsByKeys(
        array $keys
    ): FoiConditionalAvailabilityPeriodQuery {
        $query = $this->getFactory()
            ->getConditionalAvailabilityPeriodPropelQuery()
            ->clear();

        if (!count($keys)) {
            return $query;
        }

        return $query->filterByKey_In($keys);
    }
}
