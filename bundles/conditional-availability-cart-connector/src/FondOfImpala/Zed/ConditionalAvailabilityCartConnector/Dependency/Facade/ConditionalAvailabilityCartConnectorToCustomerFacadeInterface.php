<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;

interface ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomer(CustomerTransfer $customerTransfer): CustomerTransfer;
}
