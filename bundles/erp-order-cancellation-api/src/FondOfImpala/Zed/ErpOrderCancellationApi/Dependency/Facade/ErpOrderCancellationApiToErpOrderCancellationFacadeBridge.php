<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade;

use FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class ErpOrderCancellationApiToErpOrderCancellationFacadeBridge implements ErpOrderCancellationApiToErpOrderCancellationFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface
     */
    protected $erpOrderCancellationFacade;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface $erpOrderCancellationFacade
     */
    public function __construct(ErpOrderCancellationFacadeInterface $erpOrderCancellationFacade)
    {
        $this->erpOrderCancellationFacade = $erpOrderCancellationFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function createErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer
    {
        return $this->erpOrderCancellationFacade->createErpOrderCancellation($erpOrderCancellationTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function updateErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer
    {
        return $this->erpOrderCancellationFacade->updateErpOrderCancellation($erpOrderCancellationTransfer);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return void
     */
    public function deleteErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): void
    {
        $this->erpOrderCancellationFacade->deleteErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     */
    public function findErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): ?ErpOrderCancellationTransfer
    {
        return $this->erpOrderCancellationFacade->findErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);
    }
}
