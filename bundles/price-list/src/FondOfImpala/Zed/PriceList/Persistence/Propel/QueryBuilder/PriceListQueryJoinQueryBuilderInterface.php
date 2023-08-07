<?php

namespace FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder;

use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Orm\Zed\PriceList\Persistence\Base\FosPriceListQuery;

interface PriceListQueryJoinQueryBuilderInterface
{
    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FosPriceListQuery $query
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\Base\FosPriceListQuery
     */
    public function addQueryFilters(
        FosPriceListQuery $query,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): FosPriceListQuery;
}
