<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper;

use ArrayObject;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander\ErpOrderCancellationExpanderInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestCancellationItemTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationTransfer;

class RestDataMapper implements RestDataMapperInterface
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander\ErpOrderCancellationExpanderInterface
     */
    protected ErpOrderCancellationExpanderInterface $erpOrderCancellationExpander;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander\ErpOrderCancellationExpanderInterface $erpOrderCancellationExpander
     */
    public function __construct(ErpOrderCancellationExpanderInterface $erpOrderCancellationExpander)
    {
        $this->erpOrderCancellationExpander = $erpOrderCancellationExpander;
    }

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
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function mapFromRequest(RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer): ErpOrderCancellationTransfer
    {
        $attributes = $restErpOrderCancellationRequestTransfer->getAttributes();

        $erpOrderCancellationTransfer = (new ErpOrderCancellationTransfer())
            ->fromArray($attributes->modifiedToArray(), true);

        $erpOrderCancellationTransfer->setCancellationItems(
            $this->mapItemsFromRequest($attributes->getCancellationItems()),
        );

        return $this->erpOrderCancellationExpander->expand($erpOrderCancellationTransfer, $restErpOrderCancellationRequestTransfer);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestCancellationItemTransfer> $restItemCollection
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer>
     */
    public function mapItemsFromRequest(ArrayObject $restItemCollection): ArrayObject
    {
        $collection = new ArrayObject();

        foreach ($restItemCollection as $restCancellationItemTransfer) {
            $collection->append($this->mapItemFromItemRequest($restCancellationItemTransfer));
        }

        return $collection;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCancellationItemTransfer $restCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function mapItemFromItemRequest(RestCancellationItemTransfer $restCancellationItemTransfer): ErpOrderCancellationItemTransfer
    {
        return (new ErpOrderCancellationItemTransfer())
            ->fromArray($restCancellationItemTransfer->modifiedToArray(), true);
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
