<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestOrderBudgetsBulkRequestMapperTest extends Unit
{
    protected RestOrderBudgetsBulkRequestOrderBudgetMapperInterface|MockObject $restOrderBudgetsBulkRequestOrderBudgetMapperMock;

    protected RestOrderBudgetsBulkRequestAttributesTransfer|MockObject $restOrderBudgetsBulkRequestAttributesTransferMock;

    protected MockObject|RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransferMock;

    protected RestOrderBudgetsBulkRequestOrderBudgetTransfer|MockObject $restOrderBudgetsBulkRequestOrderBudgetTransferMock;

    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    protected RestOrderBudgetsBulkRequestMapper $restOrderBudgetsBulkRequestMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restOrderBudgetsBulkRequestOrderBudgetMapperMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestAttributesTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkOrderBudgetTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestMapper = new RestOrderBudgetsBulkRequestMapper(
            $this->restOrderBudgetsBulkRequestOrderBudgetMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testFromQuote(): void
    {
        $this->restOrderBudgetsBulkRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn(new ArrayObject([$this->restOrderBudgetsBulkOrderBudgetTransferMock]));

        $this->restOrderBudgetsBulkRequestOrderBudgetMapperMock->expects(static::atLeastOnce())
            ->method('fromRestOrderBudgetsBulkOrderBudget')
            ->with($this->restOrderBudgetsBulkOrderBudgetTransferMock)
            ->willReturn($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);

        $restOrderBudgetsBulkRequestTransfer = $this->restOrderBudgetsBulkRequestMapper->fromRestOrderBudgetsBulkRequestAttributes(
            $this->restOrderBudgetsBulkRequestAttributesTransferMock,
        );

        static::assertCount(
            1,
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets(),
        );

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets()->offsetGet(0),
        );
    }
}
