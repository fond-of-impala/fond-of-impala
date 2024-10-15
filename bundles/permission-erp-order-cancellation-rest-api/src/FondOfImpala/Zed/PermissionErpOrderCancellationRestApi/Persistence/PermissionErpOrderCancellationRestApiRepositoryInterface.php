<?php

namespace FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence;

interface PermissionErpOrderCancellationRestApiRepositoryInterface
{
    /**
     * @param string $key
     *
     * @return int|null
     */
    public function getIdPermissionByKey(string $key): ?int;

    /**
     * @param int $idCustomer
     * @param string $debtorNumber
     * @return int|null
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getIdCompanyUserByIdCustomerAndDebtorNumber(int $idCustomer, string $debtorNumber): ?int;

    /**
     * @param int $idCompanyUser
     * @param string $permissionName
     * @return bool
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function hasPermission(int $idCompanyUser, string $permissionName): bool;

    /**
     * @param int $fkCustomer
     * @return array|bool
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getDebtorNumbersByFkCustomer(int $fkCustomer): array;
}
