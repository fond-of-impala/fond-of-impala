<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence;

use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence\BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\CompanyBusinessUnit\Persistence\Map\SpyCompanyBusinessUnitTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
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
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCompanyQuery()
            ->useCompanyBusinessUnitQuery()
                ->filterByFkOrderBudget(null, Criteria::ISNOTNULL)
            ->endUse()
            ->useCompanyUserQuery()
                ->useCustomerQuery()
                    ->filterByCustomerReference($customerReference)
                ->endUse()
            ->endUse()
            ->clear()
            ->filterByDebtorNumber_In($debtorNumbers)
            ->select([SpyCompanyBusinessUnitTableMap::COL_FK_ORDER_BUDGET, SpyCompanyTableMap::COL_DEBTOR_NUMBER])
            ->find();

        return $collection->toKeyValue(
            SpyCompanyTableMap::COL_DEBTOR_NUMBER,
            SpyCompanyBusinessUnitTableMap::COL_FK_ORDER_BUDGET,
        );
    }
}
