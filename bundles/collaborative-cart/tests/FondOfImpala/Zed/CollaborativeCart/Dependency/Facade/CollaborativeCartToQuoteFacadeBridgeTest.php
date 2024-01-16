<?php

namespace FondOfImpala\Zed\CollaborativeCart\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Quote\Business\QuoteFacadeInterface;

class CollaborativeCartToQuoteFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Quote\Business\QuoteFacadeInterface
     */
    protected $quoteFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteResponseTransfer
     */
    protected $quoteResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeBridge
     */
    protected $collaborativeCartToPermissionFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteFacadeMock = $this->getMockBuilder(QuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartToPermissionFacadeBridge = new CollaborativeCartToQuoteFacadeBridge(
            $this->quoteFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindQuoteById(): void
    {
        $idQuote = 1;

        $this->quoteFacadeMock->expects(self::atLeastOnce())
            ->method('findQuoteById')
            ->with($idQuote)
            ->willReturn($this->quoteResponseTransferMock);

        self::assertEquals(
            $this->quoteResponseTransferMock,
            $this->collaborativeCartToPermissionFacadeBridge->findQuoteById($idQuote),
        );
    }

    /**
     * @return void
     */
    public function testUpdateQuote(): void
    {
        $this->quoteFacadeMock->expects(self::atLeastOnce())
            ->method('updateQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        self::assertEquals(
            $this->quoteResponseTransferMock,
            $this->collaborativeCartToPermissionFacadeBridge->updateQuote($this->quoteTransferMock),
        );
    }
}
