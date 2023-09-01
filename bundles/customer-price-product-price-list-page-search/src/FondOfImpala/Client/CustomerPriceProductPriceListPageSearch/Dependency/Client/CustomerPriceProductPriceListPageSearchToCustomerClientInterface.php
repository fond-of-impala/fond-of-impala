<?php

namespace FondOfImpala\Client\CustomerPriceProductPriceListPageSearch\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerPriceProductPriceListPageSearchToCustomerClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer(): ?CustomerTransfer;
}
