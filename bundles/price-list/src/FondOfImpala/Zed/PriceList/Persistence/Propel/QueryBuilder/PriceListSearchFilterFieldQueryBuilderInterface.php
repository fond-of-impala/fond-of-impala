<?php

namespace FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder;

use Generated\Shared\Transfer\PriceListListTransfer;
use Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery;

interface PriceListSearchFilterFieldQueryBuilderInterface
{
    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery $priceListQuery
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery
     */
    public function addSalesOrderQueryFilters(
        FoiPriceListQuery $priceListQuery,
        PriceListListTransfer $priceListListTransfer
    ): FoiPriceListQuery;
}
