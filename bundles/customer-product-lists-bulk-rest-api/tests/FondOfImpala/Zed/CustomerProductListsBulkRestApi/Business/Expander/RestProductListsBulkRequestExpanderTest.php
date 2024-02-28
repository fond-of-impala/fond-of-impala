<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\CustomerReaderInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCustomerTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestProductListsBulkRequestExpanderTest extends Unit
{
    protected MockObject|GroupedIdentifierFilterInterface $groupedIdentifierFilterMock;

    protected MockObject|CustomerReaderInterface $customerReaderMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCustomerTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentCustomerTransferMocks;

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

        $this->customerReaderMock = $this->getMockBuilder(CustomerReaderInterface::class)
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
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentCustomerTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restProductListsBulkRequestExpander = new RestProductListsBulkRequestExpander(
            $this->groupedIdentifierFilterMock,
            $this->customerReaderMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $customerReference = 'FOO--5';
        $email = 'foo@bar.com';
        $groupedIdentifier = ['customerReference' => [$customerReference], 'email' => [$email]];
        $customerIds = [$customerReference => 2, $email => 10];
        $restProductListsBulkRequestAssignmentTransferMocks = new ArrayObject(
            $this->restProductListsBulkRequestAssignmentTransferMocks,
        );

        $this->groupedIdentifierFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestProductListsBulkRequest')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($groupedIdentifier);

        $this->customerReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByGroupedIdentifier')
            ->with($groupedIdentifier)
            ->willReturn($customerIds);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($restProductListsBulkRequestAssignmentTransferMocks);

        $this->restProductListsBulkRequestAssignmentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn($email);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setId')
            ->willReturn($customerIds[$email]);

        $this->restProductListsBulkRequestAssignmentTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]->expects(static::atLeastOnce())
            ->method('setId')
            ->with($customerIds[$customerReference])
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[1]);

        $this->restProductListsBulkRequestAssignmentTransferMocks[3]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn('bar@foo.com');

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[2]->expects(static::never())
            ->method('setId');

        $this->restProductListsBulkRequestAssignmentTransferMocks[4]->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMocks[3]);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[3]->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[3]->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMocks[3]->expects(static::never())
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
