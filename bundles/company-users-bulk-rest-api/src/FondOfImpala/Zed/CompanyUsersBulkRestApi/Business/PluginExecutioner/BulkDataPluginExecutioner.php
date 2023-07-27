<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\PluginExecutioner;

use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;

class BulkDataPluginExecutioner implements BulkDataPluginExecutionerInterface
{
    /**
     * @var array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataExpanderPluginInterface>
     */
    protected array $expanderPlugins;

    /**
     * @var array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataPostExpanderPluginInterface>
     */
    protected array $postExpanderPlugins;

    /**
     * @var array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkPreHandlingPluginInterface>
     */
    protected array $preHandlingPlugins;

    /**
     * @var array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkPostHandlingPluginInterface>
     */
    protected array $postHandlingPlugins;

    /**
     * @param array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataExpanderPluginInterface> $expanderPlugins
     * @param array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataPostExpanderPluginInterface> $postExpanderPlugins
     * @param array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkPreHandlingPluginInterface> $preHandlingPlugins
     * @param array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkPostHandlingPluginInterface> $postHandlingPlugins
     */
    public function __construct(
        array $expanderPlugins,
        array $postExpanderPlugins,
        array $preHandlingPlugins,
        array $postHandlingPlugins
    ) {
        $this->expanderPlugins = $expanderPlugins;
        $this->postExpanderPlugins = $postExpanderPlugins;
        $this->preHandlingPlugins = $preHandlingPlugins;
        $this->postHandlingPlugins = $postHandlingPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function executeExpand(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        foreach ($this->expanderPlugins as $plugin) {
            $companyUsersBulkPreparationCollectionTransfer = $plugin->expand($companyUsersBulkPreparationCollectionTransfer);
        }

        return $this->executePostExpand($companyUsersBulkPreparationCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    protected function executePostExpand(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        foreach ($this->postExpanderPlugins as $plugin) {
            $companyUsersBulkPreparationCollectionTransfer = $plugin->postExpand($companyUsersBulkPreparationCollectionTransfer);
        }

        return $companyUsersBulkPreparationCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer
     */
    public function executePreHandlePlugins(RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer): RestCompanyUsersBulkRequestTransfer
    {
        foreach ($this->preHandlingPlugins as $plugin) {
            $restCompanyUsersBulkRequestTransfer = $plugin->preHandling($restCompanyUsersBulkRequestTransfer);
        }

        return $restCompanyUsersBulkRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer $restCompanyUsersBulkResponseTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    public function executePostHandlePlugins(RestCompanyUsersBulkResponseTransfer $restCompanyUsersBulkResponseTransfer): RestCompanyUsersBulkResponseTransfer
    {
        foreach ($this->postHandlingPlugins as $plugin) {
            $restCompanyUsersBulkResponseTransfer = $plugin->postHandling($restCompanyUsersBulkResponseTransfer);
        }

        return $restCompanyUsersBulkResponseTransfer;
    }
}
