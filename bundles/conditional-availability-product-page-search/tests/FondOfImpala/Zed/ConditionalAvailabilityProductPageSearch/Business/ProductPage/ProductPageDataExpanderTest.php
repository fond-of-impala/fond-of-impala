<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ProductPage;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductPageDataExpanderTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ProductPage\ProductPageDataExpander
     */
    protected ProductPageDataExpander $expander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransfers;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    protected MockObject|ProductPageLoadTransfer $productPageLoadTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPayloadTransfer
     */
    protected MockObject|ProductPayloadTransfer $productPayloadTransferMock;

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

        $this->productFacadeMock = $this
            ->getMockBuilder(ConditionalAvailabilityProductPageSearchToProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteTransfers = $this
            ->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPageLoadTransferMock = $this->getMockBuilder(ProductPageLoadTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPayloadTransferMock = $this->getMockBuilder(ProductPayloadTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new ProductPageDataExpander($this->productFacadeMock, $this->conditionalAvailabilityFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageData(): void
    {
        $payloadTransfers = [$this->productPayloadTransferMock];
        $productConcreteTransfers = [$this->productConcreteTransfers];
        $idProductConcrete = 1;
        $channel = 'channel';
        $conditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilities->append($this->conditionalAvailabilityTransferMock);

        $conditionalAvailabilityPeriods = new ArrayObject();
        $conditionalAvailabilityPeriods->append($this->conditionalAvailabilityPeriodTransferMock);

        $this->productPageLoadTransferMock->expects(static::atLeastOnce())
            ->method('getPayloadTransfers')
            ->willReturn($payloadTransfers);

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn($idProductConcrete);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->with($idProductConcrete)
            ->willReturn($productConcreteTransfers);

        $this->productConcreteTransfers->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($idProductConcrete);

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

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->willReturnSelf();

        $productPageLoadTransfer = $this->expander->expandProductPageData($this->productPageLoadTransferMock);
        static::assertEquals(
            $this->productPageLoadTransferMock,
            $productPageLoadTransfer,
        );
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataWithLaterInStock(): void
    {
        $payloadTransfers = [$this->productPayloadTransferMock];
        $productConcreteTransfers = [$this->productConcreteTransfers];
        $idProductConcrete = 1;
        $channel = 'channel';
        $conditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilities->append($this->conditionalAvailabilityTransferMock);

        $conditionalAvailabilityPeriods = new ArrayObject();
        $conditionalAvailabilityPeriods->append($this->conditionalAvailabilityPeriodTransferMock);

        $this->productPageLoadTransferMock->expects(static::atLeastOnce())
            ->method('getPayloadTransfers')
            ->willReturn($payloadTransfers);

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn($idProductConcrete);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->with($idProductConcrete)
            ->willReturn($productConcreteTransfers);

        $this->productConcreteTransfers->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($idProductConcrete);

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
            ->willReturn(0);

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->willReturnSelf();

        $productPageLoadTransfer = $this->expander->expandProductPageData($this->productPageLoadTransferMock);

        static::assertEquals(
            $this->productPageLoadTransferMock,
            $productPageLoadTransfer,
        );
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataWithOutOfStock(): void
    {
        $payloadTransfers = [$this->productPayloadTransferMock];
        $productConcreteTransfers = [$this->productConcreteTransfers];
        $idProductConcrete = 1;
        $channel = 'channel';
        $conditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilities->append($this->conditionalAvailabilityTransferMock);

        $conditionalAvailabilityPeriods = new ArrayObject();
        $conditionalAvailabilityPeriods->append($this->conditionalAvailabilityPeriodTransferMock);
        $conditionalAvailabilityPeriods->append($this->conditionalAvailabilityPeriodTransferMock);

        $this->productPageLoadTransferMock->expects(static::atLeastOnce())
            ->method('getPayloadTransfers')
            ->willReturn($payloadTransfers);

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn($idProductConcrete);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->with($idProductConcrete)
            ->willReturn($productConcreteTransfers);

        $this->productConcreteTransfers->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($idProductConcrete);

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
            ->willReturnOnConsecutiveCalls(-1, -10);

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->willReturnSelf();

        $productPageLoadTransfer = $this->expander->expandProductPageData($this->productPageLoadTransferMock);

        static::assertEquals(
            $this->productPageLoadTransferMock,
            $productPageLoadTransfer,
        );
    }
}
