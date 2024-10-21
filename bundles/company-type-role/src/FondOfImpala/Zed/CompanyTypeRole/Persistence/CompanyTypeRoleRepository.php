<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\Base\SpyCompanyRoleQuery;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Orm\Zed\Permission\Persistence\Map\SpyPermissionTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\Propel\PropelConfig;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRolePersistenceFactory getFactory()
 */
class CompanyTypeRoleRepository extends AbstractRepository implements CompanyTypeRoleRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @return array<int>
     */
    public function findActiveCompanyUserIdsByIdCustomer(int $idCustomer): array
    {
        // @phpstan-ignore-next-line
        return $this->getFactory()->getCompanyUserQuery()
            ->clear()
            ->filterByIsActive(true)
            ->filterByFkCustomer($idCustomer)
            ->select([SpyCompanyUserTableMap::COL_ID_COMPANY_USER])
            ->find()
            ->toArray();
    }

    /**
     * @param string $companyTypeName
     * @param string $companyRoleName
     * @param array<string> $permissionKeys
     *
     * @return array<int>
     */
    public function findSyncableCompanyRoleIds(
        string $companyTypeName,
        string $companyRoleName,
        array $permissionKeys
    ): array {
        sort($permissionKeys);

        $havingClause = sprintf(
            "string_agg(%s, ',' ORDER BY %s) != ?",
            SpyPermissionTableMap::COL_KEY,
            SpyPermissionTableMap::COL_KEY,
        );

        if ($this->getFactory()->getPropelFacade()->getCurrentDatabaseEngine() !== PropelConfig::DB_ENGINE_PGSQL) {
            $havingClause = sprintf(
                'GROUP_CONCAT(%s ORDER BY %s) != ?',
                SpyPermissionTableMap::COL_KEY,
                SpyPermissionTableMap::COL_KEY,
            );
        }

        // @phpstan-ignore-next-line
        return SpyCompanyRoleQuery::create()
            ->useSpyCompanyRoleToPermissionQuery()
                ->innerJoinPermission()
            ->endUse()
            ->useCompanyQuery()
                ->useFoiCompanyTypeQuery()
                    ->filterByName($companyTypeName)
                ->endUse()
            ->endUse()
            ->filterByName($companyRoleName)
            ->orderBy(SpyCompanyRoleTableMap::COL_ID_COMPANY_ROLE)
            ->select([SpyCompanyRoleTableMap::COL_ID_COMPANY_ROLE])
            ->groupByIdCompanyRole()
            ->having($havingClause, implode(',', $permissionKeys))
            ->find()
            ->toArray();
    }

    /**
     * @param array<int> $companyRoleIds
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function findCompanyRolesByCompanyRoleIds(
        array $companyRoleIds
    ): CompanyRoleCollectionTransfer {
        $spyCompanyRoles = SpyCompanyRoleQuery::create()
            ->filterByIdCompanyRole_In($companyRoleIds)
            ->find();

        $companyRoleCollectionTransfer = new CompanyRoleCollectionTransfer();

        foreach ($spyCompanyRoles as $spyCompanyRole) {
            $companyRoleTransfer = $this->getFactory()
                ->createCompanyRoleMapper()
                ->fromSpyCompanyRole($spyCompanyRole);

            $companyTransfer = $this->getFactory()
                ->createCompanyMapper()
                ->fromSpyCompanyRole($spyCompanyRole);

            $permissionCollectionTransfer = $this->getFactory()
                ->createPermissionMapper()
                ->fromSpyCompanyRole($spyCompanyRole);

            $companyRoleTransfer->setPermissionCollection($permissionCollectionTransfer)
                ->setCompany($companyTransfer);

            $companyRoleCollectionTransfer->addRole($companyRoleTransfer);
        }

        return $companyRoleCollectionTransfer;
    }

    /**
     * @param int $companyRoleId
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUserIdsByCompanyRoleId(
        int $companyRoleId
    ): CompanyUserCollectionTransfer {
        $spyCompanyUsers = SpyCompanyUserQuery::create()
            ->useSpyCompanyRoleToCompanyUserQuery()
                ->filterByFkCompanyRole($companyRoleId)
            ->endUse()
            ->find();

        $collection = new CompanyUserCollectionTransfer();

        foreach ($spyCompanyUsers as $spyCompanyUser) {
            $collection->addCompanyUser((new CompanyUserTransfer())->fromArray($spyCompanyUser->toArray(), true));
        }

        return $collection;
    }

    /**
     * @return int
     */
    public function getCompanyCount(): int
    {
        return $this->getFactory()->getCompanyQuery()->select(SpyCompanyTableMap::COL_ID_COMPANY)->count();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function getCompanyCollection(
        CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer
    ): CompanyCollectionTransfer {
        $companyQuery = $this->getFactory()
            ->getCompanyQuery();

        $companyQuery = $this->setCompanyFilters(
            $companyQuery,
            $companyCriteriaFilterTransfer,
        );

        return $this->getFactory()
            ->createCompanyMapper()
            ->mapCompanyEntityCollectionToCompanyCollectionTransfer($companyQuery->find());
    }

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompanyQuery $companyQuery
     * @param \Generated\Shared\Transfer\CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected function setCompanyFilters(
        SpyCompanyQuery $companyQuery,
        CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer
    ): SpyCompanyQuery {
        if ($companyCriteriaFilterTransfer->getIdCompany()) {
            $companyQuery->filterByIdCompany($companyCriteriaFilterTransfer->getIdCompany());
        }

        if ($companyCriteriaFilterTransfer->getName()) {
            $companyQuery->filterByName(sprintf('%%%s%%', $companyCriteriaFilterTransfer->getName()), Criteria::LIKE);
            $companyQuery->setIgnoreCase(true);
        }

        if (
            $companyCriteriaFilterTransfer->getFilter()
            && $companyCriteriaFilterTransfer->getFilter()->getLimit()
        ) {
            $companyQuery->limit($companyCriteriaFilterTransfer->getFilter()->getLimit());
        }

        if (
            $companyCriteriaFilterTransfer->getFilter()
            && $companyCriteriaFilterTransfer->getFilter()->getOffset()
        ) {
            $companyQuery->offset($companyCriteriaFilterTransfer->getFilter()->getOffset());
        }

        return $companyQuery;
    }
}
