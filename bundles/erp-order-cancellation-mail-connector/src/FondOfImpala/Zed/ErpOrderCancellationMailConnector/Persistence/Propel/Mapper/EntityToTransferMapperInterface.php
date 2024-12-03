<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\Propel\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\Base\FoiErpOrderCancellationNotify;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;

interface EntityToTransferMapperInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\Base\FoiErpOrderCancellationNotify $erpOrderCancellationNotify
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer
     */
    public function mapErpOrderCancellationNotifyEntityToTransfer(
        FoiErpOrderCancellationNotify $erpOrderCancellationNotify
    ): ErpOrderCancellationNotifyTransfer;

    /**
     * @param \Propel\Runtime\Collection\Collection|\Propel\Runtime\Collection\ObjectCollection $objectCollection
     *
     * @return \ArrayObject
     */
    public function mapErpOrderCancellationNotifyEntityCollectionToTransferCollection(Collection|ObjectCollection $objectCollection): ArrayObject;
}
