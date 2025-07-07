<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence\Mapper;

use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;
use Propel\Runtime\Collection\Collection;

class ErpOrderCancellationMapper implements ErpOrderCancellationMapperInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $foiErpOrderCancellation
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function mapEntityToErpOrderCancellationTransfer(
        FoiErpOrderCancellation $foiErpOrderCancellation,
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer
    ): ErpOrderCancellationTransfer {
        return $erpOrderCancellationTransfer->fromArray(
            $foiErpOrderCancellation->toArray(),
            true,
        );
    }

    /**
     * @param \Propel\Runtime\Collection\Collection $erpOrderCancellationEntities
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function mapErpOrderCancellationEntityCollectionToErpOderCancellationCollectionTransfer(
        Collection $erpOrderCancellationEntities
    ): ErpOrderCancellationCollectionTransfer {
        $erpOrderCancellationCollectionTransfer = new ErpOrderCancellationCollectionTransfer();

        foreach ($erpOrderCancellationEntities as $erpOrderCancellationEntity) {
            $erpOrderCancellationTransfer = $this->mapEntityToErpOrderCancellationTransfer(
                $erpOrderCancellationEntity,
                new ErpOrderCancellationTransfer(),
            );

            $erpOrderCancellationCollectionTransfer->addCancellation($erpOrderCancellationTransfer);
        }

        return $erpOrderCancellationCollectionTransfer;
    }
}
