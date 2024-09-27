<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;

class DebitorNumberRestFilterToFilterMapperExpanderPlugin implements ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface
{
    public function expand(RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer, ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer): ErpOrderCancellationFilterTransfer
    {
        if ($restErpOrderCancellationFilterTransfer->getDebitorNumber() === null) {
            return $erpOrderCancellationFilterTransfer;

        }

        return $erpOrderCancellationFilterTransfer
            ->addDebitorNumber($restErpOrderCancellationFilterTransfer->getDebitorNumber());
    }

}
