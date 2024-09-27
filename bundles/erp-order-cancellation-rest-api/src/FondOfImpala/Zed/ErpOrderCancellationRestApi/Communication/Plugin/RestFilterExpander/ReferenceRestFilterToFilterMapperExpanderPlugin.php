<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;

class ReferenceRestFilterToFilterMapperExpanderPlugin implements ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface
{
    public function expand(RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer, ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer): ErpOrderCancellationFilterTransfer
    {
        if ($restErpOrderCancellationFilterTransfer->getReference() === null) {
            return $erpOrderCancellationFilterTransfer;
        }

        return $erpOrderCancellationFilterTransfer
            ->addReference($restErpOrderCancellationFilterTransfer->getReference());
    }
}
