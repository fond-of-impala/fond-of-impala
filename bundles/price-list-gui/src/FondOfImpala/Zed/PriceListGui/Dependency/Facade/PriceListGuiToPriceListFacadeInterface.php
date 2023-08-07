<?php

namespace FondOfImpala\Zed\PriceListGui\Dependency\Facade;

use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListTransfer;

interface PriceListGuiToPriceListFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function findPriceListByName(PriceListTransfer $priceListTransfer): ?PriceListTransfer;

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function findPriceListById(PriceListTransfer $priceListTransfer): ?PriceListTransfer;

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function createPriceList(PriceListTransfer $priceListTransfer): PriceListTransfer;

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function updatePriceList(PriceListTransfer $priceListTransfer): PriceListTransfer;

    /**
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollection(): PriceListCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return void
     */
    public function deletePriceListById(PriceListTransfer $priceListTransfer): void;
}
