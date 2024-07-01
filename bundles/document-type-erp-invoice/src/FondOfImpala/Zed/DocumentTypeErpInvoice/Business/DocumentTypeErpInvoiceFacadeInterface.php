<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Business;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;

interface DocumentTypeErpInvoiceFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function getFilter(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer;
}
