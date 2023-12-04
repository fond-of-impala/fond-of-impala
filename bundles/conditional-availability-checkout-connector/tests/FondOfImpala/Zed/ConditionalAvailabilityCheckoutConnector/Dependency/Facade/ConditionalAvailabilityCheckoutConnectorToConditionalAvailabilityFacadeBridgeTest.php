<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacadeInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeBridgeTest extends Unit
{
    protected ConditionalAvailabilityCartConnectorFacadeInterface|MockObject $facadeMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetUnavailableSkusByQuote(): void
    {
        $skus = ['foo', 'bar'];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getUnavailableSkusByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($skus);

        static::assertEquals($skus, $this->bridge->getUnavailableSkusByQuote($this->quoteTransferMock));
    }
}
