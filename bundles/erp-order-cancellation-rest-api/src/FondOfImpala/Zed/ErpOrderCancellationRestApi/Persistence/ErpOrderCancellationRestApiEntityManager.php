<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence;

use Exception;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiPersistenceFactory getFactory()
 */
class ErpOrderCancellationRestApiEntityManager extends AbstractEntityManager implements ErpOrderCancellationRestApiEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function updateErpOrderCancellationAmount(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        $erpOrderCancellationTransfer
            ->requireIdErpOrderCancellation()
            ->requireAmount();

        $cancellation = $this->getErpOrderCancellationQuery()->findOneByIdErpOrderCancellation($erpOrderCancellationTransfer->getIdErpOrderCancellation());

        if ($cancellation === null) {
            throw new Exception(sprintf('Erp order cancellation with id %s not found', $erpOrderCancellationTransfer->getIdErpOrderCancellation()));
        }

        $cancellation->setAmount($erpOrderCancellationTransfer->getAmount())->save();

        return $erpOrderCancellationTransfer;
    }

    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    protected function getErpOrderCancellationQuery(): FoiErpOrderCancellationQuery
    {
        return $this->getFactory()->getErpOrderCancellationQuery()->clear();
    }
}
