<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem;
use Propel\Runtime\Collection\Collection;

class EntityToTransferMapper implements EntityToTransferMapperInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $foiErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function mapEntityToTransfer(FoiErpOrderCancellation $foiErpOrderCancellation): ErpOrderCancellationTransfer
    {
        $erpOrderCancellationTransfer = new ErpOrderCancellationTransfer();
        $erpOrderCancellationTransfer->fromArray($foiErpOrderCancellation->toArray(), true);

        foreach ($foiErpOrderCancellation->getFoiErpOrderCancellationItems() as $item) {
            $erpOrderCancellationTransfer->addCancellationItem($this->mapItemEntityToTransfer($item));
        }

        $customer = $foiErpOrderCancellation->getSpyCustomerRelatedByFkCustomerRequested();
        if ($customer !== null) {
            $erpOrderCancellationTransfer->setCustomer((new CustomerTransfer())->fromArray($customer->toArray(), true));
        }

        $internalCustomer = $foiErpOrderCancellation->getSpyCustomerRelatedByFkCustomerInternal();
        if ($internalCustomer !== null) {
            $erpOrderCancellationTransfer->setCustomerInternal((new CustomerTransfer())->fromArray($internalCustomer->toArray(), true));
        }

        return $erpOrderCancellationTransfer;
    }

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem $foiErpOrderCancellationItem
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function mapItemEntityToTransfer(FoiErpOrderCancellationItem $foiErpOrderCancellationItem): ErpOrderCancellationItemTransfer
    {
        $erpOrderCancellationTransfer = new ErpOrderCancellationItemTransfer();
        $erpOrderCancellationTransfer->fromArray($foiErpOrderCancellationItem->toArray(), true);

        return $erpOrderCancellationTransfer;
    }

    /**
     * @param \Propel\Runtime\Collection\Collection $collection
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function mapEntityCollectionToTransferCollection(Collection $collection): ErpOrderCancellationCollectionTransfer
    {
        $resultCollection = new ErpOrderCancellationCollectionTransfer();
        /** @var \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $item */
        foreach ($collection->getData() as $item) {
            $resultCollection->addCancellation($this->mapEntityToTransfer($item));
        }

        return $resultCollection;
    }
}
