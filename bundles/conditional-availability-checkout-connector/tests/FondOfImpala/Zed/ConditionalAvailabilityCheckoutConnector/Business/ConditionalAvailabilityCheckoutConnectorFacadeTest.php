<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Model\AvailabilitiesCheckerInterface;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityCheckoutConnectorFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorFacade
     */
    protected $conditionalAvailabilityCheckoutConnectorFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorBusinessFactory
     */
    protected $conditionalAvailabilityCheckoutConnectorBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    protected $checkoutResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Model\AvailabilitiesCheckerInterface
     */
    protected $availabilitiesCheckerInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityCheckoutConnectorBusinessFactoryMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutResponseTransferMock = $this->getMockBuilder(CheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->availabilitiesCheckerInterfaceMock = $this->getMockBuilder(AvailabilitiesCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCheckoutConnectorFacade = new ConditionalAvailabilityCheckoutConnectorFacade();
        $this->conditionalAvailabilityCheckoutConnectorFacade->setFactory($this->conditionalAvailabilityCheckoutConnectorBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testCheckAvailabilities(): void
    {
        $this->conditionalAvailabilityCheckoutConnectorBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createAvailabilitiesChecker')
            ->willReturn($this->availabilitiesCheckerInterfaceMock);

        $this->availabilitiesCheckerInterfaceMock->expects($this->atLeastOnce())
            ->method('check')
            ->with($this->quoteTransferMock, $this->checkoutResponseTransferMock)
            ->willReturn(true);

        $this->assertTrue(
            $this->conditionalAvailabilityCheckoutConnectorFacade->checkAvailabilities(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }
}
