<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Persistence;

use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\CompanyType\Persistence\Map\FoiCompanyTypeTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Persistence\CompanyTypeProductListsBulkRestApiPersistenceFactory getFactory()
 */
class CompanyTypeProductListsBulkRestApiRepository extends AbstractRepository implements CompanyTypeProductListsBulkRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $colleagueReferences
     *
     * @return array<string, int>
     */
    public function getColleagueIdsByCustomerReferenceAndColleagueReferences(
        string $customerReference,
        array $colleagueReferences
    ): array {
        $clause = sprintf(
            <<<EOD
                %s IN (
                SELECT %s FROM %s INNER JOIN %s ON %s = %s
                    INNER JOIN %s ON %s = %s
                    INNER JOIN %s ON %s = %s
                    WHERE %s = 'manufacturer' AND %s = ?
                )
            EOD,
            SpyCompanyTableMap::COL_ID_COMPANY,
            SpyCompanyTableMap::COL_ID_COMPANY,
            SpyCustomerTableMap::TABLE_NAME,
            SpyCompanyUserTableMap::TABLE_NAME,
            SpyCustomerTableMap::COL_ID_CUSTOMER,
            SpyCompanyUserTableMap::COL_FK_CUSTOMER,
            SpyCompanyTableMap::TABLE_NAME,
            SpyCompanyTableMap::COL_ID_COMPANY,
            SpyCompanyUserTableMap::COL_FK_COMPANY,
            FoiCompanyTypeTableMap::TABLE_NAME,
            FoiCompanyTypeTableMap::COL_ID_COMPANY_TYPE,
            SpyCompanyTableMap::COL_FK_COMPANY_TYPE,
            FoiCompanyTypeTableMap::COL_NAME,
            SpyCustomerTableMap::COL_CUSTOMER_REFERENCE,
        );

        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCustomerQuery()
            ->clear()
            ->useCompanyUserQuery()
                ->useCompanyQuery()
                    ->where($clause, $customerReference)
                ->endUse()
            ->endUse()
            ->filterByCustomerReference($customerReference, Criteria::NOT_EQUAL)
            ->filterByCustomerReference_In($colleagueReferences)
            ->select([SpyCustomerTableMap::COL_ID_CUSTOMER, SpyCustomerTableMap::COL_CUSTOMER_REFERENCE]);

        return $collection->toKeyValue(
            SpyCustomerTableMap::COL_CUSTOMER_REFERENCE,
            SpyCustomerTableMap::COL_ID_CUSTOMER,
        );
    }

    /**
     * @param string $customerReference
     * @param array<string> $colleagueEmails
     *
     * @return array<string, int>
     */
    public function getColleagueIdsByCustomerReferenceAndColleagueEmails(
        string $customerReference,
        array $colleagueEmails
    ): array {
        $clause = sprintf(
            <<<EOD
                %s IN (
                SELECT %s FROM %s INNER JOIN %s ON %s = %s
                    INNER JOIN %s ON %s = %s
                    INNER JOIN %s ON %s = %s
                    WHERE %s = 'manufacturer' AND %s = ?
                )
            EOD,
            SpyCompanyTableMap::COL_ID_COMPANY,
            SpyCompanyTableMap::COL_ID_COMPANY,
            SpyCustomerTableMap::TABLE_NAME,
            SpyCompanyUserTableMap::TABLE_NAME,
            SpyCustomerTableMap::COL_ID_CUSTOMER,
            SpyCompanyUserTableMap::COL_FK_CUSTOMER,
            SpyCompanyTableMap::TABLE_NAME,
            SpyCompanyTableMap::COL_ID_COMPANY,
            SpyCompanyUserTableMap::COL_FK_COMPANY,
            FoiCompanyTypeTableMap::TABLE_NAME,
            FoiCompanyTypeTableMap::COL_ID_COMPANY_TYPE,
            SpyCompanyTableMap::COL_FK_COMPANY_TYPE,
            FoiCompanyTypeTableMap::COL_NAME,
            SpyCustomerTableMap::COL_CUSTOMER_REFERENCE,
        );

        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCustomerQuery()
            ->clear()
            ->useCompanyUserQuery()
                ->useCompanyQuery()
                    ->where($clause, $customerReference)
                ->endUse()
            ->endUse()
            ->filterByCustomerReference($customerReference, Criteria::NOT_EQUAL)
            ->filterByEmail_In($colleagueEmails)
            ->select([SpyCustomerTableMap::COL_ID_CUSTOMER, SpyCustomerTableMap::COL_EMAIL]);

        return $collection->toKeyValue(
            SpyCustomerTableMap::COL_EMAIL,
            SpyCustomerTableMap::COL_ID_CUSTOMER,
        );
    }
}
