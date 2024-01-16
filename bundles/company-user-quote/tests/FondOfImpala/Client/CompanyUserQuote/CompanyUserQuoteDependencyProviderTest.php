<?php

namespace FondOfImpala\Client\CompanyUserQuote;

use Codeception\Test\Unit;
use Spryker\Client\Kernel\Container;

class CompanyUserQuoteDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyUserQuote\CompanyUserQuoteDependencyProvider
     */
    protected $companyUserQuoteDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteDependencyProvider = new CompanyUserQuoteDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUserQuoteDependencyProvider->provideServiceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
