<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Quote\Business\QuoteFacade;

class CollaborativeCartsRestApiToQuoteFacadeBridgeTest extends Unit
{
    protected CollaborativeCartsRestApiToQuoteFacadeBridge $collaborativeCartsRestApiToQuoteFacadeBridge;

    protected MockObject|QuoteFacade $quoteFacadeMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected MockObject|QuoteResponseTransfer $quoteResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteFacadeMock = $this->getMockBuilder(QuoteFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartsRestApiToQuoteFacadeBridge = new CollaborativeCartsRestApiToQuoteFacadeBridge(
            $this->quoteFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindQuoteByUuid(): void
    {
        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteByUuid')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        static::assertEquals(
            $this->quoteResponseTransferMock,
            $this->collaborativeCartsRestApiToQuoteFacadeBridge->findQuoteByUuid($this->quoteTransferMock),
        );
    }
}
