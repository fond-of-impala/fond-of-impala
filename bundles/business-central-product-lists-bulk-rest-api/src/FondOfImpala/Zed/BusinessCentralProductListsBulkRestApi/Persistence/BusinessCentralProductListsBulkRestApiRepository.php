<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence;

use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Communication\Plugin\PermissionExtension\CanBulkAssignCompaniesToProductListsPermissionPlugin;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
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
            ->clear()
            ->useCompanyUserQuery()
                ->filterByIsActive(true)
                ->useCustomerQuery()
                    ->filterByCustomerReference($customerReference)
                ->endUse()
                ->useSpyCompanyRoleToCompanyUserQuery()
                    ->useCompanyRoleQuery()
                        ->useSpyCompanyRoleToPermissionQuery()
                            ->usePermissionQuery()
                                ->filterByKey(CanBulkAssignCompaniesToProductListsPermissionPlugin::KEY)
                            ->endUse()
                        ->endUse()
                    ->endUse()
                ->endUse()
            ->endUse()
            ->filterByDebtorNumber_In($debtorNumbers)
            ->select([SpyCompanyTableMap::COL_ID_COMPANY, SpyCompanyTableMap::COL_DEBTOR_NUMBER])
            ->find();

        return $collection->toKeyValue(
            SpyCompanyTableMap::COL_DEBTOR_NUMBER,
            SpyCompanyTableMap::COL_ID_COMPANY,
        );
    }
}
