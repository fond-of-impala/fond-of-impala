<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence\Mapper;

use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Propel\Runtime\Collection\Collection;

interface ErpOrderCancellationMapperInterface
{
    /**
     * @param \Propel\Runtime\Collection\Collection $erpOrderCancellationEntities
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function mapErpOrderCancellationEntityCollectionToErpOderCancellationCollectionTransfer(
        Collection $erpOrderCancellationEntities
    ): ErpOrderCancellationCollectionTransfer;
}
