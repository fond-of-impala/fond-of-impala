<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed\CompanyCurrencyPriceProductPriceListSearchRestApiStub;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class CompanyCurrencyPriceProductPriceListSearchRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiFactory
     */
    protected CompanyCurrencyPriceProductPriceListSearchRestApiFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CompanyCurrencyPriceProductPriceListSearchRestApiFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedCompanyCurrencyPriceProductPriceListSearchRestApiStub(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            CompanyCurrencyPriceProductPriceListSearchRestApiStub::class,
            $this->factory
                ->createZedStub(),
        );
    }
}
