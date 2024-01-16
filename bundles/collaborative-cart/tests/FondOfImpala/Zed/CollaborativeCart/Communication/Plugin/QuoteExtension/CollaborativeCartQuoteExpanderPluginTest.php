<?php

namespace FondOfImpala\Zed\CollaborativeCart\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Business\CollaborativeCartFacade;
use Generated\Shared\Transfer\QuoteTransfer;

class CollaborativeCartQuoteExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Business\CollaborativeCartFacade
     */
    protected $collaborativeCartFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Communication\Plugin\QuoteExtension\CollaborativeCartQuoteExpanderPlugin
     */
    protected $collaborativeCartQuoteExpanderPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->collaborativeCartFacadeMock = $this->getMockBuilder(CollaborativeCartFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartQuoteExpanderPlugin = new CollaborativeCartQuoteExpanderPlugin();
        $this->collaborativeCartQuoteExpanderPlugin->setFacade($this->collaborativeCartFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->collaborativeCartFacadeMock->expects(self::atLeastOnce())
            ->method('expandQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        self::assertEquals(
            $this->quoteTransferMock,
            $this->collaborativeCartQuoteExpanderPlugin->expand($this->quoteTransferMock),
        );
    }
}
