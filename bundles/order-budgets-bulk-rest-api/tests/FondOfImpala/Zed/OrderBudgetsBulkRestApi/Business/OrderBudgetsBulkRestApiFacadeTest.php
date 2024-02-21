<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpanderInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Persister\OrderBudgetPersisterInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Processor\BulkProcessorInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderBudgetsBulkRestApiFacadeTest extends Unit
{
    protected MockObject|OrderBudgetsBulkRestApiBusinessFactory $factoryMock;

    protected BulkProcessorInterface|MockObject $bulkProcessorMock;

    protected RestOrderBudgetsBulkRequestExpanderInterface|MockObject $restOrderBudgetsBulkRequestExpanderMock;

    protected MockObject|OrderBudgetPersisterInterface $orderBudgetPersisterMock;

    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    protected RestOrderBudgetsBulkResponseTransfer|MockObject $restOrderBudgetsBulkResponseTransferMock;

    protected RestOrderBudgetsBulkRequestOrderBudgetTransfer|MockObject $restOrderBudgetsBulkRequestOrderBudgetTransferMock;

    protected OrderBudgetsBulkRestApiFacade $facade;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(OrderBudgetsBulkRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bulkProcessorMock = $this->getMockBuilder(BulkProcessorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestExpanderMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetPersisterMock = $this->getMockBuilder(OrderBudgetPersisterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkResponseTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new OrderBudgetsBulkRestApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandRestOrderBudgetsBulkRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createRestOrderBudgetsBulkRequestExpander')
            ->willReturn($this->restOrderBudgetsBulkRequestExpanderMock);

        $this->restOrderBudgetsBulkRequestExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestTransferMock,
            $this->facade->expandRestOrderBudgetsBulkRequest($this->restOrderBudgetsBulkRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testBulkProcess(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createBulkProcessor')
            ->willReturn($this->bulkProcessorMock);

        $this->bulkProcessorMock->expects(static::atLeastOnce())
            ->method('process')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($this->restOrderBudgetsBulkResponseTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkResponseTransferMock,
            $this->facade->bulkProcess($this->restOrderBudgetsBulkRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPersistOrderBudget(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createOrderBudgetPersister')
            ->willReturn($this->orderBudgetPersisterMock);

        $this->orderBudgetPersisterMock->expects(static::atLeastOnce())
            ->method('persist')
            ->with($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);

        $this->facade->persistOrderBudget($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);
    }
}
