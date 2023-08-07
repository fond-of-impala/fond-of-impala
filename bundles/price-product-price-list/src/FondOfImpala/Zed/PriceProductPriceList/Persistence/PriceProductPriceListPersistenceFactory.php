<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Persistence;

use FondOfImpala\Zed\PriceProductPriceList\Persistence\Propel\PriceDimensionQueryExpander\PriceListPriceQueryExpander;
use FondOfImpala\Zed\PriceProductPriceList\Persistence\Propel\PriceDimensionQueryExpander\PriceListPriceQueryExpanderInterface;
use Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\PriceProductPriceList\PriceProductPriceListConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepositoryInterface getRepository()
 */
class PriceProductPriceListPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfImpala\Zed\PriceProductPriceList\Persistence\Propel\PriceDimensionQueryExpander\PriceListPriceQueryExpanderInterface
     */
    public function createPriceListPriceQueryExpander(): PriceListPriceQueryExpanderInterface
    {
        return new PriceListPriceQueryExpander();
    }

    /**
     * @return \Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery
     */
    public function createPriceProductPriceListQuery(): FoiPriceProductPriceListQuery
    {
        return FoiPriceProductPriceListQuery::create();
    }
}
