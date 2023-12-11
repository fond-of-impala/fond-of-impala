<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence;

use DateInterval;
use DateTime;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityTableMap;
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
    public function findProductConcreteIdsToTrigger(): array
    {
        /** @var \Propel\Runtime\Collection\ArrayCollection $collection */
        $collection = $this->getFactory()
            ->createFoiConditionalAvailabilityQuery()
            ->select(FoiConditionalAvailabilityTableMap::COL_FK_PRODUCT)
            ->useFoiConditionalAvailabilityPeriodQuery()
                    ->filterByStartAt(date('Y-m-d 00:00:00'), Criteria::GREATER_EQUAL)
                    ->filterByStartAt(date('Y-m-d 23:59:59'), Criteria::LESS_EQUAL)
                    ->filterByCreatedAt(date('Y-m-d 00:00:00'), Criteria::LESS_THAN)
            ->endUse()
            ->groupByFkProduct()
            ->orderByFkProduct()
            ->find();

        return $collection->toArray();
    }

    /**
     * @return array<int>
     */
    public function findProductConcreteIdsForDeltaTrigger(): array
    {
        $delta = (new DateTime())->sub(new DateInterval('PT3M'));

        /** @var \Propel\Runtime\Collection\ArrayCollection $collection */
        $collection = $this->getFactory()
            ->createFoiConditionalAvailabilityQuery()
            ->select(FoiConditionalAvailabilityTableMap::COL_FK_PRODUCT)
            ->useFoiConditionalAvailabilityPeriodQuery()
                ->filterByCreatedAt($delta, Criteria::GREATER_EQUAL)
            ->endUse()
            ->groupByFkProduct()
            ->orderByFkProduct()
            ->find();

        return $collection->toArray();
    }
}
