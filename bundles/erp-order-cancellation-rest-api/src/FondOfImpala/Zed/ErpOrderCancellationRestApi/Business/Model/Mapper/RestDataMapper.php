<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationTransfer;

class RestDataMapper implements RestDataMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationTransfer
     */
    public function mapResponse(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): RestErpOrderCancellationTransfer
    {
        return (new RestErpOrderCancellationTransfer())
            ->fromArray($erpOrderCancellationTransfer->toArray(), true)
            ->setCustomer($this->mapRestCustomer($erpOrderCancellationTransfer->getCustomer()))
            ->setInternalCustomer($this->mapRestCustomer($erpOrderCancellationTransfer->getCustomerInternal()));
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer $erpOrderCancellationCollectionTransfer
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestErpOrderCancellationTransfer>
     */
    public function mapResponseCollection(ErpOrderCancellationCollectionTransfer $erpOrderCancellationCollectionTransfer): ArrayObject
    {
        $restResponseCollection = new ArrayObject();

        foreach ($erpOrderCancellationCollectionTransfer->getErpOrderCancellations() as $erpOrderCancellation) {
            $restResponseCollection->append($this->mapResponse($erpOrderCancellation));
        }

        return $restResponseCollection;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customerTransfer
     *
     * @return \Generated\Shared\Transfer\RestCustomerTransfer|null
     */
    protected function mapRestCustomer(?CustomerTransfer $customerTransfer): ?RestCustomerTransfer
    {
        if ($customerTransfer === null) {
            return null;
        }

        return (new RestCustomerTransfer())
            ->fromArray($customerTransfer->toArray(), true);
    }
}
