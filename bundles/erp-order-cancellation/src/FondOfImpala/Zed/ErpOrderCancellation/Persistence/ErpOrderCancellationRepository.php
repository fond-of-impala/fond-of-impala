<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationCriteriaFilterTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItemQuery;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Orm\Zed\ErpOrderCancellation\Persistence\Map\FoiErpOrderCancellationTableMap;
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
     * @param \Generated\Shared\Transfer\ErpOrderCancellationCriteriaFilterTransfer $erpOrderCancellationCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function getErpOrderCancellationCollection(
        ErpOrderCancellationCriteriaFilterTransfer $erpOrderCancellationCriteriaFilterTransfer
    ): ErpOrderCancellationCollectionTransfer {
        $erpOrderCancellationQuery = $this->getErpOrderCancellationQuery();

        $erpOrderCancellationQuery = $this->setErpOrderCancellationFilters(
            $erpOrderCancellationQuery,
            $erpOrderCancellationCriteriaFilterTransfer,
        );

        $erpOrderCancellationQuery->orderBy(
            FoiErpOrderCancellationTableMap::COL_ID_ERP_ORDER_CANCELLATION,
            'DESC',
        );

        return $this->getFactory()
            ->createErpOrderCancellationMapper()
            ->mapErpOrderCancellationEntityCollectionToErpOderCancellationCollectionTransfer(
                $erpOrderCancellationQuery->find(),
            );
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

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery $erpOrderCancellationQuery
     * @param \Generated\Shared\Transfer\ErpOrderCancellationCriteriaFilterTransfer $erpOrderCancellationCriteriaFilterTransfer
     *
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    protected function setErpOrderCancellationFilters(
        FoiErpOrderCancellationQuery $erpOrderCancellationQuery,
        ErpOrderCancellationCriteriaFilterTransfer $erpOrderCancellationCriteriaFilterTransfer
    ): FoiErpOrderCancellationQuery {
        if ($erpOrderCancellationCriteriaFilterTransfer->getErpOrderReference()) {
            $erpOrderCancellationQuery->filterByErpOrderReference(
                $erpOrderCancellationCriteriaFilterTransfer->getErpOrderReference(),
            );
        }

        return $erpOrderCancellationQuery;
    }
}
