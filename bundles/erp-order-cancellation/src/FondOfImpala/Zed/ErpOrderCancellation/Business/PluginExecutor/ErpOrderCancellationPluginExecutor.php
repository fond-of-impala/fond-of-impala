<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor;

use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
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
     * @var array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostTransactionPluginInterface>
     */
    protected $erpOrderCancellationPostTransactionPlugins;

    /**
     * @param array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface> $erpOrderCancellationPreSavePlugins
     * @param array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface> $erpOrderCancellationPostSavePlugins
     * @param array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostTransactionPluginInterface> $erpOrderCancellationPostTransactionPlugins
     */
    public function __construct(
        array $erpOrderCancellationPreSavePlugins,
        array $erpOrderCancellationPostSavePlugins,
        array $erpOrderCancellationPostTransactionPlugins
    ) {
        $this->erpOrderCancellationPreSavePlugins = $erpOrderCancellationPreSavePlugins;
        $this->erpOrderCancellationPostSavePlugins = $erpOrderCancellationPostSavePlugins;
        $this->erpOrderCancellationPostTransactionPlugins = $erpOrderCancellationPostTransactionPlugins;
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

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function executePostTransactionPlugins(
        ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer
    ): ErpOrderCancellationResponseTransfer {
        foreach ($this->erpOrderCancellationPostTransactionPlugins as $plugin) {
            $erpOrderCancellationResponseTransfer = $plugin->postTransaction($erpOrderCancellationResponseTransfer);
        }

        return $erpOrderCancellationResponseTransfer;
    }
}
