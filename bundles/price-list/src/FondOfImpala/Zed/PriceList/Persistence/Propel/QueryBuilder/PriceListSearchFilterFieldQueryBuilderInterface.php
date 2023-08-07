<?php

namespace FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder;

use Generated\Shared\Transfer\PriceListListTransfer;
use Orm\Zed\PriceList\Persistence\Base\FosPriceListQuery;

interface PriceListSearchFilterFieldQueryBuilderInterface
{
    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FosPriceListQuery $priceListQuery
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\Base\FosPriceListQuery
     */
    public function addSalesOrderQueryFilters(
        FosPriceListQuery $priceListQuery,
        PriceListListTransfer $priceListListTransfer
    ): FosPriceListQuery;
}
