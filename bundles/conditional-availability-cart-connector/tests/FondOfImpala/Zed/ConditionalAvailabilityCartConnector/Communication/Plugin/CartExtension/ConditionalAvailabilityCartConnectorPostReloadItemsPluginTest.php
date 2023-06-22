<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\CartExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityCartConnectorPostReloadItemsPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\CartExtension\ConditionalAvailabilityCartConnectorPostReloadItemsPlugin
     */
    protected $conditionalAvailabilityCartConnectorPostReloadItemsPlugin;

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

        $this->conditionalAvailabilityCartConnectorPostReloadItemsPlugin = new ConditionalAvailabilityCartConnectorPostReloadItemsPlugin();
        $this->conditionalAvailabilityCartConnectorPostReloadItemsPlugin->setFacade($this->conditionalAvailabilityCartConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testPostReloadItems(): void
    {
        $this->conditionalAvailabilityCartConnectorFacadeMock->expects($this->atLeastOnce())
            ->method('expandQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->conditionalAvailabilityCartConnectorPostReloadItemsPlugin->postReloadItems(
                $this->quoteTransferMock,
            ),
        );
    }
}
