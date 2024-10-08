<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;

interface ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    public function expand(
        RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer,
        ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer
    ): ErpOrderCancellationFilterTransfer;
}
