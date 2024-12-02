<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence;

use Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationNotifyQuery;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorPersistenceFactory getFactory()
 */
class ErpOrderCancellationMailConnectorEntityManager extends AbstractEntityManager implements ErpOrderCancellationMailConnectorEntityManagerInterface
{
    /**
     * @param int $idErpOrderCancellation
     *
     * @return void
     */
    public function removeNotificationRecipientsForErpOrderCancellation(int $idErpOrderCancellation): void
    {
        $this->getFoiErpOrderCancellationNotifyQuery()
            ->filterByFkErpOrderCancellation($idErpOrderCancellation)
            ->delete();
    }

    /**
     * @param int $idErpOrderCancellation
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer
     */
    public function createNotificationChainEntry(int $idErpOrderCancellation, int $idCustomer): ErpOrderCancellationNotifyTransfer
    {
        $entity = $this->getFoiErpOrderCancellationNotifyQuery()
            ->filterByFkErpOrderCancellation($idErpOrderCancellation)
            ->filterByFkCustomer($idCustomer)
            ->findOneOrCreate();

        $entity->save();

        return $this->getFactory()->createEntityToTransferMapper()->mapErpOrderCancellationNotifyEntityToTransfer($entity);
    }

    /**
     * @param int $idErpOrderCancellation
     * @param int $idCustomer
     *
     * @return void
     */
    public function deleteNotificationChainEntry(int $idErpOrderCancellation, int $idCustomer): void
    {
        $this->getFoiErpOrderCancellationNotifyQuery()
            ->filterByFkErpOrderCancellation($idErpOrderCancellation)
            ->filterByFkCustomer($idCustomer)
            ->delete();
    }

    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationNotifyQuery
     */
    protected function getFoiErpOrderCancellationNotifyQuery(): FoiErpOrderCancellationNotifyQuery
    {
        return $this->getFactory()->createFoiErpOrderCancellationNotifyQuery()->clear();
    }
}
