<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Mapper;

use DateTime;
use Exception;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem;

/**
 * @codeCoverageIgnore
 */
class EntityToTransferMapper implements EntityToTransferMapperInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem $orderItem
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer|null $orderItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function fromEprOrderCancellationItemToTransfer(
        FoiErpOrderCancellationItem $orderItem,
        ?ErpOrderCancellationItemTransfer $orderItemTransfer = null
    ): ErpOrderCancellationItemTransfer {
        if ($orderItemTransfer === null) {
            $orderItemTransfer = new ErpOrderCancellationItemTransfer();
        }
        $orderItemTransfer->fromArray($orderItem->toArray(), true);

        return $orderItemTransfer
            ->setCreatedAt($this->convertDateTimeToTimestamp($orderItem->getCreatedAt()))
            ->setUpdatedAt($this->convertDateTimeToTimestamp($orderItem->getUpdatedAt()));
    }

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $erpOrderCancellation
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function fromErpOrderCancellationToTransfer(
        FoiErpOrderCancellation $erpOrderCancellation,
        ?ErpOrderCancellationTransfer $erpOrderCancellationTransfer = null
    ): ErpOrderCancellationTransfer {
        $addEntityItems = false;

        if ($erpOrderCancellationTransfer === null) {
            $erpOrderCancellationTransfer = new ErpOrderCancellationTransfer();
            $addEntityItems = true;
        }

        $erpOrderCancellationTransfer->fromArray($erpOrderCancellation->toArray(), true);

        if ($addEntityItems) {
            foreach ($erpOrderCancellation->getFoiErpOrderCancellationItems() as $erpOrderCancellationItem) {
                $erpOrderCancellationTransfer->addCancellationItem($this->fromEprOrderCancellationItemToTransfer($erpOrderCancellationItem));
            }
        }

        $customer = $erpOrderCancellation->getSpyCustomerRelatedByFkCustomerRequested();
        if ($customer !== null) {
            $erpOrderCancellationTransfer->setCustomer((new CustomerTransfer())->fromArray($customer->toArray(), true));
        }

        $internalCustomer = $erpOrderCancellation->getSpyCustomerRelatedByFkCustomerInternal();
        if ($internalCustomer !== null) {
            $erpOrderCancellationTransfer->setCustomerInternal((new CustomerTransfer())->fromArray($internalCustomer->toArray(), true));
        }

        return $erpOrderCancellationTransfer
            ->setCreatedAt($this->convertDateTimeToTimestamp($erpOrderCancellation->getCreatedAt()))
            ->setUpdatedAt($this->convertDateTimeToTimestamp($erpOrderCancellation->getUpdatedAt()));
    }

    /**
     * @param mixed $dateTime
     *
     * @throws \Exception
     *
     * @return int|null
     */
    protected function convertDateTimeToTimestamp($dateTime): ?int
    {
        if ($dateTime === null) {
            return null;
        }

        if ($dateTime instanceof DateTime) {
            return $dateTime->getTimestamp();
        }

        if (is_object($dateTime) === false && is_string($dateTime) === true) {
            return strtotime($dateTime);
        }

        throw new Exception('Could not convert DateTime to timestamp');
    }
}
