<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class ErpOrderCancellationPluginExecutor implements ErpOrderCancellationPluginExecutorInterface
{
    /**
     * @var array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface>
     */
    protected $erpOrderCancellationPreSavePlugins;

    /**
     * @var array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface>
     */
    protected $erpOrderCancellationPostSavePlugins;

    /**
     * @param array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface> $erpOrderCancellationPreSavePlugins
     * @param array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface> $erpOrderCancellationPostSavePlugins
     */
    public function __construct(array $erpOrderCancellationPreSavePlugins, array $erpOrderCancellationPostSavePlugins)
    {
        $this->erpOrderCancellationPreSavePlugins = $erpOrderCancellationPreSavePlugins;
        $this->erpOrderCancellationPostSavePlugins = $erpOrderCancellationPostSavePlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function executePostSavePlugins(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        foreach ($this->erpOrderCancellationPostSavePlugins as $plugin) {
            $erpOrderCancellationTransfer = $plugin->postSave($erpOrderCancellationTransfer);
        }

        return $erpOrderCancellationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function executePreSavePlugins(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        foreach ($this->erpOrderCancellationPreSavePlugins as $plugin) {
            $erpOrderCancellationTransfer = $plugin->preSave($erpOrderCancellationTransfer);
        }

        return $erpOrderCancellationTransfer;
    }
}
