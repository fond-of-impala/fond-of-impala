<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepositoryInterface getRepository()
 */
class PriceProductPriceListPageSearchFacade extends AbstractFacade implements PriceProductPriceListPageSearchFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int[] $priceProductPriceListIds
     *
     * @return void
     */
    public function publishAbstractPriceProductPriceList(array $priceProductPriceListIds): void
    {
        $this->getFactory()->createPriceProductAbstractSearchWriter()
            ->publishAbstractPriceProductPriceList($priceProductPriceListIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int[] $productAbstractIds
     *
     * @return void
     */
    public function publishAbstractPriceProductByByProductAbstractIds(array $productAbstractIds): void
    {
        $this->getFactory()->createPriceProductAbstractSearchWriter()
            ->publishAbstractPriceProductByByProductAbstractIds($productAbstractIds);
    }

    /**
     * Specification:
     *  - Publish merchant relationship prices for product concretes.
     *  - Uses the given concrete product IDs.
     *  - Refreshes the prices data for product concretes for all business units and merchant relationships.
     *
     * @api
     *
     * @param int[] $productIds
     *
     * @return void
     */
    public function publishConcretePriceProductByProductIds(array $productIds): void
    {
        $this->getFactory()->createPriceProductConcreteSearchWriter()
            ->publishConcretePriceProductByProductIds($productIds);
    }

    /**
     * Specification:
     *  - Publish price list prices for products.
     *  - Uses the given IDs of the `foi_price_product_price_list` table.
     *  - Merges created or updated prices to the existing ones.
     *
     * @api
     *
     * @param int[] $priceProductPriceListIds
     *
     * @return void
     */
    public function publishConcretePriceProductPriceList(array $priceProductPriceListIds): void
    {
        $this->getFactory()->createPriceProductConcreteSearchWriter()
            ->publishConcretePriceProductPriceList($priceProductPriceListIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idPriceList
     *
     * @return void
     */
    public function publishAbstractPriceProductPriceListByIdPriceList(int $idPriceList): void
    {
        $this->getFactory()->createPriceProductAbstractSearchWriter()
            ->publishAbstractPriceProductPriceListByIdPriceList($idPriceList);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idPriceList
     *
     * @return void
     */
    public function publishConcretePriceProductPriceListByIdPriceList(int $idPriceList): void
    {
        $this->getFactory()->createPriceProductConcreteSearchWriter()
            ->publishConcretePriceProductPriceListByIdPriceList($idPriceList);
    }
}
