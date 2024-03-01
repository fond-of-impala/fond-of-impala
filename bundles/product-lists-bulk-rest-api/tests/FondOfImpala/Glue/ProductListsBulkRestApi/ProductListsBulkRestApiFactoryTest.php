<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\ProductListsBulkRestApi\ProductListsBulkRestApiClient;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\ProductListsBulk\ProductListsBulkProcessor;
use FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentMapperPluginInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class ProductListsBulkRestApiFactoryTest extends Unit
{
    protected MockObject|Container $containerMock;

    protected MockObject|ProductListsBulkRestApiClient $clientMock;

    protected MockObject|ProductListsBulkRestApiConfig $configMock;

    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    /**
     * @var array<\FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentMapperPluginInterface|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentMapperPluginMocks;

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

        $this->clientMock = $this->getMockBuilder(ProductListsBulkRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(ProductListsBulkRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentMapperPluginMocks = [
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentMapperPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->factory = new class ($this->restResourceBuilderMock) extends ProductListsBulkRestApiFactory {
            protected RestResourceBuilderInterface $restResourceBuilder;

            /**
             * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
             */
            public function __construct(RestResourceBuilderInterface $restResourceBuilder)
            {
                $this->restResourceBuilder = $restResourceBuilder;
            }

            /**
             * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            public function getResourceBuilder(): RestResourceBuilderInterface
            {
                return $this->restResourceBuilder;
            }
        };

        $this->factory->setConfig($this->configMock);
        $this->factory->setClient($this->clientMock);
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateProductListsBulkProcessor(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(ProductListsBulkRestApiDependencyProvider::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_MAPPER)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ProductListsBulkRestApiDependencyProvider::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_MAPPER)
            ->willReturn($this->restProductListsBulkRequestAssignmentMapperPluginMocks);

        static::assertInstanceOf(
            ProductListsBulkProcessor::class,
            $this->factory->createProductListsBulkProcessor(),
        );
    }
}
