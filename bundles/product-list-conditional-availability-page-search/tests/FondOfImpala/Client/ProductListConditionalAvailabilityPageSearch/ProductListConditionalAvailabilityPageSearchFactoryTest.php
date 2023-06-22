<?php

namespace FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client\ProductListConditionalAvailabilityPageSearchToCustomerClientInterface;
use Spryker\Client\Kernel\Container;

class ProductListConditionalAvailabilityPageSearchFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchFactory
     */
    protected $productListConditionalAvailabilityPageSearchFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client\ProductListConditionalAvailabilityPageSearchToCustomerClientInterface
     */
    protected $productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchFactory = new ProductListConditionalAvailabilityPageSearchFactory();
        $this->productListConditionalAvailabilityPageSearchFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetCustomerClient(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ProductListConditionalAvailabilityPageSearchDependencyProvider::CLIENT_CUSTOMER)
            ->willReturn($this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock);

        $this->assertInstanceOf(
            ProductListConditionalAvailabilityPageSearchToCustomerClientInterface::class,
            $this->productListConditionalAvailabilityPageSearchFactory->getCustomerClient(),
        );
    }
}
