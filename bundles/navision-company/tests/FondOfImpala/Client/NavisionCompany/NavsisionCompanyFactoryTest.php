<?php

namespace FondOfImpala\Client\NavisionCompany;

use Codeception\Test\Unit;
use FondOfImpala\Client\NavisionCompany\Dependency\Client\NavisionCompanyToZedRequestClientInterface;
use FondOfImpala\Client\NavisionCompany\Zed\NavisionCompanyStubInterface;
use Spryker\Client\Kernel\Container;

class NavsisionCompanyFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\NavisionCompany\NavisionCompanyFactory
     */
    protected $navisionCompanyFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\NavisionCompany\Dependency\Client\NavisionCompanyToZedRequestClientInterface
     */
    protected $navisionCompanyToZedRequestClientInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyToZedRequestClientInterfaceMock = $this->getMockBuilder(NavisionCompanyToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyFactory = new NavisionCompanyFactory();
        $this->navisionCompanyFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedNavisionCompanyStub(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->navisionCompanyToZedRequestClientInterfaceMock);

        $this->assertInstanceOf(NavisionCompanyStubInterface::class, $this->navisionCompanyFactory->createZedNavisionCompanyStub());
    }
}
