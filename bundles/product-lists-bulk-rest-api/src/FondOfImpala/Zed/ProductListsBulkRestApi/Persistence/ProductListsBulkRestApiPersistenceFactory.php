<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Persistence;

use FondOfImpala\Zed\ProductListsBulkRestApi\ProductListsBulkRestApiDependencyProvider;
use Orm\Zed\ProductList\Persistence\Base\SpyProductListQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class ProductListsBulkRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ProductList\Persistence\Base\SpyProductListQuery
     */
    public function getProductListQuery(): SpyProductListQuery
    {
        return $this->getProvidedDependency(ProductListsBulkRestApiDependencyProvider::PROPEL_QUERY_PRODUCT_LIST);
    }
}
