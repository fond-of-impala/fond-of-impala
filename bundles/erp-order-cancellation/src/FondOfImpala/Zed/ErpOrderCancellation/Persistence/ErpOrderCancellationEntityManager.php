<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence;

use DateTime;
use Exception;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationPersistenceFactory getFactory()
 */
class ErpOrderCancellationEntityManager extends AbstractEntityManager implements ErpOrderCancellationEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function createErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        if ($erpOrderCancellationTransfer->getIdErpOrderCancellation() !== null) {
            throw new Exception('Use "updateErpOrderCancellation" function instead of "createErpOrderCancellation" if you already have an id!');
        }

        $erpOrderCancellationTransfer
            ->requireDebitorNumber()
            ->requireFkCustomerRequested()
            ->requireCancellationNumber()
            ->requireErpOrderReference()
            ->requireErpOrderExternalReference();

        $now = new DateTime();
        $entity = new FoiErpOrderCancellation();
        $entity->fromArray($erpOrderCancellationTransfer->toArray());
        $entity
            ->setCreatedAt($erpOrderCancellationTransfer->getCreatedAt())
            ->setUpdatedAt($now)
            ->save();

        return $this->getFactory()
            ->createEntityToTransferMapper()
            ->fromErpOrderCancellationToTransfer($entity, $erpOrderCancellationTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function createErpOrderCancellationItem(ErpOrderCancellationItemTransfer $itemTransfer): ErpOrderCancellationItemTransfer
    {
        $itemTransfer
            ->requireFkErpOrderCancellation()
            ->requireSku();

        $now = new DateTime();

        $entity = new FoiErpOrderCancellationItem();
        $entity->fromArray($itemTransfer->toArray());
        $entity
            ->setCreatedAt($now)
            ->setUpdatedAt($now)
            ->save();

        return $this->getFactory()->createEntityToTransferMapper()->fromEprOrderCancellationItemToTransfer(
            $entity,
            $itemTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function updateErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        $erpOrderCancellationTransfer->requireIdErpOrderCancellation();

        $query = $this->getFactory()->createErpOrderCancellationQuery()->clear();

        $entity = $query->findOneByIdErpOrderCancellation($erpOrderCancellationTransfer->getIdErpOrderCancellation());

        if ($entity === null) {
            throw new Exception(sprintf(
                'Erp order cancellation with id %s not found',
                $erpOrderCancellationTransfer->getIdErpOrderCancellation(),
            ));
        }
        $createdAt = $entity->getCreatedAt();
        $entity->fromArray($erpOrderCancellationTransfer->modifiedToArray());

        $entity
            ->setCreatedAt($createdAt)
            ->setUpdatedAt(new DateTime())
            ->save();

        return $this->getFactory()
            ->createEntityToTransferMapper()
            ->fromErpOrderCancellationToTransfer($entity, $erpOrderCancellationTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $orderItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function updateErpOrderCancellationItem(ErpOrderCancellationItemTransfer $orderItemTransfer): ErpOrderCancellationItemTransfer
    {
        $orderItemTransfer
            ->requireFkErpOrderCancellation()
            ->requireSku();

        $entity = $this->findOrCreateErpOrderCancellationItem($orderItemTransfer->getFkErpOrderCancellation(), $orderItemTransfer->getSku());
        $createdAt = $entity->getCreatedAt();
        $updatedAt = new DateTime();
        $entity->fromArray($orderItemTransfer->modifiedToArray());

        $entity
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->save();

        return $this->getFactory()->createEntityToTransferMapper()->fromEprOrderCancellationItemToTransfer($entity);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return void
     */
    public function deleteErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): void
    {
        $order = $this->getFactory()->createErpOrderCancellationQuery()->clear()->findOneByIdErpOrderCancellation($idErpOrderCancellation);
        $items = $order->getFoiErpOrderCancellationItems();

        foreach ($items as $item) {
            $item->delete();
        }

        $order->delete();
    }

    /**
     * @param int $fkErpOrderCancellation
     * @param string $sku
     *
     * @return void
     */
    public function deleteErpOrderCancellationItemByIdErpOrderCancellationItem(int $fkErpOrderCancellation, string $sku): void
    {
        $orderItem = $this->getFactory()
            ->createErpOrderCancellationItemQuery()
            ->clear()
            ->filterByFkErpOrderCancellation($fkErpOrderCancellation)
            ->filterBySku($sku)
            ->findOne();
        if ($orderItem === null) {
            return;
        }
        $orderItem->delete();
    }

    /**
     * @param int $idErpOrderCancellation
     * @param string $sku
     *
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem
     */
    protected function findOrCreateErpOrderCancellationItem(int $idErpOrderCancellation, string $sku): FoiErpOrderCancellationItem
    {
        return $this->getFactory()->createErpOrderCancellationItemQuery()->clear()
            ->filterByFkErpOrderCancellation($idErpOrderCancellation)
            ->filterBySku($sku)
            ->findOneOrCreate();
    }

    /**
     * @param string|null $date
     *
     * @return \DateTime|null
     */
    protected function getDate(?string $date): ?DateTime
    {
        if ($date !== null) {
            $date = new DateTime($date);
        }

        return $date;
    }
}
