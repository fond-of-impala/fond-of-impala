<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence;

use Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface PriceProductPriceListPageSearchQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @param array $priceProductPriceListIds
     *
     * @return \Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery
     */
    public function queryPriceProductAbstractPriceList(array $priceProductPriceListIds): FoiPriceProductPriceListQuery;

    /**
     * @param array $priceProductPriceListIds
     *
     * @return \Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery
     */
    public function queryPriceProductConcretePriceList(array $priceProductPriceListIds): FoiPriceProductPriceListQuery;
}
