<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;

class ExternalReferenceRestFilterToFilterMapperExpanderPlugin implements ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface
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
    ): ErpOrderCancellationFilterTransfer {
        if ($restErpOrderCancellationFilterTransfer->getExternalReference() === null) {
            return $erpOrderCancellationFilterTransfer;
        }

        return $erpOrderCancellationFilterTransfer
            ->addExternalReference($restErpOrderCancellationFilterTransfer->getExternalReference());
    }
}
