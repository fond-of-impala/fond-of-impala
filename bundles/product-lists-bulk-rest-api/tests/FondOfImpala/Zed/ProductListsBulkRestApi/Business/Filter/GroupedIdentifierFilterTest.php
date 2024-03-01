<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class GroupedIdentifierFilterTest extends Unit
{
    protected GroupedIdentifierFilterInterface $filter;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected MockObject|RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransferMock;

    protected MockObject|RestProductListsBulkRequestAssignmentProductListTransfer $restProductListsBulkRequestAssignmentProductListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkRequestTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentProductListTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentProductListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->filter = new GroupedIdentifierFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromRestProductListsBulkRequestAssignments(): void
    {
        $assignments = new ArrayObject();
        $assignments->append($this->restProductListsBulkRequestAssignmentTransferMock);

        $productListsToAssign = new ArrayObject();
        $productListsToAssign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $productListsToUnassign = new ArrayObject();
        $productListsToUnassign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $uuid = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $key = 'key';

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssign);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassign);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($uuid);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn($key);

        $groups = $this->filter
            ->filterFromRestProductListsBulkRequest($this->restProductListsBulkRequestTransferMock);

        static::assertCount(2, $groups);
        static::assertEquals('uuid', array_key_first($groups));
    }

    /**
     * @return void
     */
    public function testFilterFromRestProductListsBulkRequestAssignmentsWithMissingUuidAndKey(): void
    {
        $assignments = new ArrayObject();
        $assignments->append($this->restProductListsBulkRequestAssignmentTransferMock);

        $productListsToAssign = new ArrayObject();
        $productListsToAssign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $productListsToUnassign = new ArrayObject();
        $productListsToUnassign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssign);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassign);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn(null);

        $groups = $this->filter
            ->filterFromRestProductListsBulkRequest($this->restProductListsBulkRequestTransferMock);

        static::assertCount(2, $groups);
        static::assertEquals('uuid', array_key_first($groups));
    }

    /**
     * @return void
     */
    public function testFilterFromRestProductListsBulkRequestAssignmentsWithMissingUuid(): void
    {
        $assignments = new ArrayObject();
        $assignments->append($this->restProductListsBulkRequestAssignmentTransferMock);

        $productListsToAssign = new ArrayObject();
        $productListsToAssign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $productListsToUnassign = new ArrayObject();
        $productListsToUnassign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $key = 'key';

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssign);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassign);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn($key);

        $groups = $this->filter
            ->filterFromRestProductListsBulkRequest($this->restProductListsBulkRequestTransferMock);

        static::assertCount(2, $groups);
        static::assertEquals('uuid', array_key_first($groups));
    }
}
