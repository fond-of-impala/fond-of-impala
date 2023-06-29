<?php

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;

class CustomerCompanyUserConnectorToCompanyUserFacadeBridge implements CustomerCompanyUserConnectorToCompanyUserFacadeInterface
{
    /**
     * @var \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected CompanyUserFacadeInterface $facade;

    /**
     * @param \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface $facade
     */
    public function __construct(CompanyUserFacadeInterface $facade)
    {
        $this->facade = $facade;
    }

    /**
     * Specification:
     * - Executes CompanyUserPreDeletePluginInterface plugins before delete company user.
     * - Deletes a company user.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function deleteCompanyUser(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        return $this->facade->deleteCompanyUser(
            $companyUserTransfer,
        );
    }
}
