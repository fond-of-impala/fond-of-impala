<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Deleter;

use FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\DeleteCompanyUserPermissionPlugin;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;

class CompanyUserDeleter implements CompanyUserDeleterInterface
{
    protected CompanyUserReaderInterface $companyUserReader;

    protected CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade;

    protected CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade;

    protected CompanyUserPluginExecutorInterface $pluginExecutor;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface $pluginExecutor
     */
    public function __construct(
        CompanyUserReaderInterface $companyUserReader,
        CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade,
        CompanyUserPluginExecutorInterface $pluginExecutor
    ) {
        $this->companyUserReader = $companyUserReader;
        $this->companyUserFacade = $companyUserFacade;
        $this->permissionFacade = $permissionFacade;
        $this->pluginExecutor = $pluginExecutor;
    }

    /**
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer
     */
    public function deleteByRestDeleteCompanyUserRequest(
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): RestDeleteCompanyUserResponseTransfer {
        $restDeleteCompanyUserResponseTransfer = (new RestDeleteCompanyUserResponseTransfer())
            ->setIsSuccess(false);

        $companyUserTransfer = $this->companyUserReader->getCurrentByRestDeleteCompanyUserRequest(
            $restDeleteCompanyUserRequestTransfer,
        );

        if (
            $companyUserTransfer === null
            || !$this->permissionFacade->can(DeleteCompanyUserPermissionPlugin::KEY, $companyUserTransfer->getIdCompanyUser())
        ) {
            return $restDeleteCompanyUserResponseTransfer;
        }

        $companyUserTransfer = $this->companyUserReader->getDeletableByRestDeleteCompanyUserRequest(
            $restDeleteCompanyUserRequestTransfer,
        );

        if ($companyUserTransfer === null || $this->pluginExecutor->executePreDeleteValidationPlugins($companyUserTransfer, $restDeleteCompanyUserRequestTransfer) === false) {
            return $restDeleteCompanyUserResponseTransfer;
        }

        $companyUserResponseTransfer = $this->companyUserFacade->deleteCompanyUser($companyUserTransfer);

        return $restDeleteCompanyUserResponseTransfer->setIsSuccess($companyUserResponseTransfer->getIsSuccessful());
    }
}
