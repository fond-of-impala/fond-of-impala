<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;

class ErpOrderCancellationExpander implements ErpOrderCancellationExpanderInterface
{
    /**
     * @var array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationExpanderPluginInterface>
     */
    protected array $erpOrderCancellationExpanderPlugins;

    /**
     * @param array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationExpanderPluginInterface> $erpOrderCancellationExpanderPlugins
     */
    public function __construct(array $erpOrderCancellationExpanderPlugins)
    {
        $this->erpOrderCancellationExpanderPlugins = $erpOrderCancellationExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function expand(
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer,
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): ErpOrderCancellationTransfer {
        foreach ($this->erpOrderCancellationExpanderPlugins as $erpOrderCancellationExpanderPlugin) {
            $erpOrderCancellationTransfer = $erpOrderCancellationExpanderPlugin->expand($erpOrderCancellationTransfer, $restErpOrderCancellationRequestTransfer);
        }

        return $erpOrderCancellationTransfer;
    }
}
