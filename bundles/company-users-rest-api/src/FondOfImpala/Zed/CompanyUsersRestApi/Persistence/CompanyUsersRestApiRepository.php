<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUsersRestApi\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiPersistenceFactory getFactory()
 */
class CompanyUsersRestApiRepository extends AbstractRepository implements CompanyUsersRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return array<\Generated\Shared\Transfer\CompanyUserTransfer>
     */
    public function findActiveCompanyUsersByCustomerReference(string $customerReference): array
    {
        /** @var array<\Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUser> $companyUsers */
        $companyUsers = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->useCustomerQuery()
                ->filterByCustomerReference($customerReference)
            ->endUse()
            ->useCompanyQuery()
                ->usePriceListQuery()
                ->endUse()
            ->endUse()
            ->useCompanyBusinessUnitQuery()
            ->endUse()
            ->useSpyCompanyRoleToCompanyUserQuery()
                ->useCompanyRoleQuery()
                ->endUse()
            ->endUse()
            ->find();

        $companyUserTransfers = [];

        foreach ($companyUsers as $companyUser) {
            $companyUserTransfer = (new CompanyUserTransfer())
                ->fromArray($companyUser->toArray(), true);

            $company = $companyUser->getCompany();

            $companyTransfer = (new CompanyTransfer())
                ->fromArray($companyUser->getCompany()->toArray(), true);

            if ($company->getPriceList() !== null) {
                $companyTransfer->setPriceList(
                    (new PriceListTransfer())
                        ->fromArray($company->getPriceList()->toArray(), true),
                );
            }

            $companyUserTransfer->setCompany($companyTransfer);

            if ($companyUser->getCompanyBusinessUnit() !== null) {
                $companyUserTransfer->setCompanyBusinessUnit(
                    (new CompanyBusinessUnitTransfer())
                        ->fromArray($companyUser->getCompanyBusinessUnit()->toArray(), true),
                );
            }

            $companyRoleTransfers = [];

            foreach ($companyUser->getSpyCompanyRoleToCompanyUsers() as $companyRoleToCompanyUsers) {
                $companyRoleTransfers[] = (new CompanyRoleTransfer())
                    ->fromArray($companyRoleToCompanyUsers->getCompanyRole()->toArray(), true);
            }

            $companyUserTransfers[] = $companyUserTransfer
                ->setCompanyRoleCollection((new CompanyRoleCollectionTransfer())->setRoles(new ArrayObject($companyRoleTransfers)));
        }

        return $companyUserTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUsersByFilter(
        CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
    ): CompanyUserCollectionTransfer {
        $queryCompanyUser = $this->getFactory()
            ->getCompanyUserPropelQuery();

        $this->applyFilters($queryCompanyUser, $companyUserCriteriaFilterTransfer);

        $companyUserCollection = $this->buildQueryFromCriteria($queryCompanyUser)->find();

        return $this->getFactory()
            ->createCompanyUserMapper()
            ->mapCompanyUserCollection($companyUserCollection);
    }

    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery $queryCompanyUser
     * @param \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer
     *
     * @return void
     */
    protected function applyFilters(SpyCompanyUserQuery $queryCompanyUser, CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer): void
    {
        if ($criteriaFilterTransfer->getIdCompany() !== null) {
            $queryCompanyUser->filterByFkCompany($criteriaFilterTransfer->getIdCompany());
        }

        if ($criteriaFilterTransfer->getIdCustomer() !== null) {
            $queryCompanyUser->filterByFkCustomer($criteriaFilterTransfer->getIdCustomer());
        }

        if ($criteriaFilterTransfer->getIdCompanyBusinessUnit() !== null) {
            $queryCompanyUser->filterByFkCompanyBusinessUnit($criteriaFilterTransfer->getIdCompanyBusinessUnit());
        }
    }

    /**
     * @param int $idCustomer
     * @param string $foreignCompanyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByIdCustomerAndForeignCompanyUserReference(
        int $idCustomer,
        string $foreignCompanyUserReference
    ): ?CompanyUserTransfer {
        $companyUser = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->clear()
            ->where(
                sprintf(
                    '%s IN (SELECT %s FROM %s WHERE %s = ?)',
                    SpyCompanyUserTableMap::COL_FK_COMPANY,
                    SpyCompanyUserTableMap::COL_FK_COMPANY,
                    SpyCompanyUserTableMap::TABLE_NAME,
                    SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE,
                ),
                $foreignCompanyUserReference,
            )->filterByFkCustomer($idCustomer)
            ->findOne();

        if ($companyUser === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyUserMapper()
            ->mapEntityToTransfer($companyUser);
    }
}
