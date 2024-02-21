<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestCompanyTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DebtorNumbersFilterTest extends Unit
{
    protected DebtorNumbersFilterInterface $filter;

    protected MockObject|RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransferMock;

    protected MockObject|RestOrderBudgetsBulkRequestCompanyTransfer $restOrderBudgetsBulkRequestCompanyTransferMock;

    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock = $this
            ->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestCompanyTransferMock = $this
            ->getMockBuilder(RestOrderBudgetsBulkRequestCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestTransferMock = $this
            ->getMockBuilder(RestOrderBudgetsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->filter = new DebtorNumbersFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromRestOrderBudgetsBulkRequest(): void
    {
        $debtorNumber = '11111';
        $restOrderBudgetsBulkRequestOrderBudgetTransfers = new ArrayObject();
        $restOrderBudgetsBulkRequestOrderBudgetTransfers->append(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
        );

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn($restOrderBudgetsBulkRequestOrderBudgetTransfers);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restOrderBudgetsBulkRequestCompanyTransferMock);

        $this->restOrderBudgetsBulkRequestCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn($debtorNumber);

        $debtorNumbers = $this->filter
            ->filterFromRestOrderBudgetsBulkRequest($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertIsArray($debtorNumbers);
        static::assertNotEmpty($debtorNumbers);
        static::assertEquals('11111', $debtorNumbers[0]);
    }

    /**
     * @return void
     */
    public function testFilterFromRestOrderBudgetsBulkRequestWithNoCompany(): void
    {
        $restOrderBudgetsBulkRequestOrderBudgetTransfers = new ArrayObject();
        $restOrderBudgetsBulkRequestOrderBudgetTransfers->append(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
        );

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn($restOrderBudgetsBulkRequestOrderBudgetTransfers);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restOrderBudgetsBulkRequestCompanyTransferMock);

        $this->restOrderBudgetsBulkRequestCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn(null);

        $debtorNumbers = $this->filter
            ->filterFromRestOrderBudgetsBulkRequest($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertIsArray($debtorNumbers);
        static::assertEmpty($debtorNumbers);
    }

    /**
     * @return void
     */
    public function testFilterFromRestOrderBudgetsBulkRequestWithNoDebtorNumber(): void
    {
        $restOrderBudgetsBulkRequestOrderBudgetTransfers = new ArrayObject();
        $restOrderBudgetsBulkRequestOrderBudgetTransfers->append(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
        );

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn($restOrderBudgetsBulkRequestOrderBudgetTransfers);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $debtorNumbers = $this->filter
            ->filterFromRestOrderBudgetsBulkRequest($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertIsArray($debtorNumbers);
        static::assertEmpty($debtorNumbers);
    }
}
