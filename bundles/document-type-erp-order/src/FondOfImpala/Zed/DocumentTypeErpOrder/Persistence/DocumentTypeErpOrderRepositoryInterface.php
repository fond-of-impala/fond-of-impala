<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder\Persistence;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\ErpOrderTransfer;

interface DocumentTypeErpOrderRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    public function getErpOrder(DocumentRequestTransfer $documentRequestTransfer): ?ErpOrderTransfer;

    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    public function getErpOrderWithPermissionCheck(DocumentRequestTransfer $documentRequestTransfer): ?ErpOrderTransfer;
}
