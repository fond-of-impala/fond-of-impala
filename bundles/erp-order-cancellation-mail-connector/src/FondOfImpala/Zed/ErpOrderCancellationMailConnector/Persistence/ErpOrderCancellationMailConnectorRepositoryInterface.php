<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;

interface ErpOrderCancellationMailConnectorRepositoryInterface
{
    /**
     * @param string $debtorNumber
     * @param array $roleNames
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return array
     */
    public function getMailAddressesByDebtorNumberAndRoleNames(string $debtorNumber, array $roleNames): array;

    /**
     * @param array $roleNames
     * @param string $debtorNumber
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return array
     */
    public function getCompanyRoleIdsByNameAndDebtorNumber(array $roleNames, string $debtorNumber): array;

    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByIdCustomer(int $idCustomer): ?CustomerTransfer;
}
