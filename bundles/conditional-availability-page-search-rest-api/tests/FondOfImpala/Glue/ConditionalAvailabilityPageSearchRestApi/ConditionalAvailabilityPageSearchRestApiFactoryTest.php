<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Reader\ConditionalAvailabilityPageSearchReader;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\EarliestDeliveryDate\Generator\EarliestDeliveryDateGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class ConditionalAvailabilityPageSearchRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface $conditionalAvailabilityPageSearchClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface $conditionalAvailabilityServiceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiFactory
     */
    protected ConditionalAvailabilityPageSearchRestApiFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchClientMock = $this
            ->getMockBuilder(ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityServiceMock = $this
            ->getMockBuilder(ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new class ($this->restResourceBuilderMock) extends ConditionalAvailabilityPageSearchRestApiFactory {
            /**
             * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            protected $restResourceBuilder;

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
            public function getResourceBuilder()
            {
                return $this->restResourceBuilder;
            }
        };

        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityPageSearchReader(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ConditionalAvailabilityPageSearchRestApiDependencyProvider::CLIENT_CONDITIONAL_AVAILABILITY_PAGE_SEARCH],
                [ConditionalAvailabilityPageSearchRestApiDependencyProvider::PLUGIN_REST_CONDITIONAL_AVAILABILITY_PERIOD_MAPPER],
            )
            ->willReturnOnConsecutiveCalls(
                $this->conditionalAvailabilityPageSearchClientMock,
                [],
            );

        static::assertInstanceOf(
            ConditionalAvailabilityPageSearchReader::class,
            $this->factory->createConditionalAvailabilityPageSearchReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateEarliestDeliveryDateGenerator(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(
                ConditionalAvailabilityPageSearchRestApiDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY,
            )
            ->willReturn($this->conditionalAvailabilityServiceMock);

        static::assertInstanceOf(
            EarliestDeliveryDateGenerator::class,
            $this->factory->createEarliestDeliveryDateGenerator(),
        );
    }
}
