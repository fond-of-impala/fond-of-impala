<?php

namespace FondOfImpala\Zed\CompanyTypeConverter;

use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeBridge;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeBridge;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeBridge;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeBridge;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeBridge;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyTypeConverterDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PERMISSION = 'FACADE_PERMISSION';

    /**
     * @var string
     */
    public const FACADE_COMPANY = 'FACADE_COMPANY';

    /**
     * @var string
     */
    public const FACADE_COMPANY_TYPE = 'FACADE_COMPANY_TYPE';

    /**
     * @var string
     */
    public const FACADE_COMPANY_TYPE_ROLE = 'FACADE_COMPANY_TYPE_ROLE';

    /**
     * @var string
     */
    public const FACADE_COMPANY_ROLE = 'FACADE_COMPANY_ROLE';

    /**
     * @var string
     */
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';

    /**
     * @var string
     */
    public const COMPANY_TYPE_CONVERTER_PRE_SAVE_PLUGINS = 'COMPANY_TYPE_CONVERTER_PRE_SAVE_PLUGINS';

    /**
     * @var string
     */
    public const COMPANY_TYPE_CONVERTER_POST_SAVE_PLUGINS = 'COMPANY_TYPE_CONVERTER_POST_SAVE_PLUGINS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addPermissionFacade($container);
        $container = $this->addCompanyFacade($container);
        $container = $this->addCompanyTypeFacade($container);
        $container = $this->addCompanyTypeRoleFacade($container);
        $container = $this->addCompanyRoleFacade($container);
        $container = $this->addCompanyUserFacade($container);
        $container = $this->addCompanyTypeConverterPreSavePlugins($container);
        $container = $this->addCompanyTypeConverterPostSavePlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPermissionFacade(Container $container): Container
    {
        $container[static::FACADE_PERMISSION] = fn (Container $container): CompanyTypeConverterToPermissionFacadeBridge => new CompanyTypeConverterToPermissionFacadeBridge(
            $container->getLocator()->permission()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY] = fn (Container $container): CompanyTypeConverterToCompanyFacadeBridge => new CompanyTypeConverterToCompanyFacadeBridge(
            $container->getLocator()->company()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyTypeRoleFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_TYPE_ROLE] = fn (Container $container): CompanyTypeConverterToCompanyTypeRoleFacadeBridge => new CompanyTypeConverterToCompanyTypeRoleFacadeBridge(
            $container->getLocator()->companyTypeRole()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRoleFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_ROLE] = fn (Container $container): CompanyTypeConverterToCompanyRoleFacadeBridge => new CompanyTypeConverterToCompanyRoleFacadeBridge(
            $container->getLocator()->companyRole()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyTypeFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_TYPE] = fn (Container $container): CompanyTypeConverterToCompanyTypeFacadeBridge => new CompanyTypeConverterToCompanyTypeFacadeBridge(
            $container->getLocator()->companyType()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_USER] = fn (Container $container): CompanyTypeConverterToCompanyUserFacadeBridge => new CompanyTypeConverterToCompanyUserFacadeBridge(
            $container->getLocator()->companyUser()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyTypeConverterPreSavePlugins(Container $container): Container
    {
        $container[static::COMPANY_TYPE_CONVERTER_PRE_SAVE_PLUGINS] = fn (): array => $this->getCompanyTypeConverterPreSavePlugins();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyTypeConverterPostSavePlugins(Container $container): Container
    {
        $container[static::COMPANY_TYPE_CONVERTER_POST_SAVE_PLUGINS] = fn (): array => $this->getCompanyTypeConverterPostSavePlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin\CompanyTypeConverterPreSavePluginInterface>
     */
    protected function getCompanyTypeConverterPreSavePlugins(): array
    {
        return [];
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin\CompanyTypeConverterPostSavePluginInterface>
     */
    protected function getCompanyTypeConverterPostSavePlugins(): array
    {
        return [];
    }
}
