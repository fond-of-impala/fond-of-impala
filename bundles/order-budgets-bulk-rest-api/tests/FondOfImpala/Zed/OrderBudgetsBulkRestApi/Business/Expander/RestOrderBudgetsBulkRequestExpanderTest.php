<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Filter\UuidsFilterInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestOrderBudgetsBulkRequestExpanderTest extends Unit
{
    protected MockObject|UuidsFilterInterface $uuidsFilterMock;

    protected OrderBudgetReaderInterface|MockObject $orderBudgetReaderMock;

    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer>
     */
    protected array $restOrderBudgetsBulkRequestOrderBudgetTransferMocks;

    protected RestOrderBudgetsBulkRequestExpander $restOrderBudgetsBulkRequestExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->uuidsFilterMock = $this->getMockBuilder(UuidsFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetReaderMock = $this->getMockBuilder(OrderBudgetReaderInterface::class)
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
            $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restOrderBudgetsBulkRequestExpander = new RestOrderBudgetsBulkRequestExpander(
            $this->uuidsFilterMock,
            $this->orderBudgetReaderMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $uuids = ['814c9e8d-3672-4370-a1ec-52207f4cb9b7'];
        $orderBudgetIds = ['814c9e8d-3672-4370-a1ec-52207f4cb9b7' => 2];

        $this->uuidsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestOrderBudgetsBulkRequest')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($uuids);

        $this->orderBudgetReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByUuids')
            ->with($uuids)
            ->willReturn($orderBudgetIds);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn(new ArrayObject($this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks));

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn(null);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[0]->expects(static::never())
            ->method('setId');

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('07b15001-26f2-476d-948f-a53377e02df3');

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[1]->expects(static::never())
            ->method('setId');

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($uuids[0]);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[2]->expects(static::atLeastOnce())
            ->method('setId')
            ->with($orderBudgetIds[$uuids[0]])
            ->willReturn($this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[2]);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setOrderBudgets')
            ->with(new ArrayObject($this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks))
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestTransferMock,
            $this->restOrderBudgetsBulkRequestExpander->expand($this->restOrderBudgetsBulkRequestTransferMock),
        );
    }
}
