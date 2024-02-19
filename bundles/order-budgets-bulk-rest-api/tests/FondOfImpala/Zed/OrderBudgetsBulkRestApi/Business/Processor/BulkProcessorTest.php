<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Processor;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\OrderBudgetsBulkRestApiEvents;
use FondOfImpala\Zed\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestExpanderPluginInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class BulkProcessorTest extends Unit
{
    protected MockObject|OrderBudgetsBulkRestApiToEventFacadeInterface $eventFacadeMock;

    protected MockObject|RestOrderBudgetsBulkRequestExpanderPluginInterface $restOrderBudgetsBulkRequestExpanderPluginMock;

    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer>
     */
    protected array $restOrderBudgetsBulkRequestOrderBudgetTransferMocks;

    protected BulkProcessor $bulkProcessor;

    /**
     * @Override
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventFacadeMock = $this->getMockBuilder(OrderBudgetsBulkRestApiToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestExpanderPluginMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks = [
            $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->bulkProcessor = new BulkProcessor(
            $this->eventFacadeMock,
            [$this->restOrderBudgetsBulkRequestExpanderPluginMock]
        );
    }

    /**
     * @return void
     */
    public function testProcess(): void
    {
        $id = 9;

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn(new ArrayObject($this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks));

        $this->restOrderBudgetsBulkRequestExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($id);

        $this->eventFacadeMock->expects(static::atLeastOnce())
            ->method('trigger')
            ->with(
                OrderBudgetsBulkRestApiEvents::PERSIST_PROCESS,
                $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[1]
            );

        $restOrderBudgetsBulkResponseTransfer = $this->bulkProcessor->process(
            $this->restOrderBudgetsBulkRequestTransferMock
        );

        static::assertTrue($restOrderBudgetsBulkResponseTransfer->getIsSuccessful());
        static::assertEquals(2, $restOrderBudgetsBulkResponseTransfer->getActualCount());
        static::assertEquals(1, $restOrderBudgetsBulkResponseTransfer->getCurrentCount());
    }

    /**
     * @return void
     */
    public function testProcessWithError(): void
    {
        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn(new ArrayObject($this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks));

        $this->restOrderBudgetsBulkRequestExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willThrowException(new Exception());

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[0]->expects(static::never())
            ->method('getId');

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[1]->expects(static::never())
            ->method('getId');

        $this->eventFacadeMock->expects(static::never())
            ->method('trigger');

        $restOrderBudgetsBulkResponseTransfer = $this->bulkProcessor->process(
            $this->restOrderBudgetsBulkRequestTransferMock
        );

        static::assertFalse($restOrderBudgetsBulkResponseTransfer->getIsSuccessful());
    }
}
