<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch;
use Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch;

interface PriceProductPriceListPageSearchEntityManagerInterface
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
    ): void;

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return void
     */
    public function createPriceProductAbstract(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): void;

    /**
     * @param \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch[] $priceProductAbstractPriceListPageSearchEntities
     *
     * @return void
     */
    public function deletePriceProductAbstractEntities(
        array $priceProductAbstractPriceListPageSearchEntities
    ): void;

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     * @param \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch $priceProductConcretePriceListPageSearchEntity
     *
     * @return void
     */
    public function updatePriceProductConcrete(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer,
        FoiPriceProductConcretePriceListPageSearch $priceProductConcretePriceListPageSearchEntity
    ): void;

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return void
     */
    public function createPriceProductConcrete(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): void;

    /**
     * @param \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch[] $priceProductConcretePriceListPageSearchEntities
     *
     * @return void
     */
    public function deletePriceProductConcreteEntities(
        array $priceProductConcretePriceListPageSearchEntities
    ): void;
}
