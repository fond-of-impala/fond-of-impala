<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\QuoteExpander;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\SalesOrderExpander;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidator;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorDependencyProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class SplittableCheckoutOrderTypeConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    protected SplittableCheckoutOrderTypeConnectorConfig|MockObject $configMock;

    protected SplittableCheckoutOrderTypeConnectorBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(SplittableCheckoutOrderTypeConnectorConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new SplittableCheckoutOrderTypeConnectorBusinessFactory();
        $this->factory->setConfig($this->configMock);
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateQuoteExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(SplittableCheckoutOrderTypeConnectorDependencyProvider::PROPEL_TABLE_MAP_ORDER_TYPES)
            ->willReturn([]);

        static::assertInstanceOf(
            QuoteExpander::class,
            $this->factory->createQuoteExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateSalesOrderExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(SplittableCheckoutOrderTypeConnectorDependencyProvider::PROPEL_TABLE_MAP_ORDER_TYPES)
            ->willReturn([]);

        static::assertInstanceOf(
            SalesOrderExpander::class,
            $this->factory->createSalesOrderExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateOrderTypeValidator(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(SplittableCheckoutOrderTypeConnectorDependencyProvider::PROPEL_TABLE_MAP_ORDER_TYPES)
            ->willReturn([]);

        static::assertInstanceOf(
            OrderTypeValidator::class,
            $this->factory->createOrderTypeValidator(),
        );
    }
}
