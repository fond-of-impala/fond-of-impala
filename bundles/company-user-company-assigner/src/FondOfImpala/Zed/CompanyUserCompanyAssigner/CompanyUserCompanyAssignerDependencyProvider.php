<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeBridge;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeBridge;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeBridge;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeBridge;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeBridge;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\CompanyType\Persistence\Base\FoiCompanyTypeQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class CompanyUserCompanyAssignerDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_COMPANY = 'FACADE_COMPANY';

    /**
     * @var string
     */
    public const FACADE_COMPANY_BUSINESS_UNIT = 'FACADE_COMPANY_BUSINESS_UNIT';

    /**
     * @var string
     */
    public const FACADE_COMPANY_TYPE = 'FACADE_COMPANY_TYPE';

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
    public const FACADE_EVENT = 'FACADE_EVENT';

    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY = 'PROPEL_QUERY_COMPANY';

    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY_ROLE = 'PROPEL_QUERY_COMPANY_ROLE';

    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY_TYPE = 'PROPEL_QUERY_COMPANY_TYPE';

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
        $container = $this->addCompanyBusinessUnitFacade($container);
        $container = $this->addCompanyTypeFacade($container);
        $container = $this->addCompanyUserFacade($container);

        return $this->addCompanyRoleFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        return $this->addEventFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        $container = $this->addCompanyQuery($container);
        $container = $this->addCompanyRoleQuery($container);
        $container = $this->addCompanyTypeQuery($container);

        return $this->addCompanyUserQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyBusinessUnitFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_BUSINESS_UNIT] = static function (Container $container) {
            return new CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge(
                $container->getLocator()->companyBusinessUnit()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyTypeFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_TYPE] = static function (Container $container) {
            return new CompanyUserCompanyAssignerToCompanyTypeFacadeBridge(
                $container->getLocator()->companyType()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRoleFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_ROLE] = static function (Container $container) {
            return new CompanyUserCompanyAssignerToCompanyRoleFacadeBridge(
                $container->getLocator()->companyRole()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY] = static function (Container $container) {
            return new CompanyUserCompanyAssignerToCompanyFacadeBridge(
                $container->getLocator()->company()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_USER] = static function (Container $container) {
            return new CompanyUserCompanyAssignerToCompanyUserFacadeBridge(
                $container->getLocator()->companyUser()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRoleQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY_ROLE] = static function () {
            return SpyCompanyRoleQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY_USER] = static function () {
            return SpyCompanyUserQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyTypeQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY_TYPE] = static function () {
            return FoiCompanyTypeQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY] = static function () {
            return SpyCompanyQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT] = static function (Container $container) {
            return new CompanyUserCompanyAssignerToEventFacadeBridge(
                $container->getLocator()->event()->facade(),
            );
        };

        return $container;
    }
}
