<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication\Plugin\CheckoutExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\ConditionalAvailabilityCheckoutConnector\ConditionalAvailabilityCheckoutConnectorConstants;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication\ConditionalAvailabilityCheckoutConnectorCommunicationFactory;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeInterface;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCheckoutPreConditionPluginTest extends Unit
{
    protected ConditionalAvailabilityCheckoutConnectorCommunicationFactory|MockObject $factoryMock;

    protected MockObject|ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeInterface $conditionalAvailabilityCartConnectorFacadeMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected CheckoutResponseTransfer|MockObject $checkoutResponseTransferMock;

    protected ConditionalAvailabilityCheckoutPreConditionPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutResponseTransferMock = $this->getMockBuilder(CheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ConditionalAvailabilityCheckoutPreConditionPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testCheckCondition(): void
    {
        $skus = [];

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityCartConnectorFacade')
            ->willReturn($this->conditionalAvailabilityCartConnectorFacadeMock);

        $this->conditionalAvailabilityCartConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('getUnavailableSkusByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($skus);

        $this->checkoutResponseTransferMock->expects(static::never())
            ->method('addError');

        $this->checkoutResponseTransferMock->expects(static::never())
            ->method('setIsSuccess');

        static::assertTrue(
            $this->plugin->checkCondition(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCheckConditionWithErrors(): void
    {
        $skus = ['foo'];

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityCartConnectorFacade')
            ->willReturn($this->conditionalAvailabilityCartConnectorFacadeMock);

        $this->conditionalAvailabilityCartConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('getUnavailableSkusByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($skus);

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static fn (
                        CheckoutErrorTransfer $checkoutErrorTransfer
                    ) => $checkoutErrorTransfer->getErrorType() === ConditionalAvailabilityCheckoutConnectorConstants::ERROR_TYPE_CONDITIONAL_AVAILABILITY
                        && $checkoutErrorTransfer->getErrorCode() === ConditionalAvailabilityCheckoutConnectorConstants::ERROR_CODE_UNAVAILABLE_PRODUCT
                        && $checkoutErrorTransfer->getMessage() === ConditionalAvailabilityCheckoutConnectorConstants::MESSAGE_UNAVAILABLE_PRODUCT
                        && $checkoutErrorTransfer->getParameters()[ConditionalAvailabilityCheckoutConnectorConstants::PARAMETER_PRODUCT_SKU] === $skus[0]
                ),
            )->willReturn($this->checkoutResponseTransferMock);

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsSuccess')
            ->with(false)
            ->willReturn($this->checkoutResponseTransferMock);

        static::assertFalse(
            $this->plugin->checkCondition(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }
}
