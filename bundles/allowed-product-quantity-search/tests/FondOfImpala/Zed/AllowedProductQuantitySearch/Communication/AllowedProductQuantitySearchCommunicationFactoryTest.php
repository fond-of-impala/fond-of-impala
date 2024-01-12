<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Communication;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantitySearch\AllowedProductQuantitySearchDependencyProvider;
use FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToAllowedProductQuantityFacadeInterface;
use FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToProductPageSearchFacadeInterface;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantitySearchCommunicationFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\AllowedProductQuantitySearchCommunicationFactory
     */
    protected $allowedProductQuantitySearchCommunicationFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToAllowedProductQuantityFacadeInterface
     */
    protected $allowedProductQuantitySearchToAllowedProductQuantityFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToEventBehaviorFacadeInterface
     */
    protected $allowedProductQuantitySearchToEventBehaviorFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToProductPageSearchFacadeInterface
     */
    protected $allowedProductQuantitySearchToProductPageSearchFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantitySearchToAllowedProductQuantityFacadeInterfaceMock = $this->getMockBuilder(AllowedProductQuantitySearchToAllowedProductQuantityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantitySearchToEventBehaviorFacadeInterfaceMock = $this->getMockBuilder(AllowedProductQuantitySearchToEventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantitySearchToProductPageSearchFacadeInterfaceMock = $this->getMockBuilder(AllowedProductQuantitySearchToProductPageSearchFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantitySearchCommunicationFactory = new AllowedProductQuantitySearchCommunicationFactory();
        $this->allowedProductQuantitySearchCommunicationFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetAllowedProductQuantityFacade(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(AllowedProductQuantitySearchDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY)
            ->willReturn($this->allowedProductQuantitySearchToAllowedProductQuantityFacadeInterfaceMock);

        $this->assertInstanceOf(
            AllowedProductQuantitySearchToAllowedProductQuantityFacadeInterface::class,
            $this->allowedProductQuantitySearchCommunicationFactory->getAllowedProductQuantityFacade(),
        );
    }

    /**
     * @return void
     */
    public function testGetEventBehaviorFacade(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(AllowedProductQuantitySearchDependencyProvider::FACADE_EVENT_BEHAVIOR)
            ->willReturn($this->allowedProductQuantitySearchToEventBehaviorFacadeInterfaceMock);

        $this->assertInstanceOf(
            AllowedProductQuantitySearchToEventBehaviorFacadeInterface::class,
            $this->allowedProductQuantitySearchCommunicationFactory->getEventBehaviorFacade(),
        );
    }

    /**
     * @return void
     */
    public function testGetProductPageSearchFacade(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(AllowedProductQuantitySearchDependencyProvider::FACADE_PRODUCT_PAGE_SEARCH)
            ->willReturn($this->allowedProductQuantitySearchToProductPageSearchFacadeInterfaceMock);

        $this->assertInstanceOf(
            AllowedProductQuantitySearchToProductPageSearchFacadeInterface::class,
            $this->allowedProductQuantitySearchCommunicationFactory->getProductPageSearchFacade(),
        );
    }
}
