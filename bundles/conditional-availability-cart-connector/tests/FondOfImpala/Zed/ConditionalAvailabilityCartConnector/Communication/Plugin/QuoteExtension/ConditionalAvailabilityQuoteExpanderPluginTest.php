<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityQuoteExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\QuoteExtension\ConditionalAvailabilityQuoteExpanderPlugin
     */
    protected $conditionalAvailabilityQuoteExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade
     */
    protected $conditionalAvailabilityCartConnectorFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityQuoteExpanderPlugin = new ConditionalAvailabilityQuoteExpanderPlugin();
        $this->conditionalAvailabilityQuoteExpanderPlugin->setFacade($this->conditionalAvailabilityCartConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->conditionalAvailabilityCartConnectorFacadeMock->expects($this->atLeastOnce())
            ->method('expandQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->conditionalAvailabilityQuoteExpanderPlugin->expand(
                $this->quoteTransferMock,
            ),
        );
    }
}
