<?php

namespace FondOfImpala\Zed\CartValidation\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CartValidation\Business\CartValidationFacade;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ClearQuoteItemValidationMessagesQuoteExpanderPluginTest extends Unit
{
    protected MockObject|CartValidationFacade $cartValidationFacadeMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected ClearQuoteItemValidationMessagesQuoteExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->cartValidationFacadeMock = $this->getMockBuilder(CartValidationFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ClearQuoteItemValidationMessagesQuoteExpanderPlugin();
        $this->plugin->setFacade($this->cartValidationFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->cartValidationFacadeMock->expects(static::atLeastOnce())
            ->method('clearQuoteItemValidationMessages')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->plugin->expand($this->quoteTransferMock),
        );
    }
}
