<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper;

use ArrayObject;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander\ErpOrderCancellationExpanderInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\ErpOrderTransfer;
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
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacade
     */
    protected ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacade;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander\ErpOrderCancellationExpanderInterface $erpOrderCancellationExpander
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacade
     */
    public function __construct(
        ErpOrderCancellationExpanderInterface $erpOrderCancellationExpander,
        ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacade
    ) {
        $this->erpOrderCancellationExpander = $erpOrderCancellationExpander;
        $this->erpOrderFacade = $erpOrderFacade;
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
            ->setInternalCustomer($this->mapRestCustomer($erpOrderCancellationTransfer->getCustomerInternal()))
            ->setErpOrder($this->mapErpOrder($erpOrderCancellationTransfer->getErpOrderExternalReference()));
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

    /**
     * @param string $erpOrderExternalReference
     *
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    protected function mapErpOrder(string $erpOrderExternalReference): ?ErpOrderTransfer
    {
        if ($erpOrderExternalReference === null) {
            return null;
        }

        return $this->erpOrderFacade->findErpOrderByExternalReference($erpOrderExternalReference);
    }
}
