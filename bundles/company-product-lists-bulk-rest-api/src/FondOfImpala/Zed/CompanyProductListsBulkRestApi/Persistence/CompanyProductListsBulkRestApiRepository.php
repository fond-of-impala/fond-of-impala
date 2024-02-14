<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence;

use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence\CompanyProductListsBulkRestApiPersistenceFactory getFactory()
 */
class CompanyProductListsBulkRestApiRepository extends AbstractRepository implements CompanyProductListsBulkRestApiRepositoryInterface
{
 /**
  * @param string $customerReference
  * @param array<string> $uuids
  *
  * @return array<string, int>
  */
    public function getCompanyIdsByCustomerReferenceAndUuids(
        string $customerReference,
        array $uuids
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
            ->filterByUuid_In($uuids)
            ->select([SpyCompanyTableMap::COL_ID_COMPANY, SpyCompanyTableMap::COL_UUID])
            ->find();

        return $collection->toKeyValue(
            SpyCompanyTableMap::COL_UUID,
            SpyCompanyTableMap::COL_ID_COMPANY,
        );
    }
}
