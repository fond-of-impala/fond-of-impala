<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Persistence;

use Generated\Shared\Transfer\PriceProductCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\QueryCriteriaTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListPersistenceFactory getFactory()
 */
class PriceProductPriceListRepository extends AbstractRepository implements PriceProductPriceListRepositoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\PriceProductCriteriaTransfer $priceProductCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\QueryCriteriaTransfer|null
     */
    public function buildPriceListPriceDimensionCriteria(
        PriceProductCriteriaTransfer $priceProductCriteriaTransfer
    ): ?QueryCriteriaTransfer {
        return $this->getFactory()
            ->createPriceListPriceQueryExpander()
            ->buildPriceListPriceDimensionQueryCriteria($priceProductCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return string|null
     */
    public function findIdByPriceProductTransfer(PriceProductTransfer $priceProductTransfer): ?string
    {
        $query = $this->getFactory()
            ->createPriceProductPriceListQuery()
            ->usePriceProductStoreQuery()
                ->filterByFkStore($priceProductTransfer->getMoneyValue()->getFkStore())
                ->filterByFkCurrency($priceProductTransfer->getMoneyValue()->getFkCurrency())
                ->filterByFkPriceProduct($priceProductTransfer->getIdPriceProduct())
            ->endUse()
            ->filterByFkPriceList($priceProductTransfer->getPriceDimension()->getIdPriceList());

        if ($priceProductTransfer->getIdProduct()) {
            $query->filterByFkProduct($priceProductTransfer->getIdProduct());
        } else {
            $query->filterByFkProductAbstract($priceProductTransfer->getIdProductAbstract());
        }

        $entity = $query->findOne();

        if ($entity === null) {
            return null;
        }

        return $entity->getIdPriceProductPriceList();
    }

    /**
     * {@inheritDoc}
     *
     * @return \Generated\Shared\Transfer\QueryCriteriaTransfer
     */
    public function buildUnconditionalPriceListPriceDimensionCriteria(): QueryCriteriaTransfer
    {
        return $this->getFactory()
            ->createPriceListPriceQueryExpander()
            ->buildUnconditionalMerchantRelationshipPriceDimensionQueryCriteria();
    }
}
