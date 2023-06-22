<?php

namespace FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;

interface ProductListConditionalAvailabilityPageSearchToCustomerClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer(): ?CustomerTransfer;
}
