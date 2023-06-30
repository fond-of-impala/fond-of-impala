<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication\Plugin\CheckoutExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Checker\AvailabilitiesCheckerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorFacade;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityCheckoutPreConditionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication\Plugin\CheckoutExtension\ConditionalAvailabilityCheckoutPreConditionPlugin
     */
    protected $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    protected $checkoutResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Checker\AvailabilitiesCheckerInterface
     */
    protected $availabilitiesCheckerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorFacade
     */
    protected $facadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutResponseTransferMock = $this->getMockBuilder(CheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->availabilitiesCheckerMock = $this->getMockBuilder(AvailabilitiesCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ConditionalAvailabilityCheckoutPreConditionPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testCheckCondition(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('checkAvailabilities')
            ->with($this->quoteTransferMock, $this->checkoutResponseTransferMock)
            ->willReturn(true);

        static::assertTrue(
            $this->plugin->checkCondition(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }
}
