<?php

namespace FondOfImpala\Zed\PriceListApi\Dependency\Facade;

use FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacadeInterface;
use Generated\Shared\Transfer\PriceProductTransfer;

class PriceListApiToPriceProductPriceListFacadeBridge implements PriceListApiToPriceProductPriceListFacadeInterface
{
    protected PriceProductPriceListFacadeInterface $priceProductPriceListFacade;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacadeInterface $priceProductPriceListFacade
     */
    public function __construct(PriceProductPriceListFacadeInterface $priceProductPriceListFacade)
    {
        $this->priceProductPriceListFacade = $priceProductPriceListFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function savePriceProductPriceList(PriceProductTransfer $priceProductTransfer): PriceProductTransfer
    {
        return $this->priceProductPriceListFacade->savePriceProductPriceList($priceProductTransfer);
    }
}
