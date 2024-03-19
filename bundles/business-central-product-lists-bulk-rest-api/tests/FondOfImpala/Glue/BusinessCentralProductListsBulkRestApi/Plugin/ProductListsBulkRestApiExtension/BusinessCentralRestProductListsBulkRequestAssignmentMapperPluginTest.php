<?php

namespace FondOfImpala\Glue\BusinessCentralProductListsBulkRestApi\Plugin\ProductListsBulkRestApiExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentCompanyTransfer;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCompanyTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class BusinessCentralRestProductListsBulkRequestAssignmentMapperPluginTest extends Unit
{
    protected MockObject|RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransferMock;

    protected RestProductListsBulkRequestAssignmentTransfer|MockObject $restProductListsBulkRequestAssignmentTransferMock;

    protected RestProductListsBulkAssignmentCompanyTransfer|MockObject $restProductListsBulkAssignmentCompanyTransferMock;

    protected RestProductListsBulkRequestAssignmentCompanyTransfer|MockObject $restProductListsBulkRequestAssignmentCompanyTransferMock;

    protected BusinessCentralRestProductListsBulkRequestAssignmentMapperPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkAssignmentCompanyTransferMock = $this->getMockBuilder(RestProductListsBulkAssignmentCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentCompanyTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new BusinessCentralRestProductListsBulkRequestAssignmentMapperPlugin();
    }

    /**
     * @return void
     */
    public function testMapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(): void
    {
        $debtorNumber = '12345';

        $this->restProductListsBulkAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkAssignmentCompanyTransferMock);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMock);

        $this->restProductListsBulkAssignmentCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn($debtorNumber);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMock->expects(static::atLeastOnce())
            ->method('setDebtorNumber')
            ->with($debtorNumber)
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMock);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('setCompany')
            ->with($this->restProductListsBulkRequestAssignmentCompanyTransferMock)
            ->willReturn($this->restProductListsBulkRequestAssignmentTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestAssignmentTransferMock,
            $this->plugin->mapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(
                $this->restProductListsBulkAssignmentTransferMock,
                $this->restProductListsBulkRequestAssignmentTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testMapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignmentWithoutCompanyInfo(): void
    {
        $this->restProductListsBulkAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        static::assertEquals(
            $this->restProductListsBulkRequestAssignmentTransferMock,
            $this->plugin->mapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(
                $this->restProductListsBulkAssignmentTransferMock,
                $this->restProductListsBulkRequestAssignmentTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testMapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignmentWithPredefinedCompany(): void
    {
        $debtorNumber = '12345';

        $this->restProductListsBulkAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkAssignmentCompanyTransferMock);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->restProductListsBulkAssignmentCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn($debtorNumber);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('setCompany')
            ->with(
                static::callback(
                    static fn (
                        RestProductListsBulkRequestAssignmentCompanyTransfer $restProductListsBulkRequestAssignmentCompanyTransfer
                    ): bool => $restProductListsBulkRequestAssignmentCompanyTransfer->getDebtorNumber() === $debtorNumber,
                ),
            )->willReturn($this->restProductListsBulkRequestAssignmentTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestAssignmentTransferMock,
            $this->plugin->mapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(
                $this->restProductListsBulkAssignmentTransferMock,
                $this->restProductListsBulkRequestAssignmentTransferMock,
            ),
        );
    }
}
