<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationPaginationTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ErpOrderCancellationRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @throws \Exception
     *
     * @return int
     */
    public function getIdCustomerByReference(string $customerReference): int;

    /**
     * @param string $mail
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getCustomerReferenceByMail(string $mail): string;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function findErpOrderCancellation(ErpOrderCancellationFilterTransfer $filterTransfer): ErpOrderCancellationCollectionTransfer;

    /**
     * @param string $uuid
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     */
    public function findErpOrderCancellationByUuid(string $uuid): ?ErpOrderCancellationTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationPaginationTransfer
     */
    public function getErpOrderCancellationPagination(
        ErpOrderCancellationFilterTransfer $filterTransfer
    ): ErpOrderCancellationPaginationTransfer;

    /**
     * @param int $idCustomer
     * @param string $debtorNumber
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function getCompanyUserByIdCustomerAndDebtorNumber(int $idCustomer, string $debtorNumber): CompanyUserTransfer;

    /**
     * @param int $idCustomer
     * @param array<int> $internalCompanyIds
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return bool
     */
    public function isInternalCustomer(int $idCustomer, array $internalCompanyIds): bool;
}
