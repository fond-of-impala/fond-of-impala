<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui;

use Closure;
use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class CompanyCompanyTypeGuiDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCompanyTypeGui\CompanyCompanyTypeGuiDependencyProvider
     */
    protected $companyCompanyTypeGuiDependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCompanyTypeGuiDependencyProvider = new CompanyCompanyTypeGuiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideCommunicationLayerDependencies(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('offsetSet')
            ->with(
                CompanyCompanyTypeGuiDependencyProvider::FACADE_COMPANY_TYPE,
                $this->isInstanceOf(Closure::class),
            );

        $container = $this->companyCompanyTypeGuiDependencyProvider
            ->provideCommunicationLayerDependencies($this->containerMock);

        $this->assertEquals($container, $this->containerMock);
    }
}
