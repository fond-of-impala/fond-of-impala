<?php

namespace FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder;

use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery;

interface PriceListQueryJoinQueryBuilderInterface
{
    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery $query
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery
     */
    public function addQueryFilters(
        FoiPriceListQuery $query,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): FoiPriceListQuery;
}
