<?php

namespace FondOfImpala\Client\PriceList;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceList\Dependency\Client\PriceListToZedRequestClientInterface;
use FondOfImpala\Client\PriceList\Zed\PriceListStub;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class PriceListFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \FondOfImpala\Client\PriceList\Dependency\Client\PriceListToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceListToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\PriceList\PriceListFactory
     */
    protected PriceListFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(PriceListToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new PriceListFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedPriceListStub(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(PriceListDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            PriceListStub::class,
            $this->factory
                ->createZedPriceListStub(),
        );
    }
}
