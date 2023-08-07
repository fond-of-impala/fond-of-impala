<?php

namespace FondOfImpala\Zed\PriceList\Business;

use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListListTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\PriceList\Business\PriceListBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\PriceList\Persistence\PriceListRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManagerInterface getEntityManager()
 */
class PriceListFacade extends AbstractFacade implements PriceListFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function findPriceListById(PriceListTransfer $priceListTransfer): ?PriceListTransfer
    {
        return $this->getFactory()->createPriceListReader()->findById($priceListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function findPriceListByName(PriceListTransfer $priceListTransfer): ?PriceListTransfer
    {
        return $this->getFactory()->createPriceListReader()->findByName($priceListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return void
     */
    public function deletePriceListById(PriceListTransfer $priceListTransfer): void
    {
        $this->getFactory()->createPriceListWriter()->deleteById($priceListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return void
     */
    public function deletePriceListByName(PriceListTransfer $priceListTransfer): void
    {
        $this->getFactory()->createPriceListWriter()->deleteByName($priceListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * * @api
     *
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollection(): PriceListCollectionTransfer
    {
        return $this->getFactory()->createPriceListReader()->findAll();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function createPriceList(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        return $this->getFactory()->createPriceListWriter()->create($priceListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function updatePriceList(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        return $this->getFactory()->createPriceListWriter()->update($priceListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListListTransfer
     */
    public function findPriceLists(PriceListListTransfer $priceListListTransfer): PriceListListTransfer
    {
        return $this->getFactory()->createPriceListReader()->findByPriceListList($priceListListTransfer);
    }
}
