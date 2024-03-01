<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Reader\ProductListReaderInterface;
use FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\ProductListIdsReducerPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestProductListsBulkRequestExpanderTest extends Unit
{
    protected RestProductListsBulkRequestExpanderInterface $expander;

    protected MockObject|GroupedIdentifierFilterInterface $groupedIdentifierFilterMock;

    protected MockObject|ProductListIdsReducerPluginInterface $productListIdsReducerPluginMock;

    protected MockObject|ProductListReaderInterface $productListReaderMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected MockObject|RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransferMock;

    protected MockObject|RestProductListsBulkRequestAssignmentProductListTransfer $restProductListsBulkRequestAssignmentProductListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->groupedIdentifierFilterMock = $this
            ->getMockBuilder(GroupedIdentifierFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListReaderMock = $this
            ->getMockBuilder(ProductListReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListIdsReducerPluginMock = $this
            ->getMockBuilder(ProductListIdsReducerPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentProductListTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentProductListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new RestProductListsBulkRequestExpander(
            $this->groupedIdentifierFilterMock,
            $this->productListReaderMock,
            [$this->productListIdsReducerPluginMock],
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $assignments = new ArrayObject();
        $assignments->append($this->restProductListsBulkRequestAssignmentTransferMock);

        $productListsToAssign = new ArrayObject();
        $productListsToAssign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $productListsToUnassign = new ArrayObject();
        $productListsToUnassign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $uuid = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $key = 'key';
        $groupedIdentifiers = [
            'uuid' => [$uuid],
            'key' => [$key],
        ];

        $productListIds = [
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' => 1,
            'key' => 1,
        ];

        $this->groupedIdentifierFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestProductListsBulkRequest')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($groupedIdentifiers);

        $this->productListReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByGroupedIdentifier')
            ->with($groupedIdentifiers)
            ->willReturn($productListIds);

        $this->productListIdsReducerPluginMock->expects(static::atLeastOnce())
            ->method('reduce')
            ->with($productListIds, $this->restProductListsBulkRequestTransferMock)
            ->willReturn($productListIds);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssign);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturnOnConsecutiveCalls($uuid, null);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('setId')
            ->willReturnSelf();

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn($key);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('setProductListsToAssign')
            ->willReturnSelf();

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassign);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('setProductListsToUnassign')
            ->willReturnSelf();

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setAssignments')
            ->willReturnSelf();

        $restProductListsBulkRequestTransfer = $this->expander
            ->expand($this->restProductListsBulkRequestTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestTransferMock,
            $restProductListsBulkRequestTransfer,
        );
    }

    /**
     * @return void
     */
    public function testExpandWithMissingKey(): void
    {
        $assignments = new ArrayObject();
        $assignments->append($this->restProductListsBulkRequestAssignmentTransferMock);

        $productListsToAssign = new ArrayObject();
        $productListsToAssign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $productListsToUnassign = new ArrayObject();
        $productListsToUnassign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $uuid = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $key = 'key';
        $groupedIdentifiers = [
            'uuid' => [$uuid],
            'key' => [$key],
        ];

        $productListIds = [
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' => 1,
            'key' => 1,
        ];

        $this->groupedIdentifierFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestProductListsBulkRequest')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($groupedIdentifiers);

        $this->productListReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByGroupedIdentifier')
            ->with($groupedIdentifiers)
            ->willReturn($productListIds);

        $this->productListIdsReducerPluginMock->expects(static::atLeastOnce())
            ->method('reduce')
            ->with($productListIds, $this->restProductListsBulkRequestTransferMock)
            ->willReturn($productListIds);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssign);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturnOnConsecutiveCalls($uuid, null);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('setId')
            ->willReturnSelf();

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('setProductListsToAssign')
            ->willReturnSelf();

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassign);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('setProductListsToUnassign')
            ->willReturnSelf();

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setAssignments')
            ->willReturnSelf();

        $restProductListsBulkRequestTransfer = $this->expander
            ->expand($this->restProductListsBulkRequestTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestTransferMock,
            $restProductListsBulkRequestTransfer,
        );
    }

    /**
     * @return void
     */
    public function testExpandWithMissingKeyValue(): void
    {
        $assignments = new ArrayObject();
        $assignments->append($this->restProductListsBulkRequestAssignmentTransferMock);

        $productListsToAssign = new ArrayObject();
        $productListsToAssign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $productListsToUnassign = new ArrayObject();
        $productListsToUnassign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $uuid = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $key = 'key';
        $groupedIdentifiers = [
            'uuid' => [$uuid],
            'key' => [$key],
        ];

        $productListIds = [
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' => 1,
        ];

        $this->groupedIdentifierFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestProductListsBulkRequest')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($groupedIdentifiers);

        $this->productListReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByGroupedIdentifier')
            ->with($groupedIdentifiers)
            ->willReturn($productListIds);

        $this->productListIdsReducerPluginMock->expects(static::atLeastOnce())
            ->method('reduce')
            ->with($productListIds, $this->restProductListsBulkRequestTransferMock)
            ->willReturn($productListIds);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssign);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturnOnConsecutiveCalls($uuid, null);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('setId')
            ->willReturnSelf();

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn($key);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('setProductListsToAssign')
            ->willReturnSelf();

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassign);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('setProductListsToUnassign')
            ->willReturnSelf();

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setAssignments')
            ->willReturnSelf();

        $restProductListsBulkRequestTransfer = $this->expander
            ->expand($this->restProductListsBulkRequestTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestTransferMock,
            $restProductListsBulkRequestTransfer,
        );
    }
}
