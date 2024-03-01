<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentPreCheckPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestProductListsBulkRequestAssignmentCheckerTest extends Unit
{
    protected RestProductListsBulkRequestAssignmentCheckerInterface $checker;

    protected MockObject|RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransferMock;

    protected MockObject|RestProductListsBulkRequestAssignmentPreCheckPluginInterface $restProductListsBulkRequestAssignmentPreCheckPluginMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentPreCheckPluginMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentPreCheckPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checker = new RestProductListsBulkRequestAssignmentChecker(
            [$this->restProductListsBulkRequestAssignmentPreCheckPluginMock],
        );
    }

    /**
     * @return void
     */
    public function testPreCheck(): void
    {
        $this->restProductListsBulkRequestAssignmentPreCheckPluginMock->expects(static::atLeastOnce())
            ->method('check')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn(true);

        $this->restProductListsBulkRequestAssignmentPreCheckPluginMock->expects(static::atLeastOnce())
            ->method('terminateOnFailure')
            ->willReturn(false);

        static::assertTrue($this->checker->preCheck($this->restProductListsBulkRequestAssignmentTransferMock));
    }

    /**
     * @return void
     */
    public function testPreCheckWithTerminateOnFailure(): void
    {
        $this->restProductListsBulkRequestAssignmentPreCheckPluginMock->expects(static::atLeastOnce())
            ->method('check')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn(true);

        $this->restProductListsBulkRequestAssignmentPreCheckPluginMock->expects(static::atLeastOnce())
            ->method('terminateOnFailure')
            ->willReturn(true);

        static::assertFalse($this->checker->preCheck($this->restProductListsBulkRequestAssignmentTransferMock));
    }

    /**
     * @return void
     */
    public function testPreCheckWithFalsePreCheck(): void
    {
        $this->restProductListsBulkRequestAssignmentPreCheckPluginMock->expects(static::atLeastOnce())
            ->method('check')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn(false);

        $this->restProductListsBulkRequestAssignmentPreCheckPluginMock->expects(static::atLeastOnce())
            ->method('terminateOnFailure')
            ->willReturn(true);

        static::assertFalse($this->checker->preCheck($this->restProductListsBulkRequestAssignmentTransferMock));
    }
}
