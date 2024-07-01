<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote;

use Orm\Zed\ErpDeliveryNote\Persistence\FooErpDeliveryNoteQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DocumentTypeErpDeliveryNoteDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const QUERY_ERP_DELIVERY_NOTE = 'QUERY_ERP_DELIVERY_NOTE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        return $this->addFooErpDeliveryNoteQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFooErpDeliveryNoteQuery(Container $container): Container
    {
        $container[static::QUERY_ERP_DELIVERY_NOTE] = static fn (): FooErpDeliveryNoteQuery => FooErpDeliveryNoteQuery::create();

        return $container;
    }
}
