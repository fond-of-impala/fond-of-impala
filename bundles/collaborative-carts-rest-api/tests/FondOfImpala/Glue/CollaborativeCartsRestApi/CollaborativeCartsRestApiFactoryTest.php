<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClient;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart\CollaborativeCartProcessor;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\AbstractClient;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class CollaborativeCartsRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiClient
     */
    protected MockObject|CompanyBusinessUnitsCartsRestApiClient $clientMock;

    protected MockObject|Container $containerMock;

    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    protected CollaborativeCartsRestApiFactory $collaborativeCartsRestApiFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->clientMock = $this->getMockBuilder(CollaborativeCartsRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartsRestApiFactory = new class (
            $this->clientMock,
            $this->restResourceBuilderMock
        ) extends CollaborativeCartsRestApiFactory {
            /**
             * @var \Spryker\Client\Kernel\AbstractClient
             */
            protected $client;

            protected RestResourceBuilderInterface $restResourceBuilder;

            /**
             * @param \Spryker\Client\Kernel\AbstractClient $client
             * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
             */
            public function __construct(
                AbstractClient $client,
                RestResourceBuilderInterface $restResourceBuilder
            ) {
                $this->client = $client;
                $this->restResourceBuilder = $restResourceBuilder;
            }

            /**
             * @return \Spryker\Client\Kernel\AbstractClient
             */
            protected function getClient(): AbstractClient
            {
                return $this->client;
            }

            /**
             * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            public function getResourceBuilder(): RestResourceBuilderInterface
            {
                return $this->restResourceBuilder;
            }
        };

        $this->collaborativeCartsRestApiFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCollaborativeCartProcessor(): void
    {
        $this->assertInstanceOf(
            CollaborativeCartProcessor::class,
            $this->collaborativeCartsRestApiFactory->createCollaborativeCartProcessor(),
        );
    }
}
