<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence;

use DateInterval;
use DateTime;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchPersistenceFactory getFactory()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConfig getConfig()
 */
class ConditionalAvailabilityProductPageSearchRepository extends AbstractRepository implements ConditionalAvailabilityProductPageSearchRepositoryInterface
{
    /**
     * @return array<int>
     */
    public function findProductAbstractIdsToTrigger(): array
    {
        /** @var \Propel\Runtime\Collection\ArrayCollection $collection */
        $collection = $this->getFactory()
            ->createFoiConditionalAvailabilityQuery()
            ->useFoiConditionalAvailabilityPeriodQuery()
                    ->filterByStartAt(date('Y-m-d 00:00:00'), Criteria::GREATER_EQUAL)
                    ->filterByStartAt(date('Y-m-d 23:59:59'), Criteria::LESS_EQUAL)
                    ->filterByCreatedAt(date('Y-m-d 00:00:00'), Criteria::LESS_THAN)
            ->endUse()
            ->useSpyProductQuery()
                ->select(SpyProductTableMap::COL_FK_PRODUCT_ABSTRACT)
                ->orderByFkProductAbstract()
                ->groupByFkProductAbstract()
            ->endUse()
            ->find();

        return $collection->toArray();
    }

    /**
     * @return array<int>
     */
    public function findProductAbstractIdsForDeltaTrigger(): array
    {
        $duration = $this->getFactory()
            ->getConfig()
            ->getDuration();

        $delta = (new DateTime())->sub(new DateInterval($duration));

        /** @var \Propel\Runtime\Collection\ArrayCollection $collection */
        $collection = $this->getFactory()
            ->createFoiConditionalAvailabilityQuery()
            ->useFoiConditionalAvailabilityPeriodQuery()
                ->filterByCreatedAt($delta, Criteria::GREATER_EQUAL)
            ->endUse()
            ->useSpyProductQuery()
                ->select(SpyProductTableMap::COL_FK_PRODUCT_ABSTRACT)
                ->orderByFkProductAbstract()
                ->groupByFkProductAbstract()
            ->endUse()
            ->find();

        return $collection->toArray();
    }
}
