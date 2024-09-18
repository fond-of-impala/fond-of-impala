<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer;

use FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationItemPluginExecutorInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;

class ErpOrderCancellationItemWriter implements ErpOrderCancellationItemWriterInterface
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationItemPluginExecutorInterface
     */
    protected $erpOrderCancellationItemPluginExecutor;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface $entityManager
     * @param \FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationItemPluginExecutorInterface $erpOrderCancellationItemPluginExecutor
     */
    public function __construct(
        ErpOrderCancellationEntityManagerInterface $entityManager,
        ErpOrderCancellationItemPluginExecutorInterface $erpOrderCancellationItemPluginExecutor
    ) {
        $this->entityManager = $entityManager;
        $this->erpOrderCancellationItemPluginExecutor = $erpOrderCancellationItemPluginExecutor;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function create(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer
    {
        $erpOrderCancellationItemTransfer = $this->erpOrderCancellationItemPluginExecutor->executePreSavePlugins($erpOrderCancellationItemTransfer);
        $erpOrderCancellationItemTransfer = $this->entityManager->createErpOrderCancellationItem($erpOrderCancellationItemTransfer);

        return $this->erpOrderCancellationItemPluginExecutor->executePostSavePlugins($erpOrderCancellationItemTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function update(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer
    {
        $erpOrderCancellationItemTransfer
            ->requireFkErpOrderCancellation()
            ->requireSku();

        $erpOrderCancellationItemTransfer = $this->erpOrderCancellationItemPluginExecutor->executePreSavePlugins($erpOrderCancellationItemTransfer);
        $erpOrderCancellationItemTransfer = $this->entityManager->updateErpOrderCancellationItem($erpOrderCancellationItemTransfer);

        return $this->erpOrderCancellationItemPluginExecutor->executePostSavePlugins($erpOrderCancellationItemTransfer);
    }

    /**
     * @param int $fkErpOrderCancellation
     * @param string $sku
     *
     * @return void
     */
    public function delete(int $fkErpOrderCancellation, string $sku): void
    {
        $this->entityManager->deleteErpOrderCancellationItemByIdErpOrderCancellationItem($fkErpOrderCancellation, $sku);
    }
}
