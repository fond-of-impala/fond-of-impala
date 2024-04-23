<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business;

use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyReader;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyReaderInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeBlacklistValidator;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeBlacklistValidatorInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverter;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterPluginExecutor;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterPluginExecutorInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeRoleWriter;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeRoleWriterInterface;
use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterDependencyProvider;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig getConfig()
 */
class CompanyTypeConverterBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterInterface
     */
    public function createCompanyTypeConverter(): CompanyTypeConverterInterface
    {
        return new CompanyTypeConverter(
            $this->getCompanyTypeFacade(),
            $this->getCompanyRoleFacade(),
            $this->getCompanyUserFacade(),
            $this->createCompanyTypeRoleWriter(),
            $this->getConfig(),
            $this->createPluginExecutor(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeRoleWriterInterface
     */
    protected function createCompanyTypeRoleWriter(): CompanyTypeRoleWriterInterface
    {
        return new CompanyTypeRoleWriter(
            $this->getCompanyRoleFacade(),
            $this->getCompanyTypeFacade(),
            $this->getCompanyTypeRoleFacade(),
            $this->getPermissionFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyReaderInterface
     */
    public function createCompanyReader(): CompanyReaderInterface
    {
        return new CompanyReader(
            $this->getCompanyFacade(),
            $this->getCompanyTypeFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeBlacklistValidatorInterface
     */
    public function createCompanyTypeBlacklistValidator(): CompanyTypeBlacklistValidatorInterface
    {
        return new CompanyTypeBlacklistValidator(
            $this->getCompanyTypeFacade(),
            $this->getConfig(),
            $this->getLogger(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterPluginExecutorInterface
     */
    protected function createPluginExecutor(): CompanyTypeConverterPluginExecutorInterface
    {
        return new CompanyTypeConverterPluginExecutor(
            $this->getCompanyTypeConverterPreSavePlugins(),
            $this->getCompanyTypeConverterPostSavePlugins(),
        );
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin\CompanyTypeConverterPreSavePluginInterface>
     */
    protected function getCompanyTypeConverterPreSavePlugins(): array
    {
        return $this->getProvidedDependency(CompanyTypeConverterDependencyProvider::COMPANY_TYPE_CONVERTER_PRE_SAVE_PLUGINS);
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin\CompanyTypeConverterPostSavePluginInterface>
     */
    protected function getCompanyTypeConverterPostSavePlugins(): array
    {
        return $this->getProvidedDependency(CompanyTypeConverterDependencyProvider::COMPANY_TYPE_CONVERTER_POST_SAVE_PLUGINS);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyTypeConverterToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeConverterDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyTypeConverterToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeConverterDependencyProvider::FACADE_PERMISSION);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyTypeConverterToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeConverterDependencyProvider::FACADE_COMPANY_ROLE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyTypeConverterToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeConverterDependencyProvider::FACADE_COMPANY_USER);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface
     */
    protected function getCompanyTypeFacade(): CompanyTypeConverterToCompanyTypeFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeConverterDependencyProvider::FACADE_COMPANY_TYPE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeInterface
     */
    protected function getCompanyTypeRoleFacade(): CompanyTypeConverterToCompanyTypeRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeConverterDependencyProvider::FACADE_COMPANY_TYPE_ROLE);
    }
}
