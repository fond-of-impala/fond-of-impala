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
  * @param array<string> $uuids
  *
  * @return array<string, int>
  */
    public function getCompanyIdsByUuids(array $uuids): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCompanyQuery()
            ->clear()
            ->filterByUuid_In($uuids)
            ->select([SpyCompanyTableMap::COL_ID_COMPANY, SpyCompanyTableMap::COL_UUID])
            ->find();

        return $collection->toKeyValue(
            SpyCompanyTableMap::COL_UUID,
            SpyCompanyTableMap::COL_ID_COMPANY,
        );
    }

    /**
     * @param array<string> $debtorNumbers
     *
     * @return array<string, int>
     */
    public function getCompanyIdsByDebtorNumbers(array $debtorNumbers): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCompanyQuery()
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
