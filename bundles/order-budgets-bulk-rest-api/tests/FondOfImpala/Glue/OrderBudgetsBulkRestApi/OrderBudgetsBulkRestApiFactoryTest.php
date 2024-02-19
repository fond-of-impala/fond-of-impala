<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiClient;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\OrderBudgetsBulk\OrderBudgetsBulkProcessor;
use FondOfImpala\Glue\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class OrderBudgetsBulkRestApiFactoryTest extends Unit
{
    protected MockObject|Container $containerMock;

    protected MockObject|OrderBudgetsBulkRestApiClient $clientMock;

    protected MockObject|OrderBudgetsBulkRestApiConfig $configMock;

    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    /**
     * @var array<\FondOfImpala\Glue\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restOrderBudgetsBulkRequestOrderBudgetMapperPluginMocks;

    protected OrderBudgetsBulkRestApiFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(OrderBudgetsBulkRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(OrderBudgetsBulkRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestOrderBudgetMapperPluginMocks = [
            $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->factory = new class ($this->restResourceBuilderMock) extends OrderBudgetsBulkRestApiFactory {
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
    public function testCreateOrderBudgetsBulkProcessor(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(OrderBudgetsBulkRestApiDependencyProvider::PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_ORDER_BUDGET_MAPPER)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(OrderBudgetsBulkRestApiDependencyProvider::PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_ORDER_BUDGET_MAPPER)
            ->willReturn($this->restOrderBudgetsBulkRequestOrderBudgetMapperPluginMocks);

        static::assertInstanceOf(
            OrderBudgetsBulkProcessor::class,
            $this->factory->createOrderBudgetsBulkProcessor(),
        );
    }
}
