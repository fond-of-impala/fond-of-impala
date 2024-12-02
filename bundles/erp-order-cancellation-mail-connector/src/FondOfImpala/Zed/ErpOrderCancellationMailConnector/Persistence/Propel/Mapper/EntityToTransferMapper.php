<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\Propel\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\Base\FoiErpOrderCancellationNotify;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;

class EntityToTransferMapper implements EntityToTransferMapperInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\Base\FoiErpOrderCancellationNotify $erpOrderCancellationNotify
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer
     */
    public function mapErpOrderCancellationNotifyEntityToTransfer(FoiErpOrderCancellationNotify $erpOrderCancellationNotify): ErpOrderCancellationNotifyTransfer
    {
        $spyCustomer = $erpOrderCancellationNotify->getSpyCustomer();

        return (new ErpOrderCancellationNotifyTransfer())->fromArray($spyCustomer->toArray(), true)
            ->setFkErpOrderCancellation($erpOrderCancellationNotify->getFkErpOrderCancellation())
            ->setFkCustomer($spyCustomer->getIdCustomer());
    }

    /**
     * @param \Propel\Runtime\Collection\Collection|\Propel\Runtime\Collection\ObjectCollection $objectCollection
     *
     * @return \ArrayObject
     */
    public function mapErpOrderCancellationNotifyEntityCollectionToTransferCollection(Collection|ObjectCollection $objectCollection): ArrayObject
    {
        $collection = new ArrayObject();
        foreach ($objectCollection->getData() as $notification) {
            $notifyTransfer = $this->mapErpOrderCancellationNotifyEntityToTransfer($notification);
            $collection->append($notifyTransfer);
        }

        return $collection;
    }
}
