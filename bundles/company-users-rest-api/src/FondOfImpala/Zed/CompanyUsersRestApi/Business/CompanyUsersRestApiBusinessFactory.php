<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business;

use FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleter;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleterInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGenerator;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGenerator;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGenerator;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapper;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapper;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReader;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReader;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CustomerReader;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CustomerReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Updater\CompanyUserUpdater;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Updater\CompanyUserUpdaterInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\RestApiError;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriter;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriterInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface getRepository()
 */
class CompanyUsersRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface
     */
    public function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getCompanyUserReferenceFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleterInterface
     */
    public function createCompanyUserDeleter(): CompanyUserDeleterInterface
    {
        return new CompanyUserDeleter(
            $this->createCompanyUserReader(),
            $this->getCompanyUserFacade(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface
     */
    public function createCompanyUserWriter(): CompanyUserWriterInterface
    {
        return new CompanyUserWriter(
            $this->createCustomerReader(),
            $this->createCustomerWriter(),
            $this->getCompanyFacade(),
            $this->getCompanyBusinessUnitFacade(),
            $this->getCompanyUserFacade(),
            $this->createCompanyUserMapper(),
            $this->createRestApiError(),
            $this->createCompanyUserReader(),
            $this->getConfig(),
            $this->getPermissionFacade(),
            $this->createCompanyUserPluginExecutor(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface
     */
    protected function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface
     */
    protected function createCustomerMapper(): CustomerMapperInterface
    {
        return new CustomerMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CustomerReaderInterface
     */
    protected function createCustomerReader(): CustomerReaderInterface
    {
        return new CustomerReader(
            $this->createCustomerMapper(),
            $this->getCustomerFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriterInterface
     */
    protected function createCustomerWriter(): CustomerWriterInterface
    {
        return new CustomerWriter(
            $this->createCustomerMapper(),
            $this->createRandomPasswordGenerator(),
            $this->createRestorePasswordKeyGenerator(),
            $this->createRestorePasswordLinkGenerator(),
            $this->getCustomerFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface
     */
    protected function createRandomPasswordGenerator(): RandomPasswordGeneratorInterface
    {
        return new RandomPasswordGenerator($this->getUtilTextService());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface
     */
    protected function getUtilTextService(): CompanyUsersRestApiToUtilTextServiceInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::SERVICE_UTIL_TEXT);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface
     */
    protected function createRestorePasswordKeyGenerator(): RestorePasswordKeyGeneratorInterface
    {
        return new RestorePasswordKeyGenerator($this->getUtilTextService());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface
     */
    protected function createRestorePasswordLinkGenerator(): RestorePasswordLinkGeneratorInterface
    {
        return new RestorePasswordLinkGenerator($this->getConfig());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyUsersRestApiToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyUsersRestApiToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected function getCustomerFacade(): CompanyUsersRestApiToCustomerFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_CUSTOMER);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyUsersRestApiToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_PERMISSION);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
     */
    protected function getCompanyUserReferenceFacade(): CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface
     */
    protected function createCompanyUserPluginExecutor(): CompanyUserPluginExecutorInterface
    {
        return new CompanyUserPluginExecutor(
            $this->getCompanyUserPreCreatePlugins(),
            $this->getCompanyUserPostCreatePlugins(),
        );
    }

    /**
     * @return array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface>
     */
    protected function getCompanyUserPostCreatePlugins(): array
    {
        return $this->getProvidedDependency(
            CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_POST_CREATE,
        );
    }

    /**
     * @return array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreCreatePluginInterface>
     */
    protected function getCompanyUserPreCreatePlugins(): array
    {
        return $this->getProvidedDependency(
            CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_PRE_CREATE,
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Updater\CompanyUserUpdaterInterface
     */
    public function createCompanyUserUpdater(): CompanyUserUpdaterInterface
    {
        return new CompanyUserUpdater(
            $this->createCompanyUserReader(),
            $this->createCompanyRoleCollectionReader(),
            $this->getCompanyUserFacade(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface
     */
    protected function createCompanyRoleCollectionReader(): CompanyRoleCollectionReaderInterface
    {
        return new CompanyRoleCollectionReader($this->getCompanyRoleFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyUsersRestApiToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_ROLE);
    }
}
