<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication\Plugin\CheckoutExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorFacade;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Model\AvailabilitiesCheckerInterface;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityCheckoutPreConditionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication\Plugin\CheckoutExtension\ConditionalAvailabilityCheckoutPreConditionPlugin
     */
    protected $conditionalAvailabilityCheckoutPreConditionPlugin;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorFacade
     */
    protected $conditionalAvailabilityCheckoutConnectorFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityCheckoutConnectorFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorFacade::class)
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

        $this->conditionalAvailabilityCheckoutPreConditionPlugin = new ConditionalAvailabilityCheckoutPreConditionPlugin();
        $this->conditionalAvailabilityCheckoutPreConditionPlugin->setFacade($this->conditionalAvailabilityCheckoutConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testCheckCondition(): void
    {
        $this->conditionalAvailabilityCheckoutConnectorFacadeMock->expects($this->atLeastOnce())
            ->method('checkAvailabilities')
            ->with($this->quoteTransferMock, $this->checkoutResponseTransferMock)
            ->willReturn(true);

        $this->assertTrue(
            $this->conditionalAvailabilityCheckoutPreConditionPlugin->checkCondition(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }
}
