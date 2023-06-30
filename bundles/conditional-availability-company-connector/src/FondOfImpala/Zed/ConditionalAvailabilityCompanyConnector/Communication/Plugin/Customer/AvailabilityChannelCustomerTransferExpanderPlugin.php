<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Business\ConditionalAvailabilityCompanyConnectorFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\ConditionalAvailabilityCompanyConnectorConfig getConfig()()
 */
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
        $defaultAvailabilityChannel = $this->getConfig()->getDefaultAvailabilityChannel();
        $companyUserTransfer = $customerTransfer->getCompanyUserTransfer();

        if ($companyUserTransfer === null) {
            return $customerTransfer->setAvailabilityChannel($defaultAvailabilityChannel);
        }

        $companyTransfer = $companyUserTransfer->getCompany();

        if ($companyTransfer === null) {
            return $customerTransfer->setAvailabilityChannel($defaultAvailabilityChannel);
        }

        $availabilityChannel = ($companyTransfer->getAvailabilityChannel())
            ? $companyTransfer->getAvailabilityChannel()
            : $defaultAvailabilityChannel;

        return $customerTransfer->setAvailabilityChannel($availabilityChannel);
    }
}
