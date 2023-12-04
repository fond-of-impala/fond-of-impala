<?php

namespace FondOfImpala\Zed\ProductListConnector\Persistence;

use FondOfImpala\Zed\ProductListConnector\ProductListConnectorDependencyProvider;
use Orm\Zed\ProductList\Persistence\SpyProductListProductConcreteQuery;
use Orm\Zed\ProductList\Persistence\SpyProductListQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class ProductListConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ProductList\Persistence\SpyProductListQuery
     */
    public function getSpyProductListQuery(): SpyProductListQuery
    {
        return $this->getProvidedDependency(ProductListConnectorDependencyProvider::QUERY_PRODUCT_LIST);
    }

    /**
     * @return \Orm\Zed\ProductList\Persistence\SpyProductListProductConcreteQuery
     */
    public function getSpyProductListProductConcreteQuery(): SpyProductListProductConcreteQuery
    {
        return $this->getProvidedDependency(ProductListConnectorDependencyProvider::QUERY_PRODUCT_LIST_PRODUCT_CONCRETE);
    }
}
