<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence;

use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\PermissionExtension\CanBulkPersistOrderBudgetsPermissionPlugin;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\CompanyBusinessUnit\Persistence\Map\SpyCompanyBusinessUnitTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence\BusinessCentralOrderBudgetsBulkRestApiPersistenceFactory getFactory()
 */
class BusinessCentralOrderBudgetsBulkRestApiRepository extends AbstractRepository implements BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $debtorNumbers
     *
     * @return array<string, int>
     */
    public function getOrderBudgetIdsByCustomerReferenceAndDebtorNumbers(
        string $customerReference,
        array $debtorNumbers
    ): array {
        $query = $this->getFactory()
            ->getCompanyQuery()
            ->clear()
            ->useCompanyBusinessUnitQuery()
                ->filterByFkOrderBudget(null, Criteria::ISNOTNULL)
            ->endUse()
            ->useCompanyUserQuery()
                ->useCustomerQuery()
                    ->filterByCustomerReference($customerReference)
                ->endUse()
                ->useSpyCompanyRoleToCompanyUserQuery()
                    ->useCompanyRoleQuery()
                        ->useSpyCompanyRoleToPermissionQuery()
                            ->usePermissionQuery()
                                ->filterByKey(CanBulkPersistOrderBudgetsPermissionPlugin::KEY)
                            ->endUse()
                        ->endUse()
                    ->endUse()
                ->endUse()
            ->endUse()
            ->filterByDebtorNumber_In($debtorNumbers)
            ->select([SpyCompanyBusinessUnitTableMap::COL_FK_ORDER_BUDGET, SpyCompanyTableMap::COL_DEBTOR_NUMBER]);

        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $query->find();

        return $collection->toKeyValue(
            SpyCompanyTableMap::COL_DEBTOR_NUMBER,
            SpyCompanyBusinessUnitTableMap::COL_FK_ORDER_BUDGET,
        );
    }
}
