<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business;

use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorBusinessFactory getFactory()
 */
class CustomerAnonymizerCompanyUserConnectorFacade extends AbstractFacade implements CustomerAnonymizerCompanyUserConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteCompanyUsersForCustomer(CustomerTransfer $customerTransfer): void
    {
        $this->getFactory()->createCompanyUserDeleter()->deleteByCustomer($customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer $idCollectionTransfer
     *
     * @return void
     */
    public function deleteCompanyUserByIds(CompanyUserIdCollectionTransfer $idCollectionTransfer): void
    {
        $this->getFactory()->createCompanyUserDeleter()->deleteCompanyUserByIds($idCollectionTransfer);
    }
}
