<?php

namespace FondOfImpala\Zed\PriceListGui\Dependency\Facade;

use FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListTransfer;

class PriceListGuiToPriceListFacadeBridge implements PriceListGuiToPriceListFacadeInterface
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
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function findPriceListByName(PriceListTransfer $priceListTransfer): ?PriceListTransfer
    {
        return $this->priceListFacade->findPriceListByName($priceListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function findPriceListById(PriceListTransfer $priceListTransfer): ?PriceListTransfer
    {
        return $this->priceListFacade->findPriceListById($priceListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function createPriceList(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        return $this->priceListFacade->createPriceList($priceListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function updatePriceList(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        return $this->priceListFacade->updatePriceList($priceListTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollection(): PriceListCollectionTransfer
    {
        return $this->priceListFacade->getPriceListCollection();
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return void
     */
    public function deletePriceListById(PriceListTransfer $priceListTransfer): void
    {
        $this->priceListFacade->deletePriceListById($priceListTransfer);
    }
}
