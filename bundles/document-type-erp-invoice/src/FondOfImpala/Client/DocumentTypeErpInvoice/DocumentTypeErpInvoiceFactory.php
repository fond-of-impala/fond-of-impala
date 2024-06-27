<?php

namespace FondOfImpala\Client\DocumentTypeErpInvoice;

use FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientInterface;
use FondOfImpala\Client\DocumentTypeErpInvoice\Zed\DocumentTypeErpInvoiceStub;
use FondOfImpala\Client\DocumentTypeErpInvoice\Zed\DocumentTypeErpInvoiceStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class DocumentTypeErpInvoiceFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\DocumentTypeErpInvoice\Zed\DocumentTypeErpInvoiceStubInterface
     */
    public function createZedDocumentTypeErpInvoiceStub(): DocumentTypeErpInvoiceStubInterface
    {
        return new DocumentTypeErpInvoiceStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientInterface
     */
    protected function getZedRequestClient(): DocumentTypeErpInvoiceToZedRequestClientInterface
    {
        return $this->getProvidedDependency(DocumentTypeErpInvoiceDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
