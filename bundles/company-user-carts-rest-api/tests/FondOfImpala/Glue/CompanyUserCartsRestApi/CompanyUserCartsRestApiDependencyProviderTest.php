<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi;

use Codeception\Test\Unit;
use Spryker\Glue\Kernel\Container;
use Spryker\Shared\Kernel\LocatorLocatorInterface;

class CompanyUserCartsRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiDependencyProvider
     */
    protected $companyUserCartsRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\LocatorLocatorInterface
     */
    protected $locatorLocatorInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->locatorLocatorInterfaceMock = $this->getMockBuilder(LocatorLocatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCartsRestApiDependencyProvider = new CompanyUserCartsRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideDependencies(): void
    {
        $this->assertInstanceOf(Container::class, $this->companyUserCartsRestApiDependencyProvider->provideDependencies($this->containerMock));
    }
}
