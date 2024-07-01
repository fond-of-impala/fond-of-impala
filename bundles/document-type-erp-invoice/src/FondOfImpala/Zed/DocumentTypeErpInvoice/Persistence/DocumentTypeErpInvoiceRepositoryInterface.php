<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\ErpInvoiceTransfer;

interface DocumentTypeErpInvoiceRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\ErpInvoiceTransfer|null
     */
    public function getErpInvoiceWithPermissionCheck(DocumentRequestTransfer $documentRequestTransfer): ?ErpInvoiceTransfer;
}
