<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProductListConditionalAvailabilityPageSearchCommunicationFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ProductListConditionalAvailabilityPageSearchCommunicationFactory
     */
    protected $productListConditionalAvailabilityPageSearchCommunicationFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterface
     */
    protected $productListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected $productListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface
     */
    protected $productListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterfaceMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterfaceMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterfaceMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchCommunicationFactory = new ProductListConditionalAvailabilityPageSearchCommunicationFactory();
        $this->productListConditionalAvailabilityPageSearchCommunicationFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetConditionalAvailabilityPageSearchFacade(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ProductListConditionalAvailabilityPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY_PAGE_SEARCH)
            ->willReturn($this->productListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterfaceMock);

        $this->assertInstanceOf(
            ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterface::class,
            $this->productListConditionalAvailabilityPageSearchCommunicationFactory->getConditionalAvailabilityPageSearchFacade(),
        );
    }

    /**
     * @return void
     */
    public function testGetConditionalAvailabilityFacade(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ProductListConditionalAvailabilityPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY)
            ->willReturn($this->productListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterfaceMock);

        $this->assertInstanceOf(
            ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface::class,
            $this->productListConditionalAvailabilityPageSearchCommunicationFactory->getConditionalAvailabilityFacade(),
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
            ->with(ProductListConditionalAvailabilityPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR)
            ->willReturn($this->productListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterfaceMock);

        $this->assertInstanceOf(
            ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface::class,
            $this->productListConditionalAvailabilityPageSearchCommunicationFactory->getEventBehaviorFacade(),
        );
    }
}
