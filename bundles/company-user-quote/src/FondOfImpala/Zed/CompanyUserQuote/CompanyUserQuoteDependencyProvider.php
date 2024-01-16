<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUserQuote;

use FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade\CompanyUserQuoteToCompanyUserReferenceFacadeBridge;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Quote\QuoteDependencyProvider;

/**
 * @method \Spryker\Zed\Quote\QuoteConfig getConfig()
 */
class CompanyUserQuoteDependencyProvider extends QuoteDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_COMPANY_USER_REFERENCE = 'FACADE_COMPANY_USER_REFERENCE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addCompanyUserReferenceFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserReferenceFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_USER_REFERENCE] = function (Container $container) {
            return new CompanyUserQuoteToCompanyUserReferenceFacadeBridge(
                $container->getLocator()->companyUserReference()->facade(),
            );
        };

        return $container;
    }
}
