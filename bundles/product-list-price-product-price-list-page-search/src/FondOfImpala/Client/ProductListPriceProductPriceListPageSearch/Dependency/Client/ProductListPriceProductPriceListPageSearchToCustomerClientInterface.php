<?php

namespace FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;

interface ProductListPriceProductPriceListPageSearchToCustomerClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer(): ?CustomerTransfer;
}
