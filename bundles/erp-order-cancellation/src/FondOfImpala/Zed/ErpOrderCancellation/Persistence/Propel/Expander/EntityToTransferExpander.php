<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Expander;

use ArrayObject;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;

class EntityToTransferExpander implements EntityToTransferExpanderInterface
{
    /**
     * @var ArrayObject|\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\Persistence\ErpOrderCancellationTransferExpanderPluginInterface[]
     */
    protected ArrayObject $erpOrderCancellationExpanderPlugins;

    /**
     * @param ArrayObject<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\Persistence\ErpOrderCancellationTransferExpanderPluginInterface> $erpOrderCancellationExpanderPlugins
     */
    public function __construct(ArrayObject $erpOrderCancellationExpanderPlugins)
    {
        $this->erpOrderCancellationExpanderPlugins = $erpOrderCancellationExpanderPlugins;
    }

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $erpOrderCancellation
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function expandErpOrderCancellation(
        FoiErpOrderCancellation      $erpOrderCancellation,
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer
    ): ErpOrderCancellationTransfer
    {
        foreach ($this->erpOrderCancellationExpanderPlugins as $plugin){
            $erpOrderCancellationTransfer = $plugin->expand($erpOrderCancellation, $erpOrderCancellationTransfer);
        }

        return $erpOrderCancellationTransfer;
    }
}
