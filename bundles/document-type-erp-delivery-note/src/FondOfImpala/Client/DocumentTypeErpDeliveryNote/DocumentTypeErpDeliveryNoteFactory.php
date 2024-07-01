<?php

namespace FondOfImpala\Client\DocumentTypeErpDeliveryNote;

use FondOfImpala\Client\DocumentTypeErpDeliveryNote\Dependency\Client\DocumentTypeErpDeliveryNoteToZedRequestClientInterface;
use FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed\DocumentTypeErpDeliveryNoteStub;
use FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed\DocumentTypeErpDeliveryNoteStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class DocumentTypeErpDeliveryNoteFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed\DocumentTypeErpDeliveryNoteStubInterface
     */
    public function createZedDocumentTypeErpDeliveryNoteStub(): DocumentTypeErpDeliveryNoteStubInterface
    {
        return new DocumentTypeErpDeliveryNoteStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\DocumentTypeErpDeliveryNote\Dependency\Client\DocumentTypeErpDeliveryNoteToZedRequestClientInterface
     */
    protected function getZedRequestClient(): DocumentTypeErpDeliveryNoteToZedRequestClientInterface
    {
        return $this->getProvidedDependency(DocumentTypeErpDeliveryNoteDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
