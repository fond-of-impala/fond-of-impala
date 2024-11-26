<?php

namespace FondOfImpala\Glue\PriceListsRestApi;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Glue\PriceListsRestApi\Dependency\Client\PriceListsRestApiToPriceListClientInterface;
use FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListReader;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class PriceListsRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\PriceListsRestApi\Dependency\Client\PriceListsRestApiToPriceListClientInterface
     */
    protected MockObject|PriceListsRestApiToPriceListClientInterface $priceClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiFactory
     */
    protected PriceListsRestApiFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceClientMock = $this->getMockBuilder(PriceListsRestApiToPriceListClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new class ($this->restResourceBuilderMock) extends PriceListsRestApiFactory {
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

        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreatePriceListReader(): void
    {
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case PriceListsRestApiDependencyProvider::CLIENT_PRICE_LIST:
                        return $self->priceClientMock;
                    case PriceListsRestApiDependencyProvider::PLUGINS_FILTER_FIELDS_EXPANDER:
                        return [];
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            PriceListReader::class,
            $this->factory->createPriceListReader(),
        );
    }
}
