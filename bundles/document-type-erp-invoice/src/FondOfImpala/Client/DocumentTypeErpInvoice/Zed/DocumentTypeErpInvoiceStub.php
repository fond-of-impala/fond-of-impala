<?php

namespace FondOfImpala\Client\DocumentTypeErpInvoice\Zed;

use FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;

class DocumentTypeErpInvoiceStub implements DocumentTypeErpInvoiceStubInterface
{
    protected DocumentTypeErpInvoiceToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(DocumentTypeErpInvoiceToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function getFilterTransfer(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer
    {
        /** @var \Generated\Shared\Transfer\EasyApiFilterTransfer $filterTransfer */
        $filterTransfer = $this->zedRequestClient
            ->call('/document-type-erp-invoice/gateway/get-filter', $documentRequestTransfer);

        return $filterTransfer;
    }
}
