<?php

namespace FondOfImpala\Client\DocumentTypeErpDeliveryNote;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteFactory getFactory()
 */
class DocumentTypeErpDeliveryNoteClient extends AbstractClient implements DocumentTypeErpDeliveryNoteClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function getFilterTransfer(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer
    {
        return $this->getFactory()->createZedDocumentTypeErpDeliveryNoteStub()
            ->getFilterTransfer($documentRequestTransfer);
    }
}
