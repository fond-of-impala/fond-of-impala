<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence;


use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Generated\Shared\Transfer\ErpInvoiceTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

interface DocumentTypeErpInvoiceRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     * @return \Generated\Shared\Transfer\ErpInvoiceTransfer|null
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getErpInvoiceWithPermissionCheck(DocumentRequestTransfer $documentRequestTransfer): ?ErpInvoiceTransfer;
}
