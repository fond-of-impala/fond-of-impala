<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClient;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart\CollaborativeCartProcessor;
use Spryker\Client\Kernel\AbstractClient;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class CollaborativeCartsRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiClient
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiFactory
     */
    protected $collaborativeCartsRestApiFactory;

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

            /**
             * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            protected $restResourceBuilder;

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
            public function getClient(): AbstractClient
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
