<?php

namespace FondOfImpala\Zed\CompanyTypeRole;

use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeBridge;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeBridge;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeBridge;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeBridge;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeBridge;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPropelFacadeBridge;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class CompanyTypeRoleDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_COMPANY = 'FACADE_COMPANY';

    /**
     * @var string
     */
    public const FACADE_COMPANY_ROLE = 'FACADE_COMPANY_ROLE';

    /**
     * @var string
     */
    public const FACADE_COMPANY_TYPE = 'FACADE_COMPANY_TYPE';

    /**
     * @var string
     */
    public const FACADE_PERMISSION = 'FACADE_PERMISSION';

    /**
     * @var string
     */
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';

    /**
     * @var string
     */
    public const FACADE_PROPEL = 'FACADE_PROPEL';

    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY_USER = 'PROPEL_QUERY_COMPANY_USER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addCompanyFacade($container);
        $container = $this->addCompanyRoleFacade($container);
        $container = $this->addCompanyTypeFacade($container);
        $container = $this->addPermissionFacade($container);

        return $this->addCompanyUserFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY] = static fn (Container $container): CompanyTypeRoleToCompanyFacadeBridge => new CompanyTypeRoleToCompanyFacadeBridge(
            $container->getLocator()->company()->facade(),
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
        $container[static::FACADE_COMPANY_ROLE] = static fn (Container $container): CompanyTypeRoleToCompanyRoleFacadeBridge => new CompanyTypeRoleToCompanyRoleFacadeBridge(
            $container->getLocator()->companyRole()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPermissionFacade(Container $container): Container
    {
        $container[static::FACADE_PERMISSION] = static fn (Container $container): CompanyTypeRoleToPermissionFacadeBridge => new CompanyTypeRoleToPermissionFacadeBridge(
            $container->getLocator()->permission()->facade(),
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
        $container[static::FACADE_COMPANY_TYPE] = static fn (Container $container): CompanyTypeRoleToCompanyTypeFacadeBridge => new CompanyTypeRoleToCompanyTypeFacadeBridge(
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
        $container[static::FACADE_COMPANY_USER] = static fn (Container $container): CompanyTypeRoleToCompanyUserFacadeBridge => new CompanyTypeRoleToCompanyUserFacadeBridge(
            $container->getLocator()->companyUser()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        $container = $this->addCompanyUserQuery($container);

        return $this->addPropelFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY_USER] = static fn (): Criteria => SpyCompanyUserQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPropelFacade(Container $container): Container
    {
        $container[static::FACADE_PROPEL] = static fn (Container $container): CompanyTypeRoleToPropelFacadeBridge => new CompanyTypeRoleToPropelFacadeBridge(
            $container->getLocator()->propel()->facade(),
        );

        return $container;
    }
}
