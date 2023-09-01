<?php

namespace FondOfImpala\Zed\CustomerPriceList\Persistence;

use FondOfImpala\Zed\CustomerPriceList\CustomerPriceListDependencyProvider;
use FondOfImpala\Zed\CustomerPriceList\Persistence\Propel\Mapper\PriceListMapper;
use FondOfImpala\Zed\CustomerPriceList\Persistence\Propel\Mapper\PriceListMapperInterface;
use Orm\Zed\PriceList\Persistence\FoiPriceListQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepositoryInterface getRepository()
 */
class CustomerPriceListPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\PriceList\Persistence\FoiPriceListQuery
     */
    public function getPriceListQuery(): FoiPriceListQuery
    {
        return $this->getProvidedDependency(CustomerPriceListDependencyProvider::PROPEL_PRICE_LIST_QUERY);
    }

    /**
     * @return \FondOfImpala\Zed\CustomerPriceList\Persistence\Propel\Mapper\PriceListMapperInterface
     */
    public function createPriceListMapper(): PriceListMapperInterface
    {
        return new PriceListMapper();
    }
}
