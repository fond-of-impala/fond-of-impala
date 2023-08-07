<?php

namespace FondOfImpala\Zed\PriceList\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListListTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\PriceList\Persistence\PriceListPersistenceFactory getFactory()
 */
class PriceListRepository extends AbstractRepository implements PriceListRepositoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @param int $idPriceList
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function getById(int $idPriceList): ?PriceListTransfer
    {
        $fosPriceList = $this->getFactory()
            ->createPriceListQuery()
            ->filterByIdPriceList($idPriceList)
            ->findOne();

        if (!$fosPriceList) {
            return null;
        }

        return $this->getFactory()
            ->createPriceListMapper()
            ->mapEntityToTransfer($fosPriceList);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function getByName(string $name): ?PriceListTransfer
    {
        $fosPriceList = $this->getFactory()
            ->createPriceListQuery()
            ->filterByName($name)
            ->findOne();

        if (!$fosPriceList) {
            return null;
        }

        return $this->getFactory()
            ->createPriceListMapper()
            ->mapEntityToTransfer($fosPriceList);
    }

    /**
     * {@inheritDoc}
     *
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getAll(): PriceListCollectionTransfer
    {
        $fosPriceLists = $this->getFactory()
            ->createPriceListQuery()
            ->find();

        $priceListCollectionTransfer = new PriceListCollectionTransfer();

        foreach ($fosPriceLists as $fosPriceList) {
            $priceListTransfer = $this->getFactory()
                ->createPriceListMapper()
                ->mapEntityToTransfer($fosPriceList);

            $priceListCollectionTransfer->addPriceList($priceListTransfer);
        }

        return $priceListCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListListTransfer
     */
    public function findPriceLists(PriceListListTransfer $priceListListTransfer): PriceListListTransfer
    {
        $query = $this->getFactory()
            ->createPriceListQuery()
            ->groupByIdPriceList()
            ->setIgnoreCase(true);

        $query = $this->getFactory()
            ->createPriceListSearchFilterFieldQueryBuilder()
            ->addSalesOrderQueryFilters($query, $priceListListTransfer);

        $queryJoinCollectionTransfer = $priceListListTransfer->getQueryJoins();

        if ($queryJoinCollectionTransfer !== null && $queryJoinCollectionTransfer->getQueryJoins()->count() > 0) {
            $query = $this->getFactory()
                ->createPriceListQueryJoinQueryBuilder()
                ->addQueryFilters($query, $queryJoinCollectionTransfer);
        }

        $priceListTransfers = $this->getFactory()
            ->createPriceListMapper()
            ->mapEntityCollectionToTransfers($query->find());

        return $priceListListTransfer->setPriceLists(new ArrayObject($priceListTransfers));
    }
}
