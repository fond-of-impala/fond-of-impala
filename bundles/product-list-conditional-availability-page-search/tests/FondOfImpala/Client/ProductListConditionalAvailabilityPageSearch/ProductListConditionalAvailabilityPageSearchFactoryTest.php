<?php

namespace FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client\ProductListConditionalAvailabilityPageSearchToCustomerClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class ProductListConditionalAvailabilityPageSearchFactoryTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchFactory $factory;

    protected MockObject|Container $containerMock;

    protected MockObject|ProductListConditionalAvailabilityPageSearchToCustomerClientInterface $customerClientMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ProductListConditionalAvailabilityPageSearchFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetCustomerClient(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ProductListConditionalAvailabilityPageSearchDependencyProvider::CLIENT_CUSTOMER)
            ->willReturn($this->customerClientMock);

        static::assertEquals($this->customerClientMock, $this->factory->getCustomerClient());
    }
}
