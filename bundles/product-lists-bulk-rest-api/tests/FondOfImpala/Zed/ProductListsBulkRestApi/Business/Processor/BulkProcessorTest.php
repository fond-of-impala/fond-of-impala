<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker\RestProductListsBulkRequestAssignmentCheckerInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestExpanderPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class BulkProcessorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor\BulkProcessorInterface
     */
    protected BulkProcessorInterface $processor;

    /**
     * @var PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface
     */
    protected MockObject|ProductListsBulkRestApiToEventFacadeInterface $productListsBulkRestApiToEventFacadeMock;

    /**
     * @var PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestExpanderPluginInterface
     */
    protected MockObject|RestProductListsBulkRequestExpanderPluginInterface $restProductListsBulkRequestExpanderPluginMock;

    /**
     * @var PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker\RestProductListsBulkRequestAssignmentCheckerInterface
     */
    protected MockObject|RestProductListsBulkRequestAssignmentCheckerInterface $restProductListsBulkRequestAssignmentCheckerMock;

    /**
     * @var PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    /**
     * @var PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer
     */
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
            [$this->restProductListsBulkRequestExpanderPluginMock]
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
                $this->restProductListsBulkRequestAssignmentTransferMock
            );

        $restProductListsBulkResponseTransfer = $this->processor
            ->process($this->restProductListsBulkRequestTransferMock);

        static::assertInstanceOf(
            RestProductListsBulkResponseTransfer::class,
            $restProductListsBulkResponseTransfer,
        );

        static::assertTrue($restProductListsBulkResponseTransfer->getIsSuccessful());
        static::assertEquals(1, $restProductListsBulkResponseTransfer->getCurrentCount());
        static::assertEquals(1, $restProductListsBulkResponseTransfer->getActualCount());
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

        static::assertInstanceOf(
            RestProductListsBulkResponseTransfer::class,
            $restProductListsBulkResponseTransfer,
        );

        static::assertTrue($restProductListsBulkResponseTransfer->getIsSuccessful());
        static::assertEquals(0, $restProductListsBulkResponseTransfer->getCurrentCount());
        static::assertEquals(1, $restProductListsBulkResponseTransfer->getActualCount());
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
                $this->restProductListsBulkRequestAssignmentTransferMock
            )
            ->willThrowException( new \Exception());

        $restProductListsBulkResponseTransfer = $this->processor
            ->process($this->restProductListsBulkRequestTransferMock);

        static::assertFalse($restProductListsBulkResponseTransfer->getIsSuccessful());
    }
}
