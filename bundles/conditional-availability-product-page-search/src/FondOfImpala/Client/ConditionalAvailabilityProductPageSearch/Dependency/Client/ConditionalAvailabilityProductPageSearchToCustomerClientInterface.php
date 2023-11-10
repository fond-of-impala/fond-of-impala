<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;

interface ConditionalAvailabilityProductPageSearchToCustomerClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer(): ?CustomerTransfer;
}
