<?php

namespace FondOfImpala\Client\CompanyUserReference;

use Codeception\Test\Unit;
use Spryker\Client\Kernel\Container;

class CompanyUserReferenceDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyUserReference\CompanyUserReferenceDependencyProvider
     */
    protected $companyUserReferenceDependencyProvider;

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

        $this->companyUserReferenceDependencyProvider = new CompanyUserReferenceDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUserReferenceDependencyProvider->provideServiceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
