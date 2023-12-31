<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class ConditionalAvailabilityCartConnectorToCustomerFacadeBridge implements ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
{
    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected CustomerFacadeInterface $customerFacade;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     */
    public function __construct(CustomerFacadeInterface $customerFacade)
    {
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomer(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        return $this->customerFacade->getCustomer($customerTransfer);
    }
}
