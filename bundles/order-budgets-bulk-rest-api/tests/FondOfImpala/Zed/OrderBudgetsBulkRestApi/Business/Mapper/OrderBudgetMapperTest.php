<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderBudgetMapperTest extends Unit
{
    protected RestOrderBudgetsBulkRequestOrderBudgetTransfer|MockObject $restOrderBudgetsBulkRequestOrderBudgetTransferMock;

    protected OrderBudgetMapper $orderBudgetMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetMapper = new OrderBudgetMapper();
    }

    /**
     * @return void
     */
    public function testFromRestOrderBudgetsBulkRequestOrderBudget(): void
    {
        $id = 6;
        $nextInitialBudget = 10000;

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($id);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getNextInitialBudget')
            ->willReturn($nextInitialBudget);

        $orderBudgetTransfer = $this->orderBudgetMapper->fromRestOrderBudgetsBulkRequestOrderBudget(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
        );

        static::assertEquals(
            $id,
            $orderBudgetTransfer->getIdOrderBudget(),
        );

        static::assertEquals(
            $nextInitialBudget,
            $orderBudgetTransfer->getNextInitialBudget(),
        );
    }

    /**
     * @return void
     */
    public function testFromRestOrderBudgetsBulkRequestOrderBudgetWithInvalidId(): void
    {
        $id = null;

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($id);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::never())
            ->method('getNextInitialBudget');

        $orderBudgetTransfer = $this->orderBudgetMapper->fromRestOrderBudgetsBulkRequestOrderBudget(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
        );

        static::assertEquals(null, $orderBudgetTransfer);
    }

    /**
     * @return void
     */
    public function testFromRestOrderBudgetsBulkRequestOrderBudgetWithInvalidInitialBudget(): void
    {
        $id = 5;
        $nextInitialBudget = null;

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($id);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getNextInitialBudget')
            ->willReturn($nextInitialBudget);

        $orderBudgetTransfer = $this->orderBudgetMapper->fromRestOrderBudgetsBulkRequestOrderBudget(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
        );

        static::assertEquals(null, $orderBudgetTransfer);
    }
}
