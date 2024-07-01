<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice;

use Orm\Zed\ErpInvoice\Persistence\FooErpInvoiceQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DocumentTypeErpInvoiceDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const QUERY_ERP_INVOICE = 'QUERY_ERP_INVOICE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        return $this->addFooErpInvoiceQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFooErpInvoiceQuery(Container $container): Container
    {
        $container[static::QUERY_ERP_INVOICE] = static fn (): FooErpInvoiceQuery => FooErpInvoiceQuery::create();

        return $container;
    }
}
