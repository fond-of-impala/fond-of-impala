<?php

namespace FondOfImpala\Zed\CartValidation\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CartValidation\Business\CartValidationFacade;
use Generated\Shared\Transfer\QuoteTransfer;

class ClearQuoteValidationMessagesQuoteExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CartValidation\Business\CartValidationFacade
     */
    protected $cartValidationFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfImpala\Zed\CartValidation\Communication\Plugin\QuoteExtension\ClearQuoteValidationMessagesQuoteExpanderPlugin
     */
    protected $plugin;

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

        $this->plugin = new ClearQuoteValidationMessagesQuoteExpanderPlugin();
        $this->plugin->setFacade($this->cartValidationFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->cartValidationFacadeMock->expects(static::atLeastOnce())
            ->method('clearQuoteValidationMessages')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->plugin->expand($this->quoteTransferMock),
        );
    }
}
