<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\CartExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCartConnectorPostReloadItemsPluginTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorFacade|MockObject $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\CartExtension\ConditionalAvailabilityCartConnectorPostReloadItemsPlugin
     */
    protected ConditionalAvailabilityCartConnectorPostReloadItemsPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ConditionalAvailabilityCartConnectorPostReloadItemsPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testPostReloadItems(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('expandQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->plugin->postReloadItems(
                $this->quoteTransferMock,
            ),
        );
    }
}
