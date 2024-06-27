<?php

namespace FondOfImpala\Client\DocumentTypeErpOrder;

use FondOfImpala\Client\DocumentTypeErpOrder\Dependency\Client\DocumentTypeErpOrderToZedRequestClientInterface;
use FondOfImpala\Client\DocumentTypeErpOrder\Zed\DocumentTypeErpOrderStub;
use FondOfImpala\Client\DocumentTypeErpOrder\Zed\DocumentTypeErpOrderStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class DocumentTypeErpOrderFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\DocumentTypeErpOrder\Zed\DocumentTypeErpOrderStubInterface
     */
    public function createZedDocumentTypeErpOrderStub(): DocumentTypeErpOrderStubInterface
    {
        return new DocumentTypeErpOrderStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\DocumentTypeErpOrder\Dependency\Client\DocumentTypeErpOrderToZedRequestClientInterface
     */
    protected function getZedRequestClient(): DocumentTypeErpOrderToZedRequestClientInterface
    {
        return $this->getProvidedDependency(DocumentTypeErpOrderDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
