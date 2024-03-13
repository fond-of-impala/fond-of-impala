<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;

interface PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCustomerClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer(): ?CustomerTransfer;
}
