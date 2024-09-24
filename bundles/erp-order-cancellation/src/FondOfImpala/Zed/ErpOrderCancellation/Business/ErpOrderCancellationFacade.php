<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business;

use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface getRepository()
 */
class ErpOrderCancellationFacade extends AbstractFacade implements ErpOrderCancellationFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function createErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer
    {
        return $this->getFactory()->createErpOrderCancellationWriter()->create($erpOrderCancellationTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function updateErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer
    {
        return $this->getFactory()->createErpOrderCancellationWriter()->update($erpOrderCancellationTransfer);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return void
     */
    public function deleteErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): void
    {
        $this->getFactory()->createErpOrderCancellationWriter()->delete($idErpOrderCancellation);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     */
    public function findErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): ?ErpOrderCancellationTransfer
    {
        return $this->getFactory()->createErpOrderCancellationReader()->findErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function persistErpOrderCancellationItem(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        return $this->getFactory()->createErpOrderCancellationItemHandler()->handle($erpOrderCancellationTransfer);
    }
}
