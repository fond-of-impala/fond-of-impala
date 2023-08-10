<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence;

use Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchPersistenceFactory getFactory()
 */
class PriceProductPriceListPageSearchQueryContainer extends AbstractQueryContainer implements PriceProductPriceListPageSearchQueryContainerInterface
{
    /**
     * @param array $priceProductPriceListIds
     *
     * @return \Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery
     */
    public function queryPriceProductAbstractPriceList(array $priceProductPriceListIds): FoiPriceProductPriceListQuery
    {
        $foiPriceProductPriceListQuery = $this->getFactory()->getPropelPriceProductPriceListQuery()
            ->clear()
            ->filterByFkProductAbstract(null, Criteria::ISNOTNULL)
            ->filterByFkProduct(null, Criteria::ISNULL);

        if (!$priceProductPriceListIds) {
            return $foiPriceProductPriceListQuery;
        }

        return $foiPriceProductPriceListQuery->filterByIdPriceProductPriceList_In($priceProductPriceListIds);
    }

    /**
     * @param array $priceProductPriceListIds
     *
     * @return \Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery
     */
    public function queryPriceProductConcretePriceList(array $priceProductPriceListIds): FoiPriceProductPriceListQuery
    {
        $foiPriceProductPriceListQuery = $this->getFactory()->getPropelPriceProductPriceListQuery()
            ->clear()
            ->filterByFkProductAbstract(null, Criteria::ISNULL)
            ->filterByFkProduct(null, Criteria::ISNOTNULL);

        if (!$priceProductPriceListIds) {
            return $foiPriceProductPriceListQuery;
        }

        return $foiPriceProductPriceListQuery->filterByIdPriceProductPriceList_In($priceProductPriceListIds);
    }
}
