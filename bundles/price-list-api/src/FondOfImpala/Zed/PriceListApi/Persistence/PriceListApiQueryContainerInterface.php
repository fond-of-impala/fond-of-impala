<?php

namespace FondOfImpala\Zed\PriceListApi\Persistence;

use Orm\Zed\PriceList\Persistence\FoiPriceListQuery;

interface PriceListApiQueryContainerInterface
{
    /**
     * @return \Orm\Zed\PriceList\Persistence\FoiPriceListQuery
     */
    public function queryFind(): FoiPriceListQuery;
}
