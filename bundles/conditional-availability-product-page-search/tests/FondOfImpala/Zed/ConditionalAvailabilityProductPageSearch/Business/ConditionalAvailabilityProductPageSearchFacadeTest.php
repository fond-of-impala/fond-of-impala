<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductConcretePageSearchExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductPageLoadExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger\StockStatusTriggerInterface;
use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityProductPageSearchFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchBusinessFactory
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchBusinessFactory $factoryMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchFacade
     */
    protected ConditionalAvailabilityProductPageSearchFacade $facade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface
     */
    protected MockObject|ProductAbstractReaderInterface $productAbstractReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductPageLoadExpanderInterface
     */
    protected MockObject|ProductPageLoadExpanderInterface $productPageLoadExpanderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    protected MockObject|ProductPageLoadTransfer $productPageLoadTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductConcretePageSearchExpanderInterface
     */
    protected MockObject|ProductConcretePageSearchExpanderInterface $productConcretePageSearchExpanderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    protected MockObject|ProductConcretePageSearchTransfer $productConcretePageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger\StockStatusTriggerInterface
     */
    protected MockObject|StockStatusTriggerInterface $stockStatusTriggerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractReaderMock = $this->getMockBuilder(ProductAbstractReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcretePageSearchExpanderMock = $this->getMockBuilder(ProductConcretePageSearchExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPageLoadExpanderMock = $this->getMockBuilder(ProductPageLoadExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPageLoadTransferMock = $this->getMockBuilder(ProductPageLoadTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcretePageSearchExpanderMock = $this->getMockBuilder(ProductConcretePageSearchExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcretePageSearchTransferMock = $this->getMockBuilder(ProductConcretePageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->stockStatusTriggerMock = $this->getMockBuilder(StockStatusTriggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ConditionalAvailabilityProductPageSearchFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageData(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductPageLoadExpander')
            ->willReturn($this->productPageLoadExpanderMock);

        $this->productPageLoadExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->productPageLoadTransferMock)
            ->willReturn($this->productPageLoadTransferMock);

        $productPageLoadTransfer = $this->facade->expandProductPageData($this->productPageLoadTransferMock);

        static::assertEquals($this->productPageLoadTransferMock, $productPageLoadTransfer);
    }

    /**
     * @return void
     */
    public function testExpandProductConcretePageSearchTransferWithStockStatus(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductConcretePageSearchExpander')
            ->willReturn($this->productConcretePageSearchExpanderMock);

        $this->productConcretePageSearchExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->productConcretePageSearchTransferMock)
            ->willReturn($this->productConcretePageSearchTransferMock);

        $productConcretePageSearchTransferMock = $this->facade
            ->expandProductConcretePageSearchTransferWithStockStatus($this->productConcretePageSearchTransferMock);

        static::assertEquals($this->productConcretePageSearchTransferMock, $productConcretePageSearchTransferMock);
    }

    /**
     * @return void
     */
    public function testTriggerStockStatus(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createStockStatusTrigger')
            ->willReturn($this->stockStatusTriggerMock);

        $this->stockStatusTriggerMock->expects(static::atLeastOnce())
            ->method('trigger');

        $this->facade->triggerStockStatus();
    }
}
