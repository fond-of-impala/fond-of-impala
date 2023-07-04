<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader;

use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CustomerReader implements CustomerReaderInterface
{
    protected ConditionalAvailabilityCartConnectorToCustomerFacadeInterface $customerFacade;

    protected ConditionalAvailabilityCartConnectorRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface $customerFacade
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface $repository
     */
    public function __construct(
        ConditionalAvailabilityCartConnectorToCustomerFacadeInterface $customerFacade,
        ConditionalAvailabilityCartConnectorRepositoryInterface $repository
    ) {
        $this->customerFacade = $customerFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getByQuoteTransfer(QuoteTransfer $quoteTransfer): ?CustomerTransfer
    {
        if ($quoteTransfer->getCustomer() !== null) {
            return $quoteTransfer->getCustomer();
        }

        $customerReference = $quoteTransfer->getCustomerReference();

        if ($customerReference === null) {
            return null;
        }

        $idCustomer = $this->repository->getIdCustomerByCustomerReference($customerReference);

        if ($idCustomer === null) {
            return null;
        }

        $customerTransfer = (new CustomerTransfer())->setIdCustomer($idCustomer);

        return $this->customerFacade->getCustomer($customerTransfer);
    }
}
