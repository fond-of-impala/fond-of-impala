<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter;

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
        ];

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks = [
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
        $customerReferences = ['FOO--1'];
        $emails = ['foo@bar.com'];

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
            ->willReturn($customerReferences[0]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::never())
            ->method('getEmail');

        $this->restProductListsBulkRequestAssignmentTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn($emails[0]);

        static::assertEquals(
            [
                'customerReference' => $customerReferences,
                'email' => $emails,
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
        $customerReferences = ['FOO--1'];
        $emails = ['foo@bar.com'];

        $this->restProductListsBulkRequestAssignmentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReferences[0]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::never())
            ->method('getEmail');

        $this->restProductListsBulkRequestAssignmentTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn($emails[0]);

        static::assertEquals(
            [
                'customerReference' => $customerReferences,
                'email' => $emails,
            ],
            $this->groupedIdentifierFilter->filterFromRestProductListsBulkRequestAssignments(
                new ArrayObject($this->restProductListsBulkRequestAssignmentTransferMocks),
            ),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromRestProductListsBulkRequestAssignmentsWithoutEmails(): void
    {
        $customerReferences = ['FOO--1'];

        $this->restProductListsBulkRequestAssignmentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReferences[0]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::never())
            ->method('getEmail');

        $this->restProductListsBulkRequestAssignmentTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn(null);

        static::assertEquals(
            [
                'customerReference' => $customerReferences,
                'email' => [],
            ],
            $this->groupedIdentifierFilter->filterFromRestProductListsBulkRequestAssignments(
                new ArrayObject($this->restProductListsBulkRequestAssignmentTransferMocks),
            ),
        );
    }
}
