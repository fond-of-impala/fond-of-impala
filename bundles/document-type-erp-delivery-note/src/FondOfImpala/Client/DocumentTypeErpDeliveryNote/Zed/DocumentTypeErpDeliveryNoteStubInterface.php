<?php

namespace FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;

interface DocumentTypeErpDeliveryNoteStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function getFilterTransfer(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer;
}
