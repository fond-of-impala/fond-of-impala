<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCartConnectorFacadeTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorBusinessFactory&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityCartConnectorBusinessFactory $factoryMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpanderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityExpanderInterface|MockObject $conditionalAvailabilityExpanderMock;

    /**
     * @var (\Generated\Shared\Transfer\CartChangeTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CartChangeTransfer|MockObject $cartChangeTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityItemExpanderInterface|MockObject $conditionalAvailabilityItemExpanderMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityDeliveryDateCleanerInterface|MockObject $conditionalAvailabilityDeliveryDateCleanerMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityEnsureEarliestDateInterface|MockObject $conditionalAvailabilityEnsureEarliestDateMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade
     */
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

        $this->conditionalAvailabilityExpanderMock = $this->getMockBuilder(ConditionalAvailabilityExpanderInterface::class)
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

        $this->facade = new ConditionalAvailabilityCartConnectorFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQuote(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityExpander')
            ->willReturn($this->conditionalAvailabilityExpanderMock);

        $this->conditionalAvailabilityExpanderMock->expects(static::atLeastOnce())
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
}
