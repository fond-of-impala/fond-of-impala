<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business;

use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListBusinessFactory getFactory()
 */
class PriceProductPriceListFacade extends AbstractFacade implements PriceProductPriceListFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductDimensionTransfer $priceProductDimensionTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    public function expandPriceProductDimension(PriceProductDimensionTransfer $priceProductDimensionTransfer): PriceProductDimensionTransfer
    {
        return $this->getFactory()
            ->createPriceProductDimensionExpander()
            ->expand($priceProductDimensionTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function savePriceProductPriceList(PriceProductTransfer $priceProductTransfer): PriceProductTransfer
    {
        return $this->getFactory()
            ->createPriceListPriceWriter()
            ->persist($priceProductTransfer);
    }

    /**
     * Specification:
     *  - Deletes connection records between spy_price_product_store and price_list. by idPriceProductStore
     *
     * @api
     *
     * @param int $idPriceProductStore
     *
     * @return void
     */
    public function deletePriceProductPriceListByIdPriceProductStore(int $idPriceProductStore): void
    {
        $this->getFactory()->createPriceListPriceWriter()->deleteByIdPriceProductStore($idPriceProductStore);
    }
}
