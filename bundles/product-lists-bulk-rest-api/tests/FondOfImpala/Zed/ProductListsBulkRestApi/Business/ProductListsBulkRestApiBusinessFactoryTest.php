<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor\BulkProcessor;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Persistence\ProductListsBulkRestApiRepository;
use FondOfImpala\Zed\ProductListsBulkRestApi\ProductListsBulkRestApiDependencyProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ProductListsBulkRestApiBusinessFactoryTest extends Unit
{
    protected MockObject|Container $containerMock;

    protected ProductListsBulkRestApiBusinessFactory $factory;

    protected MockObject|ProductListsBulkRestApiToEventFacadeInterface $productListsBulkRestApiToEventFacadeMock;

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
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case ProductListsBulkRestApiDependencyProvider::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_PRE_CHECK:
                        return [];
                    case ProductListsBulkRestApiDependencyProvider::FACADE_EVENT:
                        return $self->productListsBulkRestApiToEventFacadeMock;
                    case ProductListsBulkRestApiDependencyProvider::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_EXPANDER:
                        return [];
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            BulkProcessor::class,
            $this->factory->createBulkProcessor(),
        );
    }

    /**
     * @return void
     */
    public function testCreateRestProductListsBulkRequestExpander(): void
    {
        static::assertInstanceOf(
            RestProductListsBulkRequestExpander::class,
            $this->factory->createRestProductListsBulkRequestExpander(),
        );
    }
}
