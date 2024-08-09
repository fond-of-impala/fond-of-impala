<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Communication\Plugin\SplittableCheckoutRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\SplittableCheckoutOrderTypeConnectorFacade;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderTypeQuoteExpanderPluginTest extends Unit
{
    protected RestSplittableCheckoutRequestTransfer|MockObject $restSplittableCheckoutRequestTransferMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected SplittableCheckoutOrderTypeConnectorFacade|MockObject $facadeMock;

    protected OrderTypeQuoteExpanderPlugin $plugin;

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

        $this->facadeMock = $this->getMockBuilder(SplittableCheckoutOrderTypeConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new OrderTypeQuoteExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpandTrue(): void
    {
        $this->facadeMock
            ->expects(static::atLeastOnce())
            ->method('expandQuote')
            ->willReturn($this->quoteTransferMock);

        $this->plugin->expand($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock);
    }
}
