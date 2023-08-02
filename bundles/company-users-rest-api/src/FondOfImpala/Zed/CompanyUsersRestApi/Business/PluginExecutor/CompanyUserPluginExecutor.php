<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

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
     * @param array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreCreatePluginInterface> $companyUserPreCreatePlugins
     * @param array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface> $companyUserPostCreatePlugins
     */
    public function __construct(
        array $companyUserPreCreatePlugins,
        array $companyUserPostCreatePlugins
    ) {
        $this->companyUserPreCreatePlugins = $companyUserPreCreatePlugins;
        $this->companyUserPostCreatePlugins = $companyUserPostCreatePlugins;
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
}
