<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Dependency\Plugin\CustomerAnonymizerPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorFacadeInterface getFacade()
 */
class CompanyUserDeleterBeforeCustomerAnonymizerPlugin extends AbstractPlugin implements CustomerAnonymizerPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function process(CustomerTransfer $customerTransfer): void
    {
        $this->getFacade()->deleteCompanyUsersForCustomer($customerTransfer);
    }
}
