<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Communication\Plugin\SplittableQuoteExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderPreventCustomerEmailSplitQuoteExpanderPluginTest extends Unit
{
    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected OrderPreventCustomerEmailSplitQuoteExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new OrderPreventCustomerEmailSplitQuoteExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandTrue(): void
    {
        $array = ['test' => '123'];
        $splitKey = 'test';

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getSplitKey')
            ->willReturn($splitKey);

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getPreventCustomerOrderConfirmationMails')
            ->willReturn($array);

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('setPreventCustomerOrderConfirmationMail')
            ->with('123')
            ->willReturnSelf();

        $this->plugin->expand($this->quoteTransferMock);
    }
}
