<?php

namespace FondOfImpala\Client\ProductListPriceProductPriceListPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client\ProductListPriceProductPriceListPageSearchToCustomerClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class ProductListPriceProductPriceListPageSearchFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client\ProductListPriceProductPriceListPageSearchToCustomerClientInterface
     */
    protected MockObject|ProductListPriceProductPriceListPageSearchToCustomerClientInterface $customerClientMock;

    /**
     * @var \FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\ProductListPriceProductPriceListPageSearchFactory
     */
    protected ProductListPriceProductPriceListPageSearchFactory $productListPriceProductPriceListPageSearchFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientMock = $this->getMockBuilder(ProductListPriceProductPriceListPageSearchToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPriceProductPriceListPageSearchFactory = new ProductListPriceProductPriceListPageSearchFactory();
        $this->productListPriceProductPriceListPageSearchFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetCustomerClient(): void
    {
        $this->containerMock->expects(self::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(self::atLeastOnce())
            ->method('get')
            ->with(ProductListPriceProductPriceListPageSearchDependencyProvider::CLIENT_CUSTOMER)
            ->willReturn($this->customerClientMock);

        self::assertEquals(
            $this->customerClientMock,
            $this->productListPriceProductPriceListPageSearchFactory->getCustomerClient(),
        );
    }
}
