<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch;
use Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchPersistenceFactory getFactory()
 */
class PriceProductPriceListPageSearchEntityManager extends AbstractEntityManager implements PriceProductPriceListPageSearchEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     * @param \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch $priceProductAbstractPriceListPageSearchEntity
     *
     * @return void
     */
    public function updatePriceProductAbstract(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer,
        FoiPriceProductAbstractPriceListPageSearch $priceProductAbstractPriceListPageSearchEntity
    ): void {
        $priceProductAbstractPriceListPageSearchEntity
            ->setData($priceProductPriceListPageSearchTransfer->getData())
            ->setStructuredData($priceProductPriceListPageSearchTransfer->getStructuredData())
            ->setIsSendingToQueue($this->getFactory()->getConfig()->isSendingToQueue())
            ->save();
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return void
     */
    public function createPriceProductAbstract(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): void {
        (new FoiPriceProductAbstractPriceListPageSearch())
            ->setFkProductAbstract($priceProductPriceListPageSearchTransfer->getIdProduct())
            ->setFkPriceList($priceProductPriceListPageSearchTransfer->getIdPriceList())
            ->setPriceKey($priceProductPriceListPageSearchTransfer->getPriceKey())
            ->setData($priceProductPriceListPageSearchTransfer->getData())
            ->setStructuredData($priceProductPriceListPageSearchTransfer->getStructuredData())
            ->setIsSendingToQueue($this->getFactory()->getConfig()->isSendingToQueue())
            ->save();
    }

    /**
     * @param array<\Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch> $priceProductAbstractPriceListPageSearchEntities
     *
     * @return void
     */
    public function deletePriceProductAbstractEntities(array $priceProductAbstractPriceListPageSearchEntities): void
    {
        foreach ($priceProductAbstractPriceListPageSearchEntities as $priceProductAbstractPriceListPageSearchEntity) {
            $priceProductAbstractPriceListPageSearchEntity->delete();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     * @param \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch $priceProductConcretePriceListPageSearchEntity
     *
     * @return void
     */
    public function updatePriceProductConcrete(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer,
        FoiPriceProductConcretePriceListPageSearch $priceProductConcretePriceListPageSearchEntity
    ): void {
        $priceProductConcretePriceListPageSearchEntity
            ->setData($priceProductPriceListPageSearchTransfer->getData())
            ->setStructuredData($priceProductPriceListPageSearchTransfer->getStructuredData())
            ->setIsSendingToQueue($this->getFactory()->getConfig()->isSendingToQueue())
            ->save();
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return void
     */
    public function createPriceProductConcrete(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): void {
        (new FoiPriceProductConcretePriceListPageSearch())
            ->setFkProduct($priceProductPriceListPageSearchTransfer->getIdProduct())
            ->setFkPriceList($priceProductPriceListPageSearchTransfer->getIdPriceList())
            ->setPriceKey($priceProductPriceListPageSearchTransfer->getPriceKey())
            ->setData($priceProductPriceListPageSearchTransfer->getData())
            ->setStructuredData($priceProductPriceListPageSearchTransfer->getStructuredData())
            ->setIsSendingToQueue($this->getFactory()->getConfig()->isSendingToQueue())
            ->save();
    }

    /**
     * @param array<\Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch> $priceProductConcretePriceListPageSearchEntities
     *
     * @return void
     */
    public function deletePriceProductConcreteEntities(array $priceProductConcretePriceListPageSearchEntities): void
    {
        foreach ($priceProductConcretePriceListPageSearchEntities as $priceProductConcretePriceListPageSearchEntity) {
            $priceProductConcretePriceListPageSearchEntity->delete();
        }
    }
}
