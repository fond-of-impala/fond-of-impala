<?php

namespace FondOfImpala\Glue\WebUiSettings\Dependency\Client;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClientInterface;

class WebUiSettingsToCustomerClientBridge implements WebUiSettingsToCustomerClientInterface
{
    protected CustomerClientInterface $client;

    /**
     * @param \Spryker\Client\Customer\CustomerClientInterface $client
     */
    public function __construct(CustomerClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function updateCustomer(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        return $this->client->updateCustomer($customerTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomer(): CustomerTransfer
    {
        return $this->client->getCustomer();
    }
}
