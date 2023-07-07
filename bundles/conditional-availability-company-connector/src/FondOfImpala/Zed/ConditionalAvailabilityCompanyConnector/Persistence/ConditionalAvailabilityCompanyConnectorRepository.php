<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Persistence;

use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Persistence\ConditionalAvailabilityCompanyConnectorPersistenceFactory getFactory()
 */
class ConditionalAvailabilityCompanyConnectorRepository extends AbstractRepository implements ConditionalAvailabilityCompanyConnectorRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @return array<string>
     */
    public function getPossibleAvailabilityChannelsByIdCustomer(int $idCustomer): array
    {
        /** @var \Propel\Runtime\Collection\ArrayCollection $collection */
        $collection = $this->getFactory()
            ->getCompanyQuery()
            ->clear()
            ->useCompanyUserQuery()
                ->filterByFkCustomer($idCustomer)
                ->filterByIsActive(true)
            ->endUse()
            ->filterByIsActive(true)
            ->filterByAvailabilityChannel(null, Criteria::ISNOTNULL)
            ->select([SpyCompanyTableMap::COL_AVAILABILITY_CHANNEL])
            ->groupByAvailabilityChannel()
            ->find();

        return $collection->toArray();
    }
}
