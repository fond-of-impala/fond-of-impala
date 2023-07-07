<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class AvailabilityChannelCustomerTransferExpanderPlugin extends AbstractPlugin implements CustomerTransferExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function expandTransfer(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        $companyUserTransfer = $customerTransfer->getCompanyUserTransfer();

        if ($companyUserTransfer === null) {
            return $customerTransfer->setAvailabilityChannel(null);
        }

        $companyTransfer = $companyUserTransfer->getCompany();

        if ($companyTransfer === null) {
            return $customerTransfer->setAvailabilityChannel(null);
        }

        return $customerTransfer->setAvailabilityChannel($companyTransfer->getAvailabilityChannel());
    }
}
