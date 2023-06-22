<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade;
use Generated\Shared\Transfer\QuoteTransfer;

class EnsureEarliestDateQuoteWritePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\QuoteExtension\EnsureEarliestDateQuoteWritePlugin
     */
    protected $ensureEarliestDateQuoteWritePlugin;

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

        $this->ensureEarliestDateQuoteWritePlugin = new EnsureEarliestDateQuoteWritePlugin();
        $this->ensureEarliestDateQuoteWritePlugin->setFacade($this->conditionalAvailabilityCartConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testExecute(): void
    {
        $this->conditionalAvailabilityCartConnectorFacadeMock->expects($this->atLeastOnce())
            ->method('ensureEarliestDate')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->ensureEarliestDateQuoteWritePlugin->execute(
                $this->quoteTransferMock,
            ),
        );
    }
}
