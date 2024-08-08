<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Communication\Plugin\SplittableCheckoutRestApiExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderPreventCustomerEmailsQuoteExpanderPluginTest extends Unit
{
    protected RestSplittableCheckoutRequestTransfer|MockObject $restSplittableCheckoutRequestTransferMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected OrderPreventCustomerEmailsQuoteExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restSplittableCheckoutRequestTransferMock = $this->getMockBuilder(RestSplittableCheckoutRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new OrderPreventCustomerEmailsQuoteExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandTrue(): void
    {
        $array = ['test'];

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('setPreventCustomerOrderConfirmationMails')
            ->with($array)
            ->willReturnSelf();

        $this->restSplittableCheckoutRequestTransferMock
            ->expects(static::atLeastOnce())
            ->method('getPreventCustomerOrderConfirmationMails')
            ->willReturn($array);

        $this->plugin->expand($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock);
    }
}
