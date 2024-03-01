<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCustomerTransfer;
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
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCustomerTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentCustomerTransferMocks;

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
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks = [
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentCustomerTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentCustomerTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentCustomerTransfer::class)
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
        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn(new ArrayObject($this->restProductListsBulkRequestAssignmentTransferMocks));

        $this->restProductListsBulkRequestAssignmentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('FOO--1');

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[3]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn('foo@bar.com');

        static::assertEquals(
            [
                'customerReference' => ['FOO--1'],
                'email' => ['foo@bar.com'],
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
        $this->restProductListsBulkRequestAssignmentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('FOO--1');

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[3]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn('foo@bar.com');

        static::assertEquals(
            [
                'customerReference' => ['FOO--1'],
                'email' => ['foo@bar.com'],
            ],
            $this->groupedIdentifierFilter->filterFromRestProductListsBulkRequestAssignments(
                new ArrayObject($this->restProductListsBulkRequestAssignmentTransferMocks),
            ),
        );
    }
}
