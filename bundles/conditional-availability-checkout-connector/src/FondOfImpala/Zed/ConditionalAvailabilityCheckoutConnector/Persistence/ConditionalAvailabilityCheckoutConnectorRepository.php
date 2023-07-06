<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Persistence;

use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Persistence\ConditionalAvailabilityCheckoutConnectorPersistenceFactory getFactory()
 */
class ConditionalAvailabilityCheckoutConnectorRepository extends AbstractRepository implements ConditionalAvailabilityCheckoutConnectorRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return int|null
     */
    public function getIdCustomerByCustomerReference(string $customerReference): ?int
    {
        /** @var int|null $idCustomer */
        $idCustomer = $this->getFactory()
            ->getCustomerQuery()
            ->filterByCustomerReference($customerReference)
            ->select([SpyCustomerTableMap::COL_ID_CUSTOMER])
            ->findOne();

        return $idCustomer;
    }
}
