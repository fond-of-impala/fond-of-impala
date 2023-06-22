<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;

interface ConditionalAvailabilityPageSearchToCustomerClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer(): ?CustomerTransfer;
}
