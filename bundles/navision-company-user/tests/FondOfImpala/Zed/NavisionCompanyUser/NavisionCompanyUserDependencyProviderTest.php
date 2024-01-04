<?php

namespace FondOfImpala\Zed\NavisionCompanyUser;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class NavisionCompanyUserDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompanyUser\NavisionCompanyUserDependencyProvider
     */
    protected $navisionCompanyUserDependencyProvider;

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

        $this->navisionCompanyUserDependencyProvider = new NavisionCompanyUserDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvidePersistenceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->navisionCompanyUserDependencyProvider->providePersistenceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
