<?php

namespace FondOfImpala\Zed\CompanyUserQuote;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class CompanyUserQuoteDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserQuote\CompanyUserQuoteDependencyProvider
     */
    protected $companyUserQuoteDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
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
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUserQuoteDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
