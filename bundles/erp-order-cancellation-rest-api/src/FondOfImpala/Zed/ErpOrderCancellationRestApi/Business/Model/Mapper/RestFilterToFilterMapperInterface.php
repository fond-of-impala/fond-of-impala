<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper;

use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;

interface RestFilterToFilterMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer|null $erpOrderCancellationFilterTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    public function fromRestRequest(RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer, ?ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer = null): ErpOrderCancellationFilterTransfer;
}
