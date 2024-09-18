<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItemQuery;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationPersistenceFactory getFactory()
 */
class ErpOrderCancellationRepository extends AbstractRepository implements ErpOrderCancellationRepositoryInterface
{
    /**
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     */
    public function findErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): ?ErpOrderCancellationTransfer
    {
        $query = $this->getErpOrderCancellationQuery();
        $order = $query->findOneByIdErpOrderCancellation($idErpOrderCancellation);

        if ($order === null) {
            return null;
        }

        return $this->getFactory()->createEntityToTransferMapper()->fromErpOrderCancellationToTransfer($order);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return \ArrayObject
     */
    public function findErpOrderCancellationItemsByIdErpOrderCancellation(int $idErpOrderCancellation): ArrayObject
    {
        $query = $this->getErpOrderCancellationItemQuery();
        $items = $query->findByFkErpOrderCancellation($idErpOrderCancellation);
        $itemCollectionTransfer = new ArrayObject();

        if (empty($items->getData())) {
            return $itemCollectionTransfer;
        }

        foreach ($items->getData() as $item) {
            $itemCollectionTransfer->append($this->getFactory()->createEntityToTransferMapper()->fromEprOrderCancellationItemToTransfer($item));
        }

        return $itemCollectionTransfer;
    }

    /**
     * @param int $fkErpOrderCancellation
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer|null
     */
    public function findErpOrderCancellationItemByIdErpOrderCancellationAndSku(int $fkErpOrderCancellation, string $sku): ?ErpOrderCancellationItemTransfer
    {
        $query = $this->getErpOrderCancellationItemQuery();
        $item = $query
            ->filterByFkErpOrderCancellation($fkErpOrderCancellation)
            ->filterBySku($sku)
            ->findOne();

        if ($item === null) {
            return null;
        }

        return $this->getFactory()->createEntityToTransferMapper()->fromEprOrderCancellationItemToTransfer($item);
    }

    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    protected function getErpOrderCancellationQuery(): FoiErpOrderCancellationQuery
    {
        return $this->getFactory()->createErpOrderCancellationQuery();
    }

    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItemQuery
     */
    protected function getErpOrderCancellationItemQuery(): FoiErpOrderCancellationItemQuery
    {
        return $this->getFactory()->createErpOrderCancellationItemQuery();
    }
}
