<?php

namespace FondOfImpala\Client\OrderBudgetsBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\OrderBudgetsBulkRestApi\Dependency\Client\OrderBudgetsBulkRestApiToZedRequestClientInterface;
use FondOfImpala\Client\OrderBudgetsBulkRestApi\Zed\OrderBudgetsBulkRestApiStub;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class OrderBudgetsBulkRestApiFactoryTest extends Unit
{
    protected MockObject|Container $containerMock;

    protected MockObject|OrderBudgetsBulkRestApiToZedRequestClientInterface $zedRequestClientMock;

    protected OrderBudgetsBulkRestApiFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(OrderBudgetsBulkRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new OrderBudgetsBulkRestApiFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedOrderBudgetsBulkRestApiStub(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(OrderBudgetsBulkRestApiDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            OrderBudgetsBulkRestApiStub::class,
            $this->factory->createZedOrderBudgetsBulkRestApiStub(),
        );
    }
}
