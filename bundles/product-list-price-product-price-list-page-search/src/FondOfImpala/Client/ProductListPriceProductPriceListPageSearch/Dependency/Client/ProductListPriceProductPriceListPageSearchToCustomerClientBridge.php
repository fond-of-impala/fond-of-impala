<?php

namespace FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClientInterface;

class ProductListPriceProductPriceListPageSearchToCustomerClientBridge implements
    ProductListPriceProductPriceListPageSearchToCustomerClientInterface
{
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
