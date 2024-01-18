<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiClient;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Cart\CartReader;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Expander\CartItemByQuoteResourceRelationshipExpander;
use Spryker\Client\Kernel\AbstractClient;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;

class CompanyBusinessUnitsCartsRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiClient
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiFactory
     */
    protected $companyBusinessUnitsCartsRestApiFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->clientMock = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsCartsRestApiFactory = new class ($this->clientMock, $this->restResourceBuilderMock) extends CompanyBusinessUnitsCartsRestApiFactory {
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
    }

    /**
     * @return void
     */
    public function testCreateCartReader(): void
    {
        self::assertInstanceOf(
            CartReader::class,
            $this->companyBusinessUnitsCartsRestApiFactory->createCartReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartItemByQuoteResourceRelationshipExpander(): void
    {
        self::assertInstanceOf(
            CartItemByQuoteResourceRelationshipExpander::class,
            $this->companyBusinessUnitsCartsRestApiFactory->createCartItemByQuoteResourceRelationshipExpander(),
        );
    }
}
