<?php

namespace FondOfImpala\Client\DocumentTypeErpOrder;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\DocumentTypeErpOrder\DocumentTypeErpOrderFactory getFactory()
 */
class DocumentTypeErpOrderClient extends AbstractClient implements DocumentTypeErpOrderClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function getFilterTransfer(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer
    {
        return $this->getFactory()->createZedDocumentTypeErpOrderStub()
            ->getFilterTransfer($documentRequestTransfer);
    }
}
