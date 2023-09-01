<?php

namespace FondOfImpala\Zed\CompanyPriceListGui\Dependency\Facade;

use FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface;
use Generated\Shared\Transfer\PriceListCollectionTransfer;

class CompanyPriceListGuiToPriceListFacadeBridge implements CompanyPriceListGuiToPriceListFacadeInterface
{
    protected PriceListFacadeInterface $priceListFacade;

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
