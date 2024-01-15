<?php

namespace FondOfImpala\Zed\CompanyUserReference;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class CompanyUserReferenceDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceDependencyProvider
     */
    protected $companyUserReferenceDependencyProvider;

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

        $this->companyUserReferenceDependencyProvider = new CompanyUserReferenceDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUserReferenceDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
