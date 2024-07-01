<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder;

use Orm\Zed\ErpOrder\Persistence\ErpOrderQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DocumentTypeErpOrderDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const QUERY_ERP_ORDER = 'QUERY_ERP_ORDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        return $this->addFooErpOrderQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFooErpOrderQuery(Container $container): Container
    {
        $container[static::QUERY_ERP_ORDER] = static fn (): ErpOrderQuery => ErpOrderQuery::create();

        return $container;
    }
}
