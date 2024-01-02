<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Updater;

use FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\UpdateCompanyUserPermissionPlugin;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;

class CompanyUserUpdater implements CompanyUserUpdaterInterface
{
    protected CompanyUserReaderInterface $companyUserReader;

    protected CompanyRoleCollectionReaderInterface $companyRoleCollectionReader;

    protected CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade;

    protected CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade;

    protected CompanyUserPluginExecutorInterface $pluginExecutor;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface $companyRoleCollectionReader
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface $pluginExecutor
     */
    public function __construct(
        CompanyUserReaderInterface $companyUserReader,
        CompanyRoleCollectionReaderInterface $companyRoleCollectionReader,
        CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade,
        CompanyUserPluginExecutorInterface $pluginExecutor
    ) {
        $this->companyUserReader = $companyUserReader;
        $this->companyRoleCollectionReader = $companyRoleCollectionReader;
        $this->companyUserFacade = $companyUserFacade;
        $this->permissionFacade = $permissionFacade;
        $this->pluginExecutor = $pluginExecutor;
    }

    /**
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer
     */
    public function updateByRestWriteCompanyUserRequest(
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): RestWriteCompanyUserResponseTransfer {
        $restWriteCompanyUserResponseTransfer = (new RestWriteCompanyUserResponseTransfer())
            ->setIsSuccess(false);

        $companyUserTransfer = $this->companyUserReader->getCurrentByRestWriteCompanyUserRequest(
            $restWriteCompanyUserRequestTransfer,
        );

        if (
            $companyUserTransfer === null
            || !$this->permissionFacade->can(UpdateCompanyUserPermissionPlugin::KEY, $companyUserTransfer->getIdCompanyUser())
        ) {
            return $restWriteCompanyUserResponseTransfer;
        }

        $companyUserTransfer = $this->companyUserReader->getWriteableByRestWriteCompanyUserRequest(
            $restWriteCompanyUserRequestTransfer,
        );

        if ($companyUserTransfer === null) {
            return $restWriteCompanyUserResponseTransfer;
        }

        $companyRoleCollectionTransfer = $this->companyRoleCollectionReader->getByRestWriteCompanyUserRequest(
            $restWriteCompanyUserRequestTransfer,
        );

        $companyUserTransfer = $companyUserTransfer->setCompanyRoleCollection($companyRoleCollectionTransfer);
        $companyUserTransfer = $companyUserTransfer->setCustomer(
            (new CustomerTransfer())->setIdCustomer($companyUserTransfer->getFkCustomer()),
        );

        if (!$this->pluginExecutor->executePreUpdateValidationPlugins($companyUserTransfer, $restWriteCompanyUserRequestTransfer)) {
            return $restWriteCompanyUserResponseTransfer;
        }

        $companyUserResponseTransfer = $this->companyUserFacade->update($companyUserTransfer);
        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || !$companyUserResponseTransfer->getIsSuccessful()) {
            return $restWriteCompanyUserResponseTransfer;
        }

        return $restWriteCompanyUserResponseTransfer->setIsSuccess(true)
            ->setCompanyUser($companyUserTransfer);
    }
}
