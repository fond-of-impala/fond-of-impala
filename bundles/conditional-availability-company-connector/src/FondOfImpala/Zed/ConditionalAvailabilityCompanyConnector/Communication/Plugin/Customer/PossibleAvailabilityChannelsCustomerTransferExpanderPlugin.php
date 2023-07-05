<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Persistence\ConditionalAvailabilityCompanyConnectorRepositoryInterface getRepository()
 */
class PossibleAvailabilityChannelsCustomerTransferExpanderPlugin extends AbstractPlugin implements CustomerTransferExpanderPluginInterface
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
        $idCustomer = $customerTransfer->getIdCustomer();

        if ($customerTransfer->getIdCustomer() === null) {
            return $customerTransfer;
        }

        $possibleAvailabilityChannels = $this->getRepository()
            ->getPossibleAvailabilityChannelsByIdCustomer($idCustomer);

        return $customerTransfer->setPossibleAvailabilityChannels($possibleAvailabilityChannels);
    }
}
