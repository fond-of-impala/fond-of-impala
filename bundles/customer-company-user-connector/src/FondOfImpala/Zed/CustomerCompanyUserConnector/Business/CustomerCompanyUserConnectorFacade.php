<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CustomerCompanyUserConnector\Business\CustomerCompanyUserConnectorBusinessFactory getFactory()
 */
class CustomerCompanyUserConnectorFacade extends AbstractFacade implements CustomerCompanyUserConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteCompanyUserForCustomer(CustomerTransfer $customerTransfer): void
    {
        $this->getFactory()->createCompanyUserDeleter()->deleteCompanyUserForCustomer($customerTransfer);
    }
}
