<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader;

use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Persistence\ConditionalAvailabilityCheckoutConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CustomerReader implements CustomerReaderInterface
{
    protected ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface $customerFacade;

    protected ConditionalAvailabilityCheckoutConnectorRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface $customerFacade
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Persistence\ConditionalAvailabilityCheckoutConnectorRepositoryInterface $repository
     */
    public function __construct(
        ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface $customerFacade,
        ConditionalAvailabilityCheckoutConnectorRepositoryInterface $repository
    ) {
        $this->customerFacade = $customerFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getByQuote(QuoteTransfer $quoteTransfer): ?CustomerTransfer
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
