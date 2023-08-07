<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin;

use FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreUpdateValidationPluginInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface getFacade()
 */
class LastAvailableRoleProtectionOnUpdateValidationPlugin extends AbstractPlugin implements CompanyUserPreUpdateValidationPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return bool
     */
    public function validate(
        CompanyUserTransfer $companyUserTransfer,
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): bool {
        return $this->getFacade()->canUpdateCompanyUser($companyUserTransfer, $restWriteCompanyUserRequestTransfer);
    }
}
