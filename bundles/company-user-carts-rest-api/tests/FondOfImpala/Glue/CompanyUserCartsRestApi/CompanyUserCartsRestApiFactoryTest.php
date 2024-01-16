<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClient;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Creator\CartCreator;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Deleter\CartDeleter;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Finder\CartFinder;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Updater\CartUpdater;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class CompanyUserCartsRestApiFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClient|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $clientMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->clientMock = $this->getMockBuilder(CompanyUserCartsRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyUserCartsRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new class ($this->restResourceBuilderMock) extends CompanyUserCartsRestApiFactory {
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
            public function getResourceBuilder(): RestResourceBuilderInterface
            {
                return $this->restResourceBuilder;
            }
        };

        $this->factory->setClient($this->clientMock);
        $this->factory->setConfig($this->configMock);
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCartCreator(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(CompanyUserCartsRestApiDependencyProvider::PLUGINS_REST_CART_ITEM_EXPANDER)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyUserCartsRestApiDependencyProvider::PLUGINS_REST_CART_ITEM_EXPANDER)
            ->willReturn([]);

        static::assertInstanceOf(
            CartCreator::class,
            $this->factory->createCartCreator(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartUpdater(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(CompanyUserCartsRestApiDependencyProvider::PLUGINS_REST_CART_ITEM_EXPANDER)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyUserCartsRestApiDependencyProvider::PLUGINS_REST_CART_ITEM_EXPANDER)
            ->willReturn([]);

        static::assertInstanceOf(
            CartUpdater::class,
            $this->factory->createCartUpdater(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartDeleter(): void
    {
        static::assertInstanceOf(
            CartDeleter::class,
            $this->factory->createCartDeleter(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartFinder(): void
    {
        static::assertInstanceOf(
            CartFinder::class,
            $this->factory->createCartFinder(),
        );
    }
}
