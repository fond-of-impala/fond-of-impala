<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder\Persistence;

use FondOfImpala\Zed\DocumentTypeErpOrder\DocumentTypeErpOrderDependencyProvider;
use Orm\Zed\ErpOrder\Persistence\ErpOrderQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class DocumentTypeErpOrderPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ErpOrder\Persistence\ErpOrderQuery
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getErpOrderQuery(): ErpOrderQuery
    {
        return $this->getProvidedDependency(DocumentTypeErpOrderDependencyProvider::QUERY_ERP_ORDER);
    }
}
