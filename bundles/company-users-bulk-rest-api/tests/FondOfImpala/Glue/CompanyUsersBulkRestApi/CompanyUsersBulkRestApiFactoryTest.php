<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiClient;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\CompanyUsersBulk\CompanyUsersBulkProcessor;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class CompanyUsersBulkRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiClient|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $clientMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $restResourceBuilderMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(CompanyUsersBulkRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyUsersBulkRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new class ($this->restResourceBuilderMock) extends CompanyUsersBulkRestApiFactory {
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
    public function testCreateCompanyUsersBulkProcessor(): void
    {
        static::assertInstanceOf(
            CompanyUsersBulkProcessor::class,
            $this->factory->createCompanyUsersBulkProcessor(),
        );
    }
}
