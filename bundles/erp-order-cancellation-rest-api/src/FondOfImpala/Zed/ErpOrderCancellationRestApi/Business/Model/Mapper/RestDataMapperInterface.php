<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationTransfer;

interface RestDataMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationTransfer
     */
    public function mapResponse(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): RestErpOrderCancellationTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer $companyUserCollectionTransfer
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestErpOrderCancellationTransfer>
     */
    public function mapResponseCollection(ErpOrderCancellationCollectionTransfer $erpOrderCancellationCollectionTransfer): ArrayObject;
}
