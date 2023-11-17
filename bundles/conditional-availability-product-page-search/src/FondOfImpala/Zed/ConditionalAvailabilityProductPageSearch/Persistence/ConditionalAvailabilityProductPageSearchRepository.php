<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence;

use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityPeriodTableMap;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchPersistenceFactory getFactory()
 */
class ConditionalAvailabilityProductPageSearchRepository extends AbstractRepository implements ConditionalAvailabilityProductPageSearchRepositoryInterface
{
    /**
     * @return array<int>
     */
    public function findConcreteProductIdsToTrigger(): array
    {
        /** @var \Propel\Runtime\Collection\ArrayCollection $collection */
        $collection = $this->getFactory()
            ->createFoiConditionalAvailabilityQuery()
            ->select(FoiConditionalAvailabilityTableMap::COL_FK_PRODUCT)
            ->innerJoinSpyProduct()
            ->innerJoinFoiConditionalAvailabilityPeriod()
            ->useFoiConditionalAvailabilityPeriodQuery()
                    ->filterByStartAt(date('Y-m-d 00:00:00'), Criteria::GREATER_EQUAL)
                    ->filterByStartAt(date('Y-m-d 23:59:59'), Criteria::LESS_EQUAL)
                    ->filterByCreatedAt(date('Y-m-d 00:00:00'), Criteria::LESS_THAN)
            ->endUse()
            ->orderBy(SpyProductTableMap::COL_SKU)
            ->orderBy(FoiConditionalAvailabilityPeriodTableMap::COL_QUANTITY)
            ->orderByChannel()
            ->find();

        return $collection->toArray();
    }
}
