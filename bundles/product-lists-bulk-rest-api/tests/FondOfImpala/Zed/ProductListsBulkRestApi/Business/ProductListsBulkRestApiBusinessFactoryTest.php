<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor\BulkProcessorInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Persistence\ProductListsBulkRestApiRepository;
use FondOfImpala\Zed\ProductListsBulkRestApi\ProductListsBulkRestApiDependencyProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ProductListsBulkRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListsBulkRestApi\Business\ProductListsBulkRestApiBusinessFactory
     */
    protected ProductListsBulkRestApiBusinessFactory $factory;

    /**
     * @var PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface
     */
    protected MockObject|ProductListsBulkRestApiToEventFacadeInterface $productListsBulkRestApiToEventFacadeMock;

    /**
     * @var PHPUnit\Framework\MockObject\MockObject|FondOfImpala\Zed\ProductListsBulkRestApi\Persistence\ProductListsBulkRestApiRepository
     */
    protected MockObject|ProductListsBulkRestApiRepository $repositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListsBulkRestApiToEventFacadeMock = $this
            ->getMockBuilder(ProductListsBulkRestApiToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ProductListsBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ProductListsBulkRestApiBusinessFactory();
        $this->factory->setContainer($this->containerMock);
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateBulkProcessor(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ProductListsBulkRestApiDependencyProvider::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_PRE_CHECK],
                [ProductListsBulkRestApiDependencyProvider::FACADE_EVENT]
            )->willReturnOnConsecutiveCalls(
                [],
                $this->productListsBulkRestApiToEventFacadeMock,
                []
            );

        static::assertInstanceOf(
            BulkProcessorInterface::class,
            $this->factory->createBulkProcessor()
        );
    }

    /**
     * @return void
     */
    public function testCreateRestProductListsBulkRequestExpander(): void
    {
        static::assertInstanceOf(
            RestProductListsBulkRequestExpanderInterface::class,
            $this->factory->createRestProductListsBulkRequestExpander()
        );
    }
}
