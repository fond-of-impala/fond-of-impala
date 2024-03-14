<?php

namespace FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;

interface CompanyCurrencyPriceProductPriceListSearchRestApiToCustomerClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer(): ?CustomerTransfer;
}
