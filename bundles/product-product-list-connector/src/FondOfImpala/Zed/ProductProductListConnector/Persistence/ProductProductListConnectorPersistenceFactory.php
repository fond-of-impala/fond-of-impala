<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Persistence;

use FondOfImpala\Zed\ProductProductListConnector\ProductProductListConnectorDependencyProvider;
use Orm\Zed\ProductList\Persistence\SpyProductListProductConcreteQuery;
use Orm\Zed\ProductList\Persistence\SpyProductListQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class ProductProductListConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ProductList\Persistence\SpyProductListQuery
     */
    public function getSpyProductListQuery(): SpyProductListQuery
    {
        return $this->getProvidedDependency(ProductProductListConnectorDependencyProvider::QUERY_PRODUCT_LIST);
    }

    /**
     * @return \Orm\Zed\ProductList\Persistence\SpyProductListProductConcreteQuery
     */
    public function getSpyProductListProductConcreteQuery(): SpyProductListProductConcreteQuery
    {
        return $this->getProvidedDependency(ProductProductListConnectorDependencyProvider::QUERY_PRODUCT_LIST_PRODUCT_CONCRETE);
    }
}
