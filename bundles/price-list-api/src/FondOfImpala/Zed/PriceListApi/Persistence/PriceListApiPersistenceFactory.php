<?php

namespace FondOfImpala\Zed\PriceListApi\Persistence;

use FondOfImpala\Zed\PriceListApi\PriceListApiDependencyProvider;
use Orm\Zed\PriceList\Persistence\FoiPriceListQuery;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\PriceListApi\PriceListApiConfig getConfig()
 * @method \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiRepositoryInterface getRepository()
 */
class PriceListApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\PriceList\Persistence\FoiPriceListQuery
     */
    public function getPriceListQuery(): FoiPriceListQuery
    {
        return $this->getProvidedDependency(PriceListApiDependencyProvider::PROPEL_QUERY_PRICE_LIST);
    }

    /**
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function getProductAbstractQuery(): SpyProductAbstractQuery
    {
        return $this->getProvidedDependency(PriceListApiDependencyProvider::PROPEL_QUERY_PRODUCT_ABSTRACT);
    }
}
