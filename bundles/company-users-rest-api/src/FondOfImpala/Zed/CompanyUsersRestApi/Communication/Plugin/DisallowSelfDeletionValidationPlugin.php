<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin;

use FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreDeleteValidationPluginInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface getFacade()
 */
class DisallowSelfDeletionValidationPlugin extends AbstractPlugin implements CompanyUserPreDeleteValidationPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return bool
     */
    public function validate(
        CompanyUserTransfer $companyUserTransfer,
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): bool {
        return $this->getFacade()->canDeleteCompanyUser($companyUserTransfer, $restDeleteCompanyUserRequestTransfer);
    }
}
