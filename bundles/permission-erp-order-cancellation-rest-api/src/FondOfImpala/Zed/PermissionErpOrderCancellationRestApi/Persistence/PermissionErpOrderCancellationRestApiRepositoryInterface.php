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
     * @param int $idCompanyUser
     * @param string $permissionName
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return bool
     */
    public function hasPermission(int $idCompanyUser, string $permissionName): bool;

    /**
     * @param int $fkCustomer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return array
     */
    public function getDebtorNumbersByFkCustomer(int $fkCustomer): array;
}
