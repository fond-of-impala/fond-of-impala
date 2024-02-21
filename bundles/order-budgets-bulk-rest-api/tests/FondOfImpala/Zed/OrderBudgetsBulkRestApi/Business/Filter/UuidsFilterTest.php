<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class UuidsFilterTest extends Unit
{
    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer>
     */
    protected array $restOrderBudgetsBulkRequestOrderBudgetTransferMocks;

    protected UuidsFilter $uuidsFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

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

        $this->uuidsFilter = new UuidsFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromRestOrderBudgetsBulkRequest(): void
    {
        $uuid = '814c9e8d-3672-4370-a1ec-52207f4cb9b7';

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn(new ArrayObject($this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks));

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($uuid);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn(null);

        $uuids = $this->uuidsFilter->filterFromRestOrderBudgetsBulkRequest(
            $this->restOrderBudgetsBulkRequestTransferMock,
        );

        static::assertEquals(
            [$uuid],
            $uuids,
        );
    }
}
