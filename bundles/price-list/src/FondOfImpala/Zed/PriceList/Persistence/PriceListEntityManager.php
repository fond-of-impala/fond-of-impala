<?php

namespace FondOfImpala\Zed\PriceList\Persistence;

use Generated\Shared\Transfer\PriceListTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\PriceList\Persistence\PriceListPersistenceFactory getFactory()
 */
class PriceListEntityManager extends AbstractEntityManager implements PriceListEntityManagerInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function persist(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        $foiPriceListQuery = $this->getFactory()->createPriceListQuery();

        $foiPriceList = $foiPriceListQuery
            ->filterByIdPriceList($priceListTransfer->getIdPriceList())
            ->findOneOrCreate();

        $foiPriceList->fromArray($priceListTransfer->toArray());

        $foiPriceList->save();

        $priceListTransfer->setIdPriceList($foiPriceList->getIdPriceList());

        return $priceListTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @param int $idProductList
     *
     * @return void
     */
    public function deleteById(int $idProductList): void
    {
        $this->getFactory()
            ->createPriceListQuery()
            ->filterByIdPriceList($idProductList)
            ->delete();
    }

    /**
     * {@inheritDoc}
     *
     * @param string $name
     *
     * @return void
     */
    public function deleteByName(string $name): void
    {
        $this->getFactory()
            ->createPriceListQuery()
            ->filterByName($name)
            ->delete();
    }
}
