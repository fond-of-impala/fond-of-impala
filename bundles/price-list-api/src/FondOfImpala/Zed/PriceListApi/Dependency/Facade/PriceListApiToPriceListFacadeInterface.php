<?php

namespace FondOfImpala\Zed\PriceListApi\Dependency\Facade;

use Generated\Shared\Transfer\PriceListTransfer;

interface PriceListApiToPriceListFacadeInterface
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
}
