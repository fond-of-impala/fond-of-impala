<?php

namespace FondOfImpala\Zed\PriceProductPriceListGui\Dependency\Facade;

use FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface;
use Generated\Shared\Transfer\PriceListCollectionTransfer;

class PriceProductPriceListGuiToPriceListFacadeBridge implements PriceProductPriceListGuiToPriceListFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface
     */
    protected $priceListFacade;

    /**
     * @param \FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface $priceListFacade
     */
    public function __construct(PriceListFacadeInterface $priceListFacade)
    {
        $this->priceListFacade = $priceListFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollection(): PriceListCollectionTransfer
    {
        return $this->priceListFacade->getPriceListCollection();
    }
}
