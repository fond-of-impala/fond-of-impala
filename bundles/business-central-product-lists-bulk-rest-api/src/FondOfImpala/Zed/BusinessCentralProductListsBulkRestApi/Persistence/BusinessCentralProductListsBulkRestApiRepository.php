<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence;

use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence\BusinessCentralProductListsBulkRestApiPersistenceFactory getFactory()
 */
class BusinessCentralProductListsBulkRestApiRepository extends AbstractRepository implements BusinessCentralProductListsBulkRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $debtorNumbers
     *
     * @return array<string, int>
     */
    public function getCompanyIdsByCustomerReferenceAndDebtorNumbers(
        string $customerReference,
        array $debtorNumbers
    ): array {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCompanyQuery()
            ->useCompanyUserQuery()
                ->filterByIsActive(true)
                ->useCustomerQuery()
                    ->filterByCustomerReference($customerReference)
                ->endUse()
            ->endUse()
            ->clear()
            ->filterByDebtorNumber_In($debtorNumbers)
            ->select([SpyCompanyTableMap::COL_ID_COMPANY, SpyCompanyTableMap::COL_DEBTOR_NUMBER])
            ->find();

        return $collection->toKeyValue(
            SpyCompanyTableMap::COL_DEBTOR_NUMBER,
            SpyCompanyTableMap::COL_ID_COMPANY,
        );
    }
}
