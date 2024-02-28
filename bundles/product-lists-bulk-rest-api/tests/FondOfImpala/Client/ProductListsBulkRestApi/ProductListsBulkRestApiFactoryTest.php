<?php

namespace FondOfImpala\Client\ProductListsBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\ProductListsBulkRestApi\Dependency\Client\ProductListsBulkRestApiToZedRequestClientInterface;
use FondOfImpala\Client\ProductListsBulkRestApi\Zed\ProductListsBulkRestApiStub;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class ProductListsBulkRestApiFactoryTest extends Unit
{
    protected MockObject|Container $containerMock;

    protected MockObject|ProductListsBulkRestApiToZedRequestClientInterface $zedRequestClientMock;

    protected ProductListsBulkRestApiFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(ProductListsBulkRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ProductListsBulkRestApiFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedProductListsBulkRestApiStub(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ProductListsBulkRestApiDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            ProductListsBulkRestApiStub::class,
            $this->factory->createZedProductListsBulkRestApiStub(),
        );
    }
}
