<?php

namespace FondOfImpala\Client\DocumentTypeErpOrder\Zed;

use FondOfImpala\Client\DocumentTypeErpOrder\Dependency\Client\DocumentTypeErpOrderToZedRequestClientInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;

class DocumentTypeErpOrderStub implements DocumentTypeErpOrderStubInterface
{
    /**
     * @var string
     */
    public const URL_GET_FILTER = '/document-type-erp-order/gateway/get-filter';

    protected DocumentTypeErpOrderToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\DocumentTypeErpOrder\Dependency\Client\DocumentTypeErpOrderToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(DocumentTypeErpOrderToZedRequestClientInterface $zedRequestClient)
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
