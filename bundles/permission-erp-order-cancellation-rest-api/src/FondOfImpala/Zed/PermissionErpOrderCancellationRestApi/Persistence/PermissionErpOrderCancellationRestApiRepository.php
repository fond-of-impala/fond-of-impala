<?php

namespace FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence;

use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\Permission\Persistence\Map\SpyPermissionTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence\PermissionErpOrderCancellationRestApiPersistenceFactory getFactory()
 */
class PermissionErpOrderCancellationRestApiRepository extends AbstractRepository implements PermissionErpOrderCancellationRestApiRepositoryInterface
{
    /**
     * @param string $key
     *
     * @return int|null
     */
    public function getIdPermissionByKey(string $key): ?int
    {
        /** @var int|null $idPermission */
        $idPermission = $this->getFactory()
            ->getPermissionQuery()
            ->clear()
            ->filterByKey($key)
            ->select([SpyPermissionTableMap::COL_ID_PERMISSION])
            ->findOne();

        return $idPermission;
    }

    /**
     * @param int $idCustomer
     * @param string $debtorNumber
     * @return int|null
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getIdCompanyUserByIdCustomerAndDebtorNumber(int $idCustomer, string $debtorNumber): ?int
    {
        /** @var \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery $query */
        $query = $this->getFactory()
            ->getCompanyUserQuery()
            ->clear()
            ->filterByFkCustomer($idCustomer)
            ->useCompanyQuery()
                ->filterByDebtorNumber($debtorNumber)
            ->endUse()
            ->select([SpyCompanyUserTableMap::COL_ID_COMPANY_USER]);

        return $query
            ->findOne();
    }

    /**
     * @param int $idCompanyUser
     * @param string $permissionName
     * @return bool
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function hasPermission(int $idCompanyUser, string $permissionName): bool
    {
        $query = $this->getFactory()
            ->getCompanyRoleQuery()
            ->clear()
            ->useSpyCompanyRoleToCompanyUserQuery()->filterByFkCompanyUser($idCompanyUser)
            ->endUse()
            ->useSpyCompanyRoleToPermissionQuery()
                ->usePermissionQuery()
                    ->filterByKey($permissionName)
                ->endUse()
            ->endUse();

        return $query
            ->findOne() !== null;
    }

    /**
     * @param int $fkCustomer
     * @return array|bool
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getDebtorNumbersByFkCustomer(int $fkCustomer): array
    {
        $query = $this->getFactory()
            ->getCompanyQuery()
            ->clear()
            ->useCompanyUserQuery()
                ->filterByFkCustomer($fkCustomer)
            ->endUse()
            ->select([SpyCompanyTableMap::COL_DEBTOR_NUMBER]);

        $debtorNumbers = $query->find();

        if (count($debtorNumbers->getData()) === 0) {
            return [];
        }

        return $debtorNumbers->getData();
    }
}
