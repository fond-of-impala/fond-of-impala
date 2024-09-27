<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem;
use Propel\Runtime\Collection\ObjectCollection;

interface EntityToTransferMapperInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $foiErpOrderCancellation
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function mapEntityToTransfer(FoiErpOrderCancellation $foiErpOrderCancellation
    ): ErpOrderCancellationTransfer;

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem $foiErpOrderCancellationItem
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function mapItemEntityToTransfer(FoiErpOrderCancellationItem $foiErpOrderCancellationItem
    ): ErpOrderCancellationItemTransfer;

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $collection
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function mapEntityCollectionToTransferCollection(ObjectCollection $collection
    ): ErpOrderCancellationCollectionTransfer;
}
