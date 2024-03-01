<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker\RestProductListsBulkRequestAssignmentCheckerInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestExpanderPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class BulkProcessorTest extends Unit
{
    protected BulkProcessorInterface $processor;

    protected MockObject|ProductListsBulkRestApiToEventFacadeInterface $productListsBulkRestApiToEventFacadeMock;

    protected MockObject|RestProductListsBulkRequestExpanderPluginInterface $restProductListsBulkRequestExpanderPluginMock;

    protected MockObject|RestProductListsBulkRequestAssignmentCheckerInterface $restProductListsBulkRequestAssignmentCheckerMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected MockObject|RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkRequestAssignmentCheckerMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListsBulkRestApiToEventFacadeMock = $this
            ->getMockBuilder(ProductListsBulkRestApiToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestExpanderPluginMock = $this
            ->getMockBuilder(RestProductListsBulkRequestExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->processor = new BulkProcessor(
            $this->restProductListsBulkRequestAssignmentCheckerMock,
            $this->productListsBulkRestApiToEventFacadeMock,
            [$this->restProductListsBulkRequestExpanderPluginMock],
        );
    }

    /**
     * @return void
     */
    public function testProcess(): void
    {
        $assignments = new ArrayObject();
        $assignments->append($this->restProductListsBulkRequestAssignmentTransferMock);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestAssignmentCheckerMock->expects(static::atLeastOnce())
            ->method('preCheck')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn(true);

        $this->productListsBulkRestApiToEventFacadeMock->expects(static::atLeastOnce())
            ->method('trigger')
            ->with(
                'ProductListsBulkRestApi.assignment.process',
                $this->restProductListsBulkRequestAssignmentTransferMock,
            );

        $restProductListsBulkResponseTransfer = $this->processor
            ->process($this->restProductListsBulkRequestTransferMock);

        static::assertTrue($restProductListsBulkResponseTransfer->getIsSuccessful());
        static::assertEquals([], $restProductListsBulkResponseTransfer->getInvalidIndexes());
    }

    /**
     * @return void
     */
    public function testProcessWithFalseChecker(): void
    {
        $assignments = new ArrayObject();
        $assignments->append($this->restProductListsBulkRequestAssignmentTransferMock);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestAssignmentCheckerMock->expects(static::atLeastOnce())
            ->method('preCheck')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn(false);

        $restProductListsBulkResponseTransfer = $this->processor
            ->process($this->restProductListsBulkRequestTransferMock);

        static::assertTrue($restProductListsBulkResponseTransfer->getIsSuccessful());
        static::assertEquals([0], $restProductListsBulkResponseTransfer->getInvalidIndexes());
    }

    /**
     * @return void
     */
    public function testProcessWithException(): void
    {
        $assignments = new ArrayObject();
        $assignments->append($this->restProductListsBulkRequestAssignmentTransferMock);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAssignments')
            ->willReturn($assignments);

        $this->restProductListsBulkRequestAssignmentCheckerMock->expects(static::atLeastOnce())
            ->method('preCheck')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn(true);

        $this->productListsBulkRestApiToEventFacadeMock->expects(static::atLeastOnce())
            ->method('trigger')
            ->with(
                'ProductListsBulkRestApi.assignment.process',
                $this->restProductListsBulkRequestAssignmentTransferMock,
            )
            ->willThrowException(new Exception());

        $restProductListsBulkResponseTransfer = $this->processor
            ->process($this->restProductListsBulkRequestTransferMock);

        static::assertFalse($restProductListsBulkResponseTransfer->getIsSuccessful());
    }
}
