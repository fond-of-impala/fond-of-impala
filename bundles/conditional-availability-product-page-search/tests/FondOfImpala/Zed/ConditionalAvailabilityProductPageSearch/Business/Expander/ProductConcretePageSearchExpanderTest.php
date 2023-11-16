<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Shared\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConfig;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductConcretePageSearchExpanderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected StockStatusGeneratorInterface|MockObject $stockStatusGeneratorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToProductFacadeInterface $conditionalAvailabilityFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    protected MockObject|ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    protected MockObject|ConditionalAvailabilityTransfer $conditionalAvailabilityTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer
     */
    protected MockObject|ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer
     */
    protected MockObject|ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    protected MockObject|ProductConcretePageSearchTransfer $productConcretePageSearchTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductConcretePageSearchExpander
     */
    protected ProductConcretePageSearchExpander $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->stockStatusGeneratorMock = $this->getMockBuilder(StockStatusGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this
            ->getMockBuilder(ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCollectionTransferMock = $this
            ->getMockBuilder(ConditionalAvailabilityCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this
            ->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodCollectionTransferMock = $this
            ->getMockBuilder(ConditionalAvailabilityPeriodCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMock = $this
            ->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcretePageSearchTransferMock = $this
            ->getMockBuilder(ProductConcretePageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new ProductConcretePageSearchExpander(
            $this->stockStatusGeneratorMock,
            $this->conditionalAvailabilityFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testExpandProductPageData(): void
    {
        $sku = 'sku';
        $channel = 'foo';
        $stockStatus = 'bar';

        $this->productConcretePageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $this->conditionalAvailabilityCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilities')
            ->willReturn(new ArrayObject([$this->conditionalAvailabilityTransferMock]));

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getChannel')
            ->willReturn($channel);

        $this->stockStatusGeneratorMock->expects(static::atLeastOnce())
            ->method('generateRawValueByConditionalAvailabilityPeriodCollection')
            ->with($this->conditionalAvailabilityPeriodCollectionTransferMock)
            ->willReturn(ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_IN_STOCK);

        $this->stockStatusGeneratorMock->expects(static::atLeastOnce())
            ->method('generateByRawValueAndChannel')
            ->with(ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_IN_STOCK, $channel)
            ->willReturn($stockStatus);

        $this->productConcretePageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->with([$stockStatus])
            ->willReturnSelf();

        static::assertEquals(
            $this->productConcretePageSearchTransferMock,
            $this->expander->expand($this->productConcretePageSearchTransferMock),
        );
    }
}
