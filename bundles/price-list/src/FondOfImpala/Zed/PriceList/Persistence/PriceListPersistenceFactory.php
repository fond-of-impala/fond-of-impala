<?php

namespace FondOfImpala\Zed\PriceList\Persistence;

use FondOfImpala\Zed\PriceList\Persistence\Propel\Mapper\PriceListMapper;
use FondOfImpala\Zed\PriceList\Persistence\Propel\Mapper\PriceListMapperInterface;
use FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder\PriceListQueryJoinQueryBuilder;
use FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder\PriceListQueryJoinQueryBuilderInterface;
use FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder\PriceListSearchFilterFieldQueryBuilder;
use FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder\PriceListSearchFilterFieldQueryBuilderInterface;
use Orm\Zed\PriceList\Persistence\FoiPriceListQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\PriceList\PriceListConfig getConfig()
 * @method \FondOfImpala\Zed\PriceList\Persistence\PriceListRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManagerInterface getEntityManager()
 */
class PriceListPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\PriceList\Persistence\FoiPriceListQuery
     */
    public function createPriceListQuery(): FoiPriceListQuery
    {
        return FoiPriceListQuery::create();
    }

    /**
     * @return \FondOfImpala\Zed\PriceList\Persistence\Propel\Mapper\PriceListMapperInterface
     */
    public function createPriceListMapper(): PriceListMapperInterface
    {
        return new PriceListMapper();
    }

    /**
     * @return \FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder\PriceListQueryJoinQueryBuilderInterface
     */
    public function createPriceListQueryJoinQueryBuilder(): PriceListQueryJoinQueryBuilderInterface
    {
        return new PriceListQueryJoinQueryBuilder();
    }

    /**
     * @return \FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder\PriceListSearchFilterFieldQueryBuilderInterface
     */
    public function createPriceListSearchFilterFieldQueryBuilder(): PriceListSearchFilterFieldQueryBuilderInterface
    {
        return new PriceListSearchFilterFieldQueryBuilder(
            $this->getConfig(),
        );
    }
}
