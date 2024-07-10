<?php

namespace FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed;

use FondOfImpala\Client\DocumentTypeErpDeliveryNote\Dependency\Client\DocumentTypeErpDeliveryNoteToZedRequestClientInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;

class DocumentTypeErpDeliveryNoteStub implements DocumentTypeErpDeliveryNoteStubInterface
{
    /**
     * @var string
     */
    public const URL_GET_FILTER = '/document-type-erp-delivery-note/gateway/get-filter';

    protected DocumentTypeErpDeliveryNoteToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\DocumentTypeErpDeliveryNote\Dependency\Client\DocumentTypeErpDeliveryNoteToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(DocumentTypeErpDeliveryNoteToZedRequestClientInterface $zedRequestClient)
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
            ->call(static::URL_GET_FILTER, $documentRequestTransfer);

        return $filterTransfer;
    }
}
