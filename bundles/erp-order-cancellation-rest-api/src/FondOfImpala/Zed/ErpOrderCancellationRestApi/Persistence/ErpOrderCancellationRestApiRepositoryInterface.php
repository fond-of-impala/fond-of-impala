<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence;

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
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function findErpOrderCancellation(ErpOrderCancellationFilterTransfer $filterTransfer): ErpOrderCancellationCollectionTransfer;

    /**
     * @param string $uuid
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function findErpOrderCancellationByUuid(string $uuid): ?ErpOrderCancellationTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationPaginationTransfer
     */
    public function getErpOrderCancellationPagination(
        ErpOrderCancellationFilterTransfer $filterTransfer
    ): ErpOrderCancellationPaginationTransfer;
}
