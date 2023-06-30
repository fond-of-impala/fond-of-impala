<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Checker\AvailabilitiesCheckerInterface;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCheckoutConnectorFacadeTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorBusinessFactory&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCheckoutConnectorBusinessFactory|MockObject $factoryMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CheckoutResponseTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutResponseTransfer|MockObject $checkoutResponseTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Checker\AvailabilitiesCheckerInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|AvailabilitiesCheckerInterface $availabilitiesCheckerMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorFacade
     */
    protected ConditionalAvailabilityCheckoutConnectorFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorBusinessFactory::class)
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

        $this->facade = new ConditionalAvailabilityCheckoutConnectorFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testCheckAvailabilities(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createAvailabilitiesChecker')
            ->willReturn($this->availabilitiesCheckerMock);

        $this->availabilitiesCheckerMock->expects(static::atLeastOnce())
            ->method('check')
            ->with($this->quoteTransferMock, $this->checkoutResponseTransferMock)
            ->willReturn(true);

        static::assertTrue(
            $this->facade->checkAvailabilities(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }
}
