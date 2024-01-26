<?php

namespace FondOfImpala\Zed\CartValidation\Communication\Plugin\CartExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CartValidation\Business\CartValidationFacade;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ClearQuoteValidationMessagesPostReloadItemsPluginTest extends Unit
{
    protected MockObject|CartValidationFacade $cartValidationFacadeMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected ClearQuoteValidationMessagesPostReloadItemsPlugin $plugin;

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

        $this->plugin = new ClearQuoteValidationMessagesPostReloadItemsPlugin();
        $this->plugin->setFacade($this->cartValidationFacadeMock);
    }

    /**
     * @return void
     */
    public function testPostReloadItems(): void
    {
        $this->cartValidationFacadeMock->expects(static::atLeastOnce())
            ->method('clearQuoteValidationMessages')
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
