<?php

namespace FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClientInterface;

class CompanyCurrencyPriceProductPriceListSearchRestApiToCustomerClientBridge implements CompanyCurrencyPriceProductPriceListSearchRestApiToCustomerClientInterface
{
    /**
     * @var \Spryker\Client\Customer\CustomerClientInterface
     */
    protected CustomerClientInterface $customerClient;

    /**
     * @param \Spryker\Client\Customer\CustomerClientInterface $customerClient
     */
    public function __construct(CustomerClientInterface $customerClient)
    {
        $this->customerClient = $customerClient;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomer(): ?CustomerTransfer
    {
        return $this->customerClient->getCustomer();
    }
}
