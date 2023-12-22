<?php

declare(strict_types = 1);

namespace FondOfImpala\Glue\CompanyUsersRestApi;

use FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class CompanyUsersRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_COMPANY_USER_REFERENCE = 'CLIENT_COMPANY_USER_REFERENCE';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        return $this->addCompanyUserReferenceClient($container);
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCompanyUserReferenceClient(Container $container): Container
    {
        $container[static::CLIENT_COMPANY_USER_REFERENCE] = static fn (Container $container): CompanyUsersRestApiToCompanyUserReferenceClientBridge => new CompanyUsersRestApiToCompanyUserReferenceClientBridge(
            $container->getLocator()->companyUserReference()->client(),
        );

        return $container;
    }
}
