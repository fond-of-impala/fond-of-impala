<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Reader\CompanyReaderInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCompanyTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestProductListsBulkRequestExpanderTest extends Unit
{
    protected MockObject|GroupedIdentifierFilterInterface $groupedIdentifierFilterMock;

    protected MockObject|CompanyReaderInterface $companyReaderMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCompanyTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentCompanyTransferMocks;

    protected RestProductListsBulkRequestExpander $restProductListsBulkRequestExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->groupedIdentifierFilterMock = $this->getMockBuilder(GroupedIdentifierFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyReaderMock = $this->getMockBuilder(CompanyReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMocks = [
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks = [
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentCompanyTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentCompanyTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentCompanyTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restProductListsBulkRequestExpander = new RestProductListsBulkRequestExpander(
            $this->groupedIdentifierFilterMock,
            $this->companyReaderMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $customerReference = 'FOO--5';
        $debtorNumber = '12345';
        $groupedIdentifier = ['debtorNumber' => [$debtorNumber]];
        $companyIds = [$debtorNumber => 10];
        $restProductListsBulkRequestAssignmentTransferMocks = new ArrayObject(
            $this->restProductListsBulkRequestAssignmentTransferMocks,
        );

        $this->groupedIdentifierFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestProductListsBulkRequest')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($groupedIdentifier);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->companyReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByCustomerReferenceAndGroupedIdentifier')
            ->with($customerReference, $groupedIdentifier)
            ->willReturn($companyIds);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($restProductListsBulkRequestAssignmentTransferMocks);

        $this->restProductListsBulkRequestAssignmentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMocks[0]);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn($debtorNumber);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setId')
            ->willReturn($companyIds[$debtorNumber]);

        $this->restProductListsBulkRequestAssignmentTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn('23456');

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[1]->expects(static::never())
            ->method('setId');

        $this->restProductListsBulkRequestAssignmentTransferMocks[3]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMocks[2]);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[2]->expects(static::never())
            ->method('setId');

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setAssignments')
            ->with($restProductListsBulkRequestAssignmentTransferMocks)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestTransferMock,
            $this->restProductListsBulkRequestExpander->expand(
                $this->restProductListsBulkRequestTransferMock,
            ),
        );
    }
}
