<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence;

use FondOfImpala\Zed\DocumentTypeErpInvoice\DocumentTypeErpInvoiceDependencyProvider;
use Orm\Zed\ErpInvoice\Persistence\FooErpInvoiceQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class DocumentTypeErpInvoicePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ErpInvoice\Persistence\FooErpInvoiceQuery
     */
    public function getErpInvoiceQuery(): FooErpInvoiceQuery
    {
        return $this->getProvidedDependency(DocumentTypeErpInvoiceDependencyProvider::QUERY_ERP_INVOICE);
    }
}
