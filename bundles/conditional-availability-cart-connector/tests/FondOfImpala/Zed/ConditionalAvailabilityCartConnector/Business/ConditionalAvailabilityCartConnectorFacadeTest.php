<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\QuoteExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\UnavailableSkuReaderInterface;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCartConnectorFacadeTest extends Unit
{
    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected MockObject|ConditionalAvailabilityCartConnectorBusinessFactory $factoryMock;

    protected CartChangeTransfer|MockObject $cartChangeTransferMock;

    protected ConditionalAvailabilityItemExpanderInterface|MockObject $conditionalAvailabilityItemExpanderMock;

    protected ConditionalAvailabilityDeliveryDateCleanerInterface|MockObject $conditionalAvailabilityDeliveryDateCleanerMock;

    protected ConditionalAvailabilityEnsureEarliestDateInterface|MockObject $conditionalAvailabilityEnsureEarliestDateMock;

    protected UnavailableSkuReaderInterface|MockObject $unavailableSkuReaderMock;

    protected ConditionalAvailabilityCartConnectorFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteExpanderMock = $this->getMockBuilder(QuoteExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartChangeTransferMock = $this->getMockBuilder(CartChangeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityItemExpanderMock = $this->getMockBuilder(ConditionalAvailabilityItemExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityDeliveryDateCleanerMock = $this->getMockBuilder(ConditionalAvailabilityDeliveryDateCleanerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityEnsureEarliestDateMock = $this->getMockBuilder(ConditionalAvailabilityEnsureEarliestDateInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unavailableSkuReaderMock = $this->getMockBuilder(UnavailableSkuReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ConditionalAvailabilityCartConnectorFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQuote(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteExpander')
            ->willReturn($this->quoteExpanderMock);

        $this->quoteExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->facade->expandQuote($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandChangeCartItems(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityItemExpander')
            ->willReturn($this->conditionalAvailabilityItemExpanderMock);

        $this->conditionalAvailabilityItemExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->cartChangeTransferMock)
            ->willReturn($this->cartChangeTransferMock);

        static::assertEquals(
            $this->cartChangeTransferMock,
            $this->facade->expandChangedCartItems($this->cartChangeTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testCleanDeliveryDateOnEmptyCart(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityDeliveryDateCleaner')
            ->willReturn($this->conditionalAvailabilityDeliveryDateCleanerMock);

        $this->conditionalAvailabilityDeliveryDateCleanerMock->expects(static::atLeastOnce())
            ->method('cleanDeliveryDate')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->facade->cleanDeliveryDateOnEmptyCart($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testEnsureEarliestDate(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityEnsureEarliestDate')
            ->willReturn($this->conditionalAvailabilityEnsureEarliestDateMock);

        $this->conditionalAvailabilityEnsureEarliestDateMock->expects(static::atLeastOnce())
            ->method('ensureEarliestDate')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->facade->ensureEarliestDate($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetUnavailableSkusByQuote(): void
    {
        $skus = ['foo', 'bar'];

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createUnavailableSkuReader')
            ->willReturn($this->unavailableSkuReaderMock);

        $this->unavailableSkuReaderMock->expects(static::atLeastOnce())
            ->method('getByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($skus);

        static::assertEquals(
            $skus,
            $this->facade->getUnavailableSkusByQuote($this->quoteTransferMock),
        );
    }
}
