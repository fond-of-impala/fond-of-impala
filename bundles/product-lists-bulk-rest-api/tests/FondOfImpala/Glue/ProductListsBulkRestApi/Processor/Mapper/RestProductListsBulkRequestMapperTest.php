<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestProductListsBulkRequestMapperTest extends Unit
{
    protected RestProductListsBulkRequestAssignmentMapperInterface|MockObject $restProductListsBulkRequestAssignmentMapperMock;

    protected RestProductListsBulkRequestAttributesTransfer|MockObject $restProductListsBulkRequestAttributesTransferMock;

    protected RestProductListsBulkRequestMapper $restProductListsBulkRequestMapper;

    protected MockObject|RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransferMock;

    protected MockObject|RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkRequestAssignmentMapperMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAttributesTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestMapper = new RestProductListsBulkRequestMapper(
            $this->restProductListsBulkRequestAssignmentMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testFromRestProductListsBulkRequestAttributes(): void
    {
        $this->restProductListsBulkRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn(new ArrayObject([$this->restProductListsBulkAssignmentTransferMock]));

        $this->restProductListsBulkRequestAssignmentMapperMock->expects(static::atLeastOnce())
            ->method('fromRestProductListsBulkAssignment')
            ->with($this->restProductListsBulkAssignmentTransferMock)
            ->willReturn($this->restProductListsBulkRequestAssignmentTransferMock);

        $restProductListsBulkRequestTransfer = $this->restProductListsBulkRequestMapper
            ->fromRestProductListsBulkRequestAttributes($this->restProductListsBulkRequestAttributesTransferMock);

        static::assertCount(
            1,
            $restProductListsBulkRequestTransfer->getAssignments(),
        );

        static::assertEquals(
            $this->restProductListsBulkRequestAssignmentTransferMock,
            $restProductListsBulkRequestTransfer->getAssignments()->offsetGet(0),
        );
    }
}
