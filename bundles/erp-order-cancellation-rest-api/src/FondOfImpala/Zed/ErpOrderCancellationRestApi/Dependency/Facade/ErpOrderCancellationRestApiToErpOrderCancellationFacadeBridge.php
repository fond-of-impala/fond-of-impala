<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class ErpOrderCancellationRestApiToErpOrderCancellationFacadeBridge implements ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface
     */
    protected $facade;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface $erpOrderCancellationFacade
     */
    public function __construct(ErpOrderCancellationFacadeInterface $erpOrderCancellationFacade)
    {
        $this->facade = $erpOrderCancellationFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function createErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer
    {
        return $this->facade->createErpOrderCancellation($erpOrderCancellationTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function updateErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer
    {
        return $this->facade->updateErpOrderCancellation($erpOrderCancellationTransfer);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return void
     */
    public function deleteErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): void
    {
        $this->facade->deleteErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);
    }
}
