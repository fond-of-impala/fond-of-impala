<?php

namespace FondOfImpala\Glue\CustomerProductListsBulkRestApi\Plugin\ProductListsBulkRestApiExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentCustomerTransfer;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCustomerTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerRestProductListsBulkRequestAssignmentMapperPluginTest extends Unit
{
    protected MockObject|RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransferMock;

    protected RestProductListsBulkRequestAssignmentTransfer|MockObject $restProductListsBulkRequestAssignmentTransferMock;

    protected RestProductListsBulkAssignmentCustomerTransfer|MockObject $restProductListsBulkAssignmentCustomerTransferMock;

    protected RestProductListsBulkRequestAssignmentCustomerTransfer|MockObject $restProductListsBulkRequestAssignmentCustomerTransferMock;

    protected CustomerRestProductListsBulkRequestAssignmentMapperPlugin $plugin;

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

        $this->restProductListsBulkAssignmentCustomerTransferMock = $this->getMockBuilder(RestProductListsBulkAssignmentCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentCustomerTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CustomerRestProductListsBulkRequestAssignmentMapperPlugin();
    }

    /**
     * @return void
     */
    public function testMapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(): void
    {
        $data = [
            'customer_reference' => 'FOO--1',
        ];

        $this->restProductListsBulkAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkAssignmentCustomerTransferMock);

        $this->restProductListsBulkAssignmentCustomerTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn($data);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->with(
                static::callback(
                    static fn (RestProductListsBulkRequestAssignmentCustomerTransfer $restProductListsBulkRequestAssignmentCustomerTransfer): bool => $restProductListsBulkRequestAssignmentCustomerTransfer->getCustomerReference() === $data['customer_reference']
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

    /**
     * @return void
     */
    public function testMapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignmentWithoutCustomerInfo(): void
    {
        $this->restProductListsBulkAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        static::assertEquals(
            $this->restProductListsBulkRequestAssignmentTransferMock,
            $this->plugin->mapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(
                $this->restProductListsBulkAssignmentTransferMock,
                $this->restProductListsBulkRequestAssignmentTransferMock,
            ),
        );
    }
}
