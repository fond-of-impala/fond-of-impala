<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\CompanyBusinessUnit\Persistence\Map\SpyCompanyBusinessUnitTableMap;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;
use Orm\Zed\CompanyType\Persistence\Map\FoiCompanyTypeTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerPersistenceFactory getFactory()
 */
class CompanyUserCompanyAssignerRepository extends AbstractRepository implements CompanyUserCompanyAssignerRepositoryInterface
{
    /**
     * @var string
     */
    protected const INDEX_ID_COMPANY_USER = 'id_company_user';

    /**
     * @var string
     */
    protected const INDEX_ID_COMPANY = 'id_company';

    /**
     * @var string
     */
    protected const INDEX_COMPANY_ROLES = 'company_roles';

    /**
     * @param int $idCompany
     * @param string $companyRoleName
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
     */
    public function findCompanyRoleTransferByIdCompanyAndCompanyRoleName(int $idCompany, string $companyRoleName): ?CompanyRoleTransfer
    {
        $companyRoleEntity = $this->getFactory()
            ->getCompanyRoleQuery()
            ->clear()
            ->filterByFkCompany($idCompany)
            ->_and()
            ->filterByName($companyRoleName)
            ->findOne();

        if ($companyRoleEntity === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyRoleMapper()
            ->mapEntityToTransfer($companyRoleEntity, new CompanyRoleTransfer());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByIdCompanyAndIdCustomer(
        CompanyTransfer $companyTransfer,
        CustomerTransfer $customerTransfer
    ): ?CompanyUserTransfer {
        $companyTransfer->requireIdCompany();
        $customerTransfer->requireIdCustomer();

        $companyUserEntity = $this->getFactory()
            ->getCompanyUserQuery()
            ->clear()
            ->filterByFkCompany($companyTransfer->getIdCompany())
            ->filterByFkCustomer($customerTransfer->getIdCustomer())
            ->findOne();

        if ($companyUserEntity === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyUserMapper()
            ->mapEntityToTransfer($companyUserEntity, new CompanyUserTransfer());
    }

    /**
     * @param int $idCompanyUser
     *
     * @return string|null
     */
    public function findCompanyTypeNameByIdCompanyUser(int $idCompanyUser): ?string
    {
        return $this->getFactory()
            ->getCompanyTypeQuery()
            ->clear()
            ->useSpyCompanyQuery()
                ->useCompanyUserQuery()
                    ->filterByIdCompanyUser($idCompanyUser)
                ->endUse()
            ->endUse()
            ->select([FoiCompanyTypeTableMap::COL_NAME])
            ->findOne();
    }

    /**
     * @param int $idCompany
     *
     * @return string|null
     */
    public function findCompanyTypeNameByIdCompany(int $idCompany): ?string
    {
        return $this->getFactory()
            ->getCompanyTypeQuery()
            ->clear()
            ->useSpyCompanyQuery()
                ->filterByIdCompany($idCompany)
            ->endUse()
            ->select([FoiCompanyTypeTableMap::COL_NAME])
            ->findOne();
    }

    /**
     * @param string $companyTypeNameForManufacturer
     * @param string $companyRoleName
     *
     * @return array<int, array<string, int>>
     */
    public function findNonManufacturerData(
        string $companyTypeNameForManufacturer,
        string $companyRoleName
    ): array {
        /** @var \Propel\Runtime\Collection\ArrayCollection $companyCollection */
        $companyCollection = $this->getFactory()
            ->getCompanyQuery()
            ->clear()
            ->useFoiCompanyTypeQuery()
                ->filterByName($companyTypeNameForManufacturer, Criteria::NOT_EQUAL)
            ->endUse()
            ->useCompanyRoleQuery()
                ->filterByName($companyRoleName)
                ->withColumn(SpyCompanyRoleTableMap::COL_ID_COMPANY_ROLE, 'id_company_role')
            ->endUse()
            ->useCompanyBusinessUnitQuery()
                ->withColumn(SpyCompanyBusinessUnitTableMap::COL_ID_COMPANY_BUSINESS_UNIT, 'id_company_business_unit')
            ->endUse()
            ->withColumn(SpyCompanyTableMap::COL_ID_COMPANY, 'id_company')
            ->select(
                [
                    'id_company',
                    'id_company_business_unit',
                    'id_company_role',
                ],
            )->find();

            return $companyCollection->toArray();
    }

    /**
     * @param int $idCompanyRole
     *
     * @return string|null
     */
    public function findCompanyRoleNameByIdCompanyRole(int $idCompanyRole): ?string
    {
        return $this->getFactory()
            ->getCompanyRoleQuery()
            ->clear()
            ->filterByIdCompanyRole($idCompanyRole)
            ->select([SpyCompanyRoleTableMap::COL_NAME])
            ->findOne();
    }

    /**
     * @param int $idCustomer
     * @param int $idCompanyType
     *
     * @return array<int, int>
     */
    public function findCompanyIdsByIdCustomerAndIdCompanyType(
        int $idCustomer,
        int $idCompanyType
    ): array {
        /** @var \Propel\Runtime\Collection\ArrayCollection $spyCompanyUserCollection */
        $spyCompanyUserCollection = $this->getFactory()
            ->getCompanyUserQuery()
            ->joinWithCompany()
            ->useCompanyQuery()
                ->filterByFkCompanyType($idCompanyType)
            ->endUse()
            ->filterByFkCustomer($idCustomer)
            ->select(SpyCompanyUserTableMap::COL_FK_COMPANY)
            ->find();

        return $spyCompanyUserCollection->toArray();
    }

    /**
     * @param int $idCustomer
     * @param string $companyRoleName
     * @param array<int> $companyIds
     *
     * @return array<int, array<string, mixed>>
     */
    public function findNonManufacturerUsersWithInconsistentCompanyRoles(
        int $idCustomer,
        string $companyRoleName,
        array $companyIds
    ): array {
        /** @var \Propel\Runtime\Collection\ArrayCollection $companyUserCollection */
        $companyUserCollection = $this->getFactory()
            ->getCompanyUserQuery()
            ->leftJoinWithSpyCompanyRoleToCompanyUser()
                ->useSpyCompanyRoleToCompanyUserQuery()
                    ->leftJoinWithCompanyRole()
                        ->useCompanyRoleQuery()
                            ->filterByName($companyRoleName, Criteria::NOT_EQUAL)
                        ->endUse()
                ->endUse()
            ->filterByFkCustomer($idCustomer)
            ->filterByFkCompany($companyIds, Criteria::NOT_IN)
            ->select(
                [
                    SpyCompanyUserTableMap::COL_ID_COMPANY_USER,
                    SpyCompanyUserTableMap::COL_FK_COMPANY,
                    SpyCompanyRoleTableMap::COL_NAME,
                ],
            )
            ->find();

        return $this->groupCompanyRoles($companyUserCollection->toArray());
    }

    /**
     * @param array<int, array<string, mixed>> $collection
     *
     * @return array<int, array<string, mixed>>
     */
    protected function groupCompanyRoles(array $collection): array
    {
        $companyUserRoles = [];

        foreach ($collection as $index => $item) {
            if (!array_key_exists($item[SpyCompanyUserTableMap::COL_ID_COMPANY_USER], $companyUserRoles)) {
                $companyUserRoles[$item[SpyCompanyUserTableMap::COL_ID_COMPANY_USER]] =
                    [
                        static::INDEX_ID_COMPANY_USER => $item[SpyCompanyUserTableMap::COL_ID_COMPANY_USER],
                        static::INDEX_ID_COMPANY => $item[SpyCompanyUserTableMap::COL_FK_COMPANY],
                        static::INDEX_COMPANY_ROLES => [$item[SpyCompanyRoleTableMap::COL_NAME]],
                    ];

                continue;
            }

            $companyUserRoles[$item[SpyCompanyUserTableMap::COL_ID_COMPANY_USER]][static::INDEX_COMPANY_ROLES][]
                = $item[SpyCompanyRoleTableMap::COL_NAME];
        }

        return $companyUserRoles;
    }

    /**
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function getCompanyRoleCollectionByCompanyId(int $idCompany): CompanyRoleCollectionTransfer
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCompanyRoleQuery()
            ->filterByFkCompany($idCompany)
            ->find();

        return $this->getFactory()
            ->createCompanyRoleMapper()
            ->mapObjectCollectionToCompanyRoleCollectionTransfer($collection);
    }
}
