<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Communication\Plugin\ProductListsBulkRestApiExtension;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListRestProductListsBulkRequestAssignmentPreCheckPluginTest extends Unit
{
    protected ProductListRestProductListsBulkRequestAssignmentPreCheckPlugin $plugin;

    protected MockObject|RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransferMock;

    protected MockObject|RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentProductListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restProductListsBulkRequestAssignmentTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentProductListTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentProductListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductListRestProductListsBulkRequestAssignmentPreCheckPlugin();
    }

    /**
     * @return void
     */
    public function testCheck(): void
    {
        $productListsToAssign = new ArrayObject();
        $productListsToAssign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $productListsToUnassign = new ArrayObject();
        $productListsToUnassign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssign);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturnOnConsecutiveCalls(1, 1);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassign);

        static::assertTrue($this->plugin->check($this->restProductListsBulkRequestAssignmentTransferMock));
    }

    /**
     * @return void
     */
    public function testCheckWithMissingIds(): void
    {
        $productListsToAssign = new ArrayObject();
        $productListsToAssign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $productListsToUnassign = new ArrayObject();
        $productListsToUnassign->append($this->restProductListsBulkRequestAssignmentProductListTransferMock);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssign);

        $this->restProductListsBulkRequestAssignmentProductListTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null, null);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassign);

        static::assertFalse($this->plugin->check($this->restProductListsBulkRequestAssignmentTransferMock));
    }

    /**
     * @return void
     */
    public function testTerminateOnFailure(): void
    {
        static::assertTrue($this->plugin->terminateOnFailure());
    }
}
