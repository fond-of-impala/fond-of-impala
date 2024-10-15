<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestCancellationItemTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
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
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function mapFromRequest(RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer): ErpOrderCancellationTransfer;

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestCancellationItemTransfer> $restItemCollection
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer>
     */
    public function mapItemsFromRequest(ArrayObject $restItemCollection): ArrayObject;

    /**
     * @param \Generated\Shared\Transfer\RestCancellationItemTransfer $restCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function mapItemFromItemRequest(RestCancellationItemTransfer $restCancellationItemTransfer): ErpOrderCancellationItemTransfer;
}
