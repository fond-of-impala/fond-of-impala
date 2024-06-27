<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence;

use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteDependencyProvider;
use Orm\Zed\ErpDeliveryNote\Persistence\FooErpDeliveryNoteQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class DocumentTypeErpDeliveryNotePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ErpDeliveryNote\Persistence\FooErpDeliveryNoteQuery
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getErpDeliveryNoteQuery(): FooErpDeliveryNoteQuery
    {
        return $this->getProvidedDependency(DocumentTypeErpDeliveryNoteDependencyProvider::QUERY_ERP_DELIVERY_NOTE);
    }
}
