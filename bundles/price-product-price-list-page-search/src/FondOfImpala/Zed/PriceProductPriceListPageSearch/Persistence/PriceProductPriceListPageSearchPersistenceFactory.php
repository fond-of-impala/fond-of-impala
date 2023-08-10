<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence;

use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\Propel\Mapper\PriceProductPriceListPageSearchMapper;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\Propel\Mapper\PriceProductPriceListPageSearchMapperInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchDependencyProvider;
use Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery;
use Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearchQuery;
use Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearchQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchQueryContainerInterface getQueryContainer()
 */
class PriceProductPriceListPageSearchPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery
     */
    public function getPropelPriceProductPriceListQuery(): FoiPriceProductPriceListQuery
    {
        return $this->getProvidedDependency(PriceProductPriceListPageSearchDependencyProvider::PROPEL_QUERY_PRICE_PRODUCT_PRICE_LIST);
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\Propel\Mapper\PriceProductPriceListPageSearchMapperInterface
     */
    public function createPriceProductPriceListPageSearchMapper(): PriceProductPriceListPageSearchMapperInterface
    {
        return new PriceProductPriceListPageSearchMapper();
    }

    /**
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearchQuery
     */
    public function createPriceProductAbstractPriceListPageSearchQuery(): FoiPriceProductAbstractPriceListPageSearchQuery
    {
        return FoiPriceProductAbstractPriceListPageSearchQuery::create();
    }

    /**
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearchQuery
     */
    public function createPriceProductConcretePriceListPageSearchQuery(): FoiPriceProductConcretePriceListPageSearchQuery
    {
        return FoiPriceProductConcretePriceListPageSearchQuery::create();
    }
}
