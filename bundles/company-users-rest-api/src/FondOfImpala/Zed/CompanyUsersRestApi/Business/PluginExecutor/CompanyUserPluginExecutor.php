<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;

class CompanyUserPluginExecutor implements CompanyUserPluginExecutorInterface
{
    /**
     * @var array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface>
     */
    protected $companyUserPostCreatePlugins;

    /**
     * @var array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreCreatePluginInterface>
     */
    protected $companyUserPreCreatePlugins;

    /**
     * @var array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreDeleteValidationPluginInterface>
     */
    protected $companyUserPreDeletePlugins;

    /**
     * @var array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreUpdateValidationPluginInterface>
     */
    protected $companyUserPreUpdatePlugins;

    /**
     * @param array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreCreatePluginInterface> $companyUserPreCreatePlugins
     * @param array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface> $companyUserPostCreatePlugins
     * @param array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreDeleteValidationPluginInterface> $companyUserPreDeletePlugins
     * @param array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreUpdateValidationPluginInterface> $companyUserPreUpdatePlugins
     */
    public function __construct(
        array $companyUserPreCreatePlugins,
        array $companyUserPostCreatePlugins,
        array $companyUserPreDeletePlugins,
        array $companyUserPreUpdatePlugins
    ) {
        $this->companyUserPreCreatePlugins = $companyUserPreCreatePlugins;
        $this->companyUserPostCreatePlugins = $companyUserPostCreatePlugins;
        $this->companyUserPreDeletePlugins = $companyUserPreDeletePlugins;
        $this->companyUserPreUpdatePlugins = $companyUserPreUpdatePlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function executePostCreatePlugins(
        CompanyUserTransfer $companyUserTransfer,
        RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
    ): CompanyUserTransfer {
        foreach ($this->companyUserPostCreatePlugins as $plugin) {
            $companyUserTransfer = $plugin->postCreate($companyUserTransfer, $companyUsersRequestAttributesTransfer);
        }

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function executePreCreatePlugins(
        CompanyUserTransfer $companyUserTransfer,
        RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
    ): CompanyUserTransfer {
        foreach ($this->companyUserPreCreatePlugins as $plugin) {
            $companyUserTransfer = $plugin->preCreate($companyUserTransfer, $companyUsersRequestAttributesTransfer);
        }

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return bool
     */
    public function executePreDeleteValidationPlugins(
        CompanyUserTransfer $companyUserTransfer,
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): bool {
        foreach ($this->companyUserPreDeletePlugins as $plugin) {
            $state = $plugin->validate($companyUserTransfer, $restDeleteCompanyUserRequestTransfer);
            if ($state === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return bool
     */
    public function executePreUpdateValidationPlugins(
        CompanyUserTransfer $companyUserTransfer,
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): bool {
        foreach ($this->companyUserPreUpdatePlugins as $plugin) {
            $state = $plugin->validate($companyUserTransfer, $restWriteCompanyUserRequestTransfer);
            if ($state === false) {
                return false;
            }
        }

        return true;
    }
}
