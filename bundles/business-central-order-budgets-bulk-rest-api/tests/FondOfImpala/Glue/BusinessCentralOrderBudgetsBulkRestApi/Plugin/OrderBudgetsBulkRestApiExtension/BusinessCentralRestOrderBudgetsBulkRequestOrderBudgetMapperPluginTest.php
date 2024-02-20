<?php

namespace FondOfImpala\Glue\BusinessCentralOrderBudgetsBulkRestApi\Plugin\OrderBudgetsBulkRestApiExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestOrderBudgetsBulkCompanyTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestCompanyTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class BusinessCentralRestOrderBudgetsBulkRequestOrderBudgetMapperPluginTest extends Unit
{
    protected BusinessCentralRestOrderBudgetsBulkRequestOrderBudgetMapperPlugin $plugin;

    protected MockObject|RestOrderBudgetsBulkCompanyTransfer $restOrderBudgetsBulkCompanyTransferMock;

    protected MockObject|RestOrderBudgetsBulkRequestCompanyTransfer $restOrderBudgetsBulkRequestCompanyTransferMock;

    protected MockObject|RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransferMock;

    protected MockObject|RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restOrderBudgetsBulkCompanyTransferMock = $this
            ->getMockBuilder(RestOrderBudgetsBulkCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestCompanyTransferMock = $this
            ->getMockBuilder(RestOrderBudgetsBulkRequestCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkOrderBudgetTransferMock = $this
            ->getMockBuilder(RestOrderBudgetsBulkOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock = $this
            ->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new BusinessCentralRestOrderBudgetsBulkRequestOrderBudgetMapperPlugin();
    }

    /**
     * @return void
     */
    public function testMapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudget(): void
    {
        $debtorNumber = '11111';

        $this->restOrderBudgetsBulkOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restOrderBudgetsBulkCompanyTransferMock);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restOrderBudgetsBulkRequestCompanyTransferMock);

        $this->restOrderBudgetsBulkCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn($debtorNumber);

        $this->restOrderBudgetsBulkRequestCompanyTransferMock->expects(static::atLeastOnce())
            ->method('setDebtorNumber')
            ->with($debtorNumber)
            ->willReturnSelf();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('setCompany')
            ->with($this->restOrderBudgetsBulkRequestCompanyTransferMock)
            ->willReturnSelf();

        $restOrderBudgetsBulkRequestOrderBudgetTransfer = $this->plugin
            ->mapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudget(
                $this->restOrderBudgetsBulkOrderBudgetTransferMock,
                $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
            );

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
            $restOrderBudgetsBulkRequestOrderBudgetTransfer,
        );

        static::assertInstanceOf(
            RestOrderBudgetsBulkRequestCompanyTransfer::class,
            $restOrderBudgetsBulkRequestOrderBudgetTransfer->getCompany(),
        );
    }

    /**
     * @return void
     */
    public function testMapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudgetWithMissingCompany(): void
    {
        $this->restOrderBudgetsBulkOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $restOrderBudgetsBulkRequestOrderBudgetTransfer = $this->plugin
            ->mapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudget(
                $this->restOrderBudgetsBulkOrderBudgetTransferMock,
                $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
            );

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
            $restOrderBudgetsBulkRequestOrderBudgetTransfer,
        );
    }

    /**
     * @return void
     */
    public function testMapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudgetWithMissingRequestCompany(): void
    {
        $this->restOrderBudgetsBulkOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restOrderBudgetsBulkCompanyTransferMock);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('setCompany')
            ->willReturnSelf();

        $restOrderBudgetsBulkRequestOrderBudgetTransfer = $this->plugin
            ->mapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudget(
                $this->restOrderBudgetsBulkOrderBudgetTransferMock,
                $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
            );

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
            $restOrderBudgetsBulkRequestOrderBudgetTransfer,
        );
    }
}
