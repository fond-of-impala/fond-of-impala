<?php

namespace FondOfImpala\Glue\OrderConfirmationRecipientsOverride\Plugin\SplittableCheckoutRestApiExtension;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutTransfer;
use Generated\Shared\Transfer\SplittableCheckoutTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderPreventCustomerEmailsRestSplittableCheckoutExpanderPluginTest extends Unit
{
    protected SplittableCheckoutTransfer|MockObject $splittableCheckoutTransferMock;

    protected RestSplittableCheckoutTransfer|MockObject $restSplittableCheckoutTransferMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected OrderPreventCustomerEmailsRestSplittableCheckoutExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->splittableCheckoutTransferMock = $this->getMockBuilder(SplittableCheckoutTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restSplittableCheckoutTransferMock = $this->getMockBuilder(RestSplittableCheckoutTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new OrderPreventCustomerEmailsRestSplittableCheckoutExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandTrue(): void
    {
        $quotes = new ArrayObject();
        $quotes->append($this->quoteTransferMock);
        $quotes->append($this->quoteTransferMock);

        $this->splittableCheckoutTransferMock
            ->expects(static::atLeastOnce())
            ->method('getSplittedQuotes')
            ->willReturn($quotes);

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getPreventCustomerOrderConfirmationMail')
            ->willReturnOnConsecutiveCalls(true, false);

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getSplitKey')
            ->willReturnOnConsecutiveCalls('2024-01-01', '2024-01-05');

        $this->restSplittableCheckoutTransferMock
            ->expects(static::atLeastOnce())
            ->method('setPreventCustomerOrderConfirmationMails')
            ->with([
                '2024-01-01' => true,
                '2024-01-05' => false,
            ])
            ->willReturnSelf();

        $this->plugin->expand($this->splittableCheckoutTransferMock, $this->restSplittableCheckoutTransferMock);
    }
}
