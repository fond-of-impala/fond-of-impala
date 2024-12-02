<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\CustomerCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Propel\Runtime\Collection\ObjectCollection;

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
     * @param array<int, string> $email
     * @return \Generated\Shared\Transfer\CustomerCollectionTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getCustomerCollectionByMail(array $email): CustomerCollectionTransfer;

    /**
     * @param int $idErpOrderCancellation
     * @return \ArrayObject<\Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer>
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getNotificationChainByIdErpOrderCancellation(int $idErpOrderCancellation): ArrayObject;

    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByIdCustomer(int $idCustomer): ?CustomerTransfer;
}
