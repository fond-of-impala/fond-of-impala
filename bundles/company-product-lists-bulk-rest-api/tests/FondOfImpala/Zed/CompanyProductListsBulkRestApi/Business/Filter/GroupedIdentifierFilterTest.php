<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCompanyTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class GroupedIdentifierFilterTest extends Unit
{
    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCompanyTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentCompanyTransferMocks;

    protected GroupedIdentifierFilter $groupedIdentifierFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

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
        ];

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks = [
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentCompanyTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentCompanyTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->groupedIdentifierFilter = new GroupedIdentifierFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromRestProductListsBulkRequest(): void
    {
        $uuid = '12345';

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn(new ArrayObject($this->restProductListsBulkRequestAssignmentTransferMocks));

        $this->restProductListsBulkRequestAssignmentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMocks[0]);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($uuid);

        $this->restProductListsBulkRequestAssignmentTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn(null);

        static::assertEquals(
            [
                'uuid' => [$uuid],
            ],
            $this->groupedIdentifierFilter->filterFromRestProductListsBulkRequest(
                $this->restProductListsBulkRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromRestProductListsBulkRequestAssignments(): void
    {
        $uuid = '12345';

        $this->restProductListsBulkRequestAssignmentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMocks[0]);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($uuid);

        $this->restProductListsBulkRequestAssignmentTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn(null);

        static::assertEquals(
            [
                'uuid' => [$uuid],
            ],
            $this->groupedIdentifierFilter->filterFromRestProductListsBulkRequestAssignments(
                new ArrayObject($this->restProductListsBulkRequestAssignmentTransferMocks),
            ),
        );
    }
}
