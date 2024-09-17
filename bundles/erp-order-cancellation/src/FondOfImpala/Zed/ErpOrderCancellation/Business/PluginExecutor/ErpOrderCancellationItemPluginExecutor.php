<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor;

use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;

class ErpOrderCancellationItemPluginExecutor implements ErpOrderCancellationItemPluginExecutorInterface
{
    /**
     * @var array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPreSavePluginInterface>
     */
    protected $erpOrderCancellationItemPreSavePlugins;

    /**
     * @var array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPostSavePluginInterface>
     */
    protected $erpOrderCancellationItemPostSavePlugins;

    /**
     * @param array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPreSavePluginInterface> $erpOrderCancellationItemPreSavePlugins
     * @param array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPostSavePluginInterface> $erpOrderCancellationItemPostSavePlugins
     */
    public function __construct(array $erpOrderCancellationItemPreSavePlugins, array $erpOrderCancellationItemPostSavePlugins)
    {
        $this->erpOrderCancellationItemPreSavePlugins = $erpOrderCancellationItemPreSavePlugins;
        $this->erpOrderCancellationItemPostSavePlugins = $erpOrderCancellationItemPostSavePlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function executePostSavePlugins(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer
    {
        foreach ($this->erpOrderCancellationItemPostSavePlugins as $plugin) {
            $erpOrderCancellationItemTransfer = $plugin->postSave($erpOrderCancellationItemTransfer);
        }

        return $erpOrderCancellationItemTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function executePreSavePlugins(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer
    {
        foreach ($this->erpOrderCancellationItemPreSavePlugins as $plugin) {
            $erpOrderCancellationItemTransfer = $plugin->preSave($erpOrderCancellationItemTransfer);
        }

        return $erpOrderCancellationItemTransfer;
    }
}
