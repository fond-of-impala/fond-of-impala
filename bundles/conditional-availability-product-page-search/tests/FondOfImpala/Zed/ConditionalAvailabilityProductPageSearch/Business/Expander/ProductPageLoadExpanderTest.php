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
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductPageLoadExpanderTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransfer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    protected MockObject|ProductPageLoadTransfer $productPageLoadTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPayloadTransfer
     */
    protected MockObject|ProductPayloadTransfer $productPayloadTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductPageLoadExpander
     */
    protected ProductPageLoadExpander $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->stockStatusGeneratorMock = $this->getMockBuilder(StockStatusGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteTransfer = $this->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPageLoadTransferMock = $this->getMockBuilder(ProductPageLoadTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPayloadTransferMock = $this->getMockBuilder(ProductPayloadTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new ProductPageLoadExpander(
            $this->stockStatusGeneratorMock,
            $this->conditionalAvailabilityFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $idProductAbstract = 1;
        $channel = 'foo';
        $stockStatus = 'bar';

        $this->productPageLoadTransferMock->expects(static::atLeastOnce())
            ->method('getPayloadTransfers')
            ->willReturn([$this->productPayloadTransferMock]);

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn($idProductAbstract);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilitiesByProductAbstractIds')
            ->with([$idProductAbstract])
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $this->conditionalAvailabilityCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilities')
            ->willReturn(new ArrayObject([$this->conditionalAvailabilityTransferMock]));

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getChannel')
            ->willReturn($channel);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->stockStatusGeneratorMock->expects(static::atLeastOnce())
            ->method('generateRawValueByConditionalAvailabilityPeriodCollection')
            ->with($this->conditionalAvailabilityPeriodCollectionTransferMock)
            ->willReturn(ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_IN_STOCK);

        $this->stockStatusGeneratorMock->expects(static::atLeastOnce())
            ->method('generateByRawValueAndChannel')
            ->with(
                ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_IN_STOCK,
                $channel,
            )->willReturn($stockStatus);

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->with([$stockStatus])
            ->willReturnSelf();

        static::assertEquals(
            $this->productPageLoadTransferMock,
            $this->expander->expand($this->productPageLoadTransferMock),
        );
    }
}
