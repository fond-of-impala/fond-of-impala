<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityCartConnectorFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade
     */
    protected $conditionalAvailabilityCartConnectorFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorBusinessFactory
     */
    protected $conditionalAvailabilityCartConnectorBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpanderInterface
     */
    protected $conditionalAvailabilityExpanderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CartChangeTransfer
     */
    protected $cartChangeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface
     */
    protected $conditionalAvailabilityItemExpanderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface
     */
    protected $conditionalAvailabilityDeliveryDateCleanerInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface
     */
    protected $conditionalAvailabilityEnsureEarliestDateInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorBusinessFactoryMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityExpanderInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartChangeTransferMock = $this->getMockBuilder(CartChangeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityItemExpanderInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityItemExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityDeliveryDateCleanerInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityDeliveryDateCleanerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityEnsureEarliestDateInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityEnsureEarliestDateInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorFacade = new ConditionalAvailabilityCartConnectorFacade();
        $this->conditionalAvailabilityCartConnectorFacade->setFactory($this->conditionalAvailabilityCartConnectorBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQuote(): void
    {
        $this->conditionalAvailabilityCartConnectorBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityExpander')
            ->willReturn($this->conditionalAvailabilityExpanderInterfaceMock);

        $this->conditionalAvailabilityExpanderInterfaceMock->expects($this->atLeastOnce())
            ->method('expand')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->conditionalAvailabilityCartConnectorFacade->expandQuote(
                $this->quoteTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandChangeCartItems(): void
    {
        $this->conditionalAvailabilityCartConnectorBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityItemExpander')
            ->willReturn($this->conditionalAvailabilityItemExpanderInterfaceMock);

        $this->conditionalAvailabilityItemExpanderInterfaceMock->expects($this->atLeastOnce())
            ->method('expand')
            ->with($this->cartChangeTransferMock)
            ->willReturn($this->cartChangeTransferMock);

        $this->assertInstanceOf(
            CartChangeTransfer::class,
            $this->conditionalAvailabilityCartConnectorFacade->expandChangedCartItems(
                $this->cartChangeTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCleanDeliveryDateOnEmptyCart(): void
    {
        $this->conditionalAvailabilityCartConnectorBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityDeliveryDateCleaner')
            ->willReturn($this->conditionalAvailabilityDeliveryDateCleanerInterfaceMock);

        $this->conditionalAvailabilityDeliveryDateCleanerInterfaceMock->expects($this->atLeastOnce())
            ->method('cleanDeliveryDate')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->conditionalAvailabilityCartConnectorFacade->cleanDeliveryDateOnEmptyCart(
                $this->quoteTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testEnsureEarliestDate(): void
    {
        $this->conditionalAvailabilityCartConnectorBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityEnsureEarliestDate')
            ->willReturn($this->conditionalAvailabilityEnsureEarliestDateInterfaceMock);

        $this->conditionalAvailabilityEnsureEarliestDateInterfaceMock->expects($this->atLeastOnce())
            ->method('ensureEarliestDate')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->conditionalAvailabilityCartConnectorFacade->ensureEarliestDate(
                $this->quoteTransferMock,
            ),
        );
    }
}
