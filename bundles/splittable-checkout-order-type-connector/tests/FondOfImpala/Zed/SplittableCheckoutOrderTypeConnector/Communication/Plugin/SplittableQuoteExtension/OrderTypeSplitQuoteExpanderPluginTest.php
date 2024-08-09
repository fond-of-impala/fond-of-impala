<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Communication\Plugin\SplittableQuoteExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderTypeSplitQuoteExpanderPluginTest extends Unit
{
    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected OrderTypeSplitQuoteExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new OrderTypeSplitQuoteExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandTrue(): void
    {
        $array = ['test' => 'pre'];
        $splitKey = 'test';

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getSplitKey')
            ->willReturn($splitKey);

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderTypes')
            ->willReturn($array);

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('setOrderType')
            ->with('pre')
            ->willReturnSelf();

        $this->plugin->expand($this->quoteTransferMock);
    }
}
