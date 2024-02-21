<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Filter\DebtorNumbersFilterInterface;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestCompanyTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestOrderBudgetsBulkRequestExpanderTest extends Unit
{
    protected MockObject|OrderBudgetReaderInterface $companyReaderMock;

    protected RestOrderBudgetsBulkRequestExpanderInterface $expander;

    protected MockObject|DebtorNumbersFilterInterface $debtorNumbersFilterMock;

    protected MockObject|RestOrderBudgetsBulkRequestCompanyTransfer $restOrderBudgetsBulkRequestCompanyTransferMock;

    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    protected MockObject|RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->debtorNumbersFilterMock = $this
            ->getMockBuilder(DebtorNumbersFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyReaderMock = $this
            ->getMockBuilder(OrderBudgetReaderInterface::class)
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

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock = $this
            ->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new RestOrderBudgetsBulkRequestExpander(
            $this->debtorNumbersFilterMock,
            $this->companyReaderMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $debtorNumber = '11111';
        $debtorNumbers = ['11111'];
        $orderBudgetIds = ['11111' => 1];
        $customerReference = 'customer-reference';

        $orderBudgets = new ArrayObject();
        $orderBudgets->append($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);

        $this->debtorNumbersFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestOrderBudgetsBulkRequest')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($debtorNumbers);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->companyReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByCustomerReferenceAndDebtorNumbers')
            ->with($customerReference, $debtorNumbers)
            ->willReturn($orderBudgetIds);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn($orderBudgets);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restOrderBudgetsBulkRequestCompanyTransferMock);

        $this->restOrderBudgetsBulkRequestCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn($debtorNumber);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('setId')
            ->with(1)
            ->willReturnSelf();

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setOrderBudgets')
            ->with($orderBudgets)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        $restOrderBudgetsBulkRequestTransfer = $this->expander
            ->expand($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestTransferMock,
            $restOrderBudgetsBulkRequestTransfer,
        );

        static::assertInstanceOf(ArrayObject::class, $restOrderBudgetsBulkRequestTransfer->getOrderBudgets());
        static::assertInstanceOf(
            RestOrderBudgetsBulkRequestOrderBudgetTransfer::class,
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets()->offsetGet(0),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithOrderBudgetId(): void
    {
        $debtorNumbers = ['11111'];
        $orderBudgetIds = ['11111' => 1];
        $customerReference = 'customer-reference';

        $orderBudgets = new ArrayObject();
        $orderBudgets->append($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);

        $this->debtorNumbersFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestOrderBudgetsBulkRequest')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($debtorNumbers);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->companyReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByCustomerReferenceAndDebtorNumbers')
            ->with($customerReference, $debtorNumbers)
            ->willReturn($orderBudgetIds);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn($orderBudgets);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(1);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setOrderBudgets')
            ->with($orderBudgets)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        $restOrderBudgetsBulkRequestTransfer = $this->expander
            ->expand($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestTransferMock,
            $restOrderBudgetsBulkRequestTransfer,
        );

        static::assertInstanceOf(ArrayObject::class, $restOrderBudgetsBulkRequestTransfer->getOrderBudgets());
        static::assertInstanceOf(
            RestOrderBudgetsBulkRequestOrderBudgetTransfer::class,
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets()->offsetGet(0),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithMissingCompany(): void
    {
        $debtorNumbers = ['11111'];
        $orderBudgetIds = ['11111' => 1];
        $customerReference = 'customer-reference';

        $orderBudgets = new ArrayObject();
        $orderBudgets->append($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);

        $this->debtorNumbersFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestOrderBudgetsBulkRequest')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($debtorNumbers);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->companyReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByCustomerReferenceAndDebtorNumbers')
            ->with($customerReference, $debtorNumbers)
            ->willReturn($orderBudgetIds);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn($orderBudgets);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setOrderBudgets')
            ->with($orderBudgets)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        $restOrderBudgetsBulkRequestTransfer = $this->expander
            ->expand($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestTransferMock,
            $restOrderBudgetsBulkRequestTransfer,
        );

        static::assertInstanceOf(ArrayObject::class, $restOrderBudgetsBulkRequestTransfer->getOrderBudgets());
        static::assertInstanceOf(
            RestOrderBudgetsBulkRequestOrderBudgetTransfer::class,
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets()->offsetGet(0),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithMissingDebtorNumber(): void
    {
        $debtorNumbers = ['11111'];
        $orderBudgetIds = ['11111' => 1];
        $customerReference = 'customer-reference';

        $orderBudgets = new ArrayObject();
        $orderBudgets->append($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);

        $this->debtorNumbersFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestOrderBudgetsBulkRequest')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($debtorNumbers);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->companyReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByCustomerReferenceAndDebtorNumbers')
            ->with($customerReference, $debtorNumbers)
            ->willReturn($orderBudgetIds);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn($orderBudgets);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restOrderBudgetsBulkRequestCompanyTransferMock);

        $this->restOrderBudgetsBulkRequestCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn(null);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setOrderBudgets')
            ->with($orderBudgets)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        $restOrderBudgetsBulkRequestTransfer = $this->expander
            ->expand($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestTransferMock,
            $restOrderBudgetsBulkRequestTransfer,
        );

        static::assertInstanceOf(ArrayObject::class, $restOrderBudgetsBulkRequestTransfer->getOrderBudgets());
        static::assertInstanceOf(
            RestOrderBudgetsBulkRequestOrderBudgetTransfer::class,
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets()->offsetGet(0),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithMissingOrderBudgetId(): void
    {
        $debtorNumber = '11111';
        $debtorNumbers = ['11111'];
        $orderBudgetIds = ['11112' => 1];
        $customerReference = 'customer-reference';

        $orderBudgets = new ArrayObject();
        $orderBudgets->append($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);

        $this->debtorNumbersFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestOrderBudgetsBulkRequest')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($debtorNumbers);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->companyReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByCustomerReferenceAndDebtorNumbers')
            ->with($customerReference, $debtorNumbers)
            ->willReturn($orderBudgetIds);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getOrderBudgets')
            ->willReturn($orderBudgets);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restOrderBudgetsBulkRequestCompanyTransferMock);

        $this->restOrderBudgetsBulkRequestCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn($debtorNumber);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setOrderBudgets')
            ->with($orderBudgets)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        $restOrderBudgetsBulkRequestTransfer = $this->expander
            ->expand($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestTransferMock,
            $restOrderBudgetsBulkRequestTransfer,
        );

        static::assertInstanceOf(ArrayObject::class, $restOrderBudgetsBulkRequestTransfer->getOrderBudgets());
        static::assertInstanceOf(
            RestOrderBudgetsBulkRequestOrderBudgetTransfer::class,
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets()->offsetGet(0),
        );
    }
}
