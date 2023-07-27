<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CompanyBusinessUnitToCompanyTransferExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CompanyExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CompanyRolesToCompanyTransferExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CustomerByMailExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CustomerByReferenceExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\ExpanderInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager\BulkManager;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager\BulkManagerInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Permission\PermissionChecker;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Permission\PermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\PluginExecutioner\BulkDataPluginExecutioner;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\PluginExecutioner\BulkDataPluginExecutionerInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface getRepository()
 */
class CompanyUsersBulkRestApiBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager\BulkManagerInterface
     */
    public function createBulkManager(): BulkManagerInterface
    {
        return new BulkManager(
            $this->createPermissionChecker(),
            $this->getEventFacade(),
            $this->getCompanyUserFacade(),
            $this->createBulkDataPluginExecutioner(),
            $this->getRepository(),
            $this->getLogger(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\ExpanderInterface
     */
    public function createCompanyExpander(): ExpanderInterface
    {
        return new CompanyExpander($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\ExpanderInterface
     */
    public function createCustomerByMailExpander(): ExpanderInterface
    {
        return new CustomerByMailExpander($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\ExpanderInterface
     */
    public function createCustomerByReferenceExpander(): ExpanderInterface
    {
        return new CustomerByReferenceExpander($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\ExpanderInterface
     */
    public function createCompanyBusinessUnitToCompanyTransferExpander(): ExpanderInterface
    {
        return new CompanyBusinessUnitToCompanyTransferExpander($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\ExpanderInterface
     */
    public function createCompanyRolesToCompanyTransferExpander(): ExpanderInterface
    {
        return new CompanyRolesToCompanyTransferExpander($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Permission\PermissionCheckerInterface
     */
    protected function createPermissionChecker(): PermissionCheckerInterface
    {
        return new PermissionChecker($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\PluginExecutioner\BulkDataPluginExecutionerInterface
     */
    protected function createBulkDataPluginExecutioner(): BulkDataPluginExecutionerInterface
    {
        return new BulkDataPluginExecutioner(
            $this->getDataExpanderPlugins(),
            $this->getDataPostExpanderPlugins(),
            $this->getPreHandlingPlugins(),
            $this->getPostHandlingPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface
     */
    protected function getEventFacade(): CompanyUsersBulkRestApiToEventFacadeInterface
    {
        return $this->getProvidedDependency(
            CompanyUsersBulkRestApiDependencyProvider::FACADE_EVENT,
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyUsersBulkRestApiToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(
            CompanyUsersBulkRestApiDependencyProvider::FACADE_COMPANY_USER,
        );
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataExpanderPluginInterface>
     */
    protected function getDataExpanderPlugins(): array
    {
        return $this->getProvidedDependency(
            CompanyUsersBulkRestApiDependencyProvider::PLUGINS_DATA_EXPANDER,
        );
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataPostExpanderPluginInterface>
     */
    protected function getDataPostExpanderPlugins(): array
    {
        return $this->getProvidedDependency(
            CompanyUsersBulkRestApiDependencyProvider::PLUGINS_DATA_POST_EXPANDER,
        );
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkPreHandlingPluginInterface>
     */
    protected function getPreHandlingPlugins(): array
    {
        return $this->getProvidedDependency(
            CompanyUsersBulkRestApiDependencyProvider::PLUGINS_PRE_HANDLING,
        );
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkPostHandlingPluginInterface>
     */
    protected function getPostHandlingPlugins(): array
    {
        return $this->getProvidedDependency(
            CompanyUsersBulkRestApiDependencyProvider::PLUGINS_POST_HANDLING,
        );
    }
}
