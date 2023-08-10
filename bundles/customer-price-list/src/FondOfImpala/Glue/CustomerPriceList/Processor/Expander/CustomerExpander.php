<?php

namespace FondOfImpala\Glue\CustomerPriceList\Processor\Expander;

use FondOfImpala\Client\CustomerPriceList\CustomerPriceListClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class CustomerExpander implements CustomerExpanderInterface
{
    protected CustomerPriceListClientInterface $customerPriceListClient;

    /**
     * @param \FondOfImpala\Client\CustomerPriceList\CustomerPriceListClientInterface $customerPriceListClient
     */
    public function __construct(CustomerPriceListClientInterface $customerPriceListClient)
    {
        $this->customerPriceListClient = $customerPriceListClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function expand(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        return $this->customerPriceListClient->expandCustomer($customerTransfer);
    }
}
