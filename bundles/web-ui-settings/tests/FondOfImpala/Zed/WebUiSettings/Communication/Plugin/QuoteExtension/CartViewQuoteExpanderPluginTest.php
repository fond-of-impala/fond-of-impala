<?php

namespace FondOfImpala\Zed\WebUiSettings\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\WebUiSettings\Business\WebUiSettingsFacade;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CartViewQuoteExpanderPluginTest extends Unit
{
    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected WebUiSettingsFacade|MockObject $facadeMock;

    protected CartViewQuoteExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(WebUiSettingsFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CartViewQuoteExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('expandQuote')
            ->with($this->quoteTransferMock);

        $this->plugin->expand($this->quoteTransferMock);
    }
}
