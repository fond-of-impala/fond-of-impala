<?php

namespace FondOfImpala\Client\DocumentTypeErpInvoice;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\DocumentTypeErpInvoice\DocumentTypeErpInvoiceFactory getFactory()
 */
class DocumentTypeErpInvoiceClient extends AbstractClient implements DocumentTypeErpInvoiceClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function getFilterTransfer(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer
    {
        return $this->getFactory()->createZedDocumentTypeErpInvoiceStub()
            ->getFilterTransfer($documentRequestTransfer);
    }
}
