<?php

namespace FondOfImpala\Zed\PriceListApi\Persistence;

use Orm\Zed\PriceList\Persistence\FoiPriceListQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiPersistenceFactory getFactory()
 */
class PriceListApiQueryContainer extends AbstractQueryContainer implements PriceListApiQueryContainerInterface
{
    /**
     * @return \Orm\Zed\PriceList\Persistence\FoiPriceListQuery
     */
    public function queryFind(): FoiPriceListQuery
    {
        return $this->getFactory()->getPriceListQuery();
    }
}
