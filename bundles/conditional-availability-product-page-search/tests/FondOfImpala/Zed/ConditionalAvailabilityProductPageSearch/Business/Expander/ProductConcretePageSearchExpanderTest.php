<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductConcretePageSearchExpander
     */
    protected ProductConcretePageSearchExpander $expander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    protected MockObject|ProductConcretePageSearchTransfer $productConcretePageSearchTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

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

        $this->expander = new ProductConcretePageSearchExpander($this->conditionalAvailabilityFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageData(): void
    {
        $sku = 'sku';
        $channel = 'channel';
        $conditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilities->append($this->conditionalAvailabilityTransferMock);

        $conditionalAvailabilityPeriods = new ArrayObject();
        $conditionalAvailabilityPeriods->append($this->conditionalAvailabilityPeriodTransferMock);

        $this->productConcretePageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $this->conditionalAvailabilityCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilities')
            ->willReturn($conditionalAvailabilities);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($conditionalAvailabilityPeriods);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn('1970-01-01');

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getChannel')
            ->willReturn($channel);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(1);

        $this->productConcretePageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->willReturnSelf();

        $productConcretePageSearchTransfer = $this->expander
            ->expandProductConcretePageSearchTransferWithStockStatus($this->productConcretePageSearchTransferMock);

        static::assertEquals(
            $this->productConcretePageSearchTransferMock,
            $productConcretePageSearchTransfer,
        );
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataWithOutOfStock(): void
    {
        $sku = 'sku';
        $channel = 'channel';
        $conditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilities->append($this->conditionalAvailabilityTransferMock);

        $conditionalAvailabilityPeriods = new ArrayObject();
        $conditionalAvailabilityPeriods->append($this->conditionalAvailabilityPeriodTransferMock);

        $this->productConcretePageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $this->conditionalAvailabilityCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilities')
            ->willReturn($conditionalAvailabilities);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($conditionalAvailabilityPeriods);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn('1970-01-01');

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getChannel')
            ->willReturn($channel);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(-1);

        $this->productConcretePageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->willReturnSelf();

        $productConcretePageSearchTransfer = $this->expander
            ->expandProductConcretePageSearchTransferWithStockStatus($this->productConcretePageSearchTransferMock);

        static::assertEquals(
            $this->productConcretePageSearchTransferMock,
            $productConcretePageSearchTransfer,
        );
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataWithLaterInStock(): void
    {
        $sku = 'sku';
        $channel = 'channel';
        $conditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilities->append($this->conditionalAvailabilityTransferMock);

        $conditionalAvailabilityPeriods = new ArrayObject();
        $conditionalAvailabilityPeriods->append($this->conditionalAvailabilityPeriodTransferMock);
        $conditionalAvailabilityPeriods->append($this->conditionalAvailabilityPeriodTransferMock);

        $this->productConcretePageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $this->conditionalAvailabilityCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilities')
            ->willReturn($conditionalAvailabilities);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($conditionalAvailabilityPeriods);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn('1970-01-01');

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getChannel')
            ->willReturn($channel);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturnOnConsecutiveCalls(1, 10);

        $this->productConcretePageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->willReturnSelf();

        $productConcretePageSearchTransfer = $this->expander
            ->expandProductConcretePageSearchTransferWithStockStatus($this->productConcretePageSearchTransferMock);

        static::assertEquals(
            $this->productConcretePageSearchTransferMock,
            $productConcretePageSearchTransfer,
        );
    }
}
