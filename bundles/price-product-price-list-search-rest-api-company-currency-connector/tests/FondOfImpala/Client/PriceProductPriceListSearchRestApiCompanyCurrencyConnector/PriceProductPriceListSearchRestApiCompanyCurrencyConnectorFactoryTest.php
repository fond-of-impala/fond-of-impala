<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface;
use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStub;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory
     */
    protected PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedPriceProductPriceListSearchRestApiCompanyCurrencyConnectorStub(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStub::class,
            $this->factory
                ->createZedStub(),
        );
    }
}
