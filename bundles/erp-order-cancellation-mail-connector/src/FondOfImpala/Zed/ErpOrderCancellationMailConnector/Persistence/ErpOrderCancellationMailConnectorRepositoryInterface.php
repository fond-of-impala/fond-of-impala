<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence;

use ArrayObject;

interface ErpOrderCancellationMailConnectorRepositoryInterface
{
    /**
     * @param string $debtorNumber
     * @param array $roleNames
     * @return array
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getMailAddressesByDebtorNumberAndRoleNames(string $debtorNumber, array $roleNames): array;

    /**
     * @param array $roleNames
     * @param string $debtorNumber
     * @return array
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getCompanyRoleIdsByNameAndDebtorNumber(array $roleNames, string $debtorNumber): array;
}
