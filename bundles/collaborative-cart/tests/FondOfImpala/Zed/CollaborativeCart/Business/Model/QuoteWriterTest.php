<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class QuoteWriterTest extends Unit
{
    protected MockObject|CollaborativeCartToQuoteFacadeInterface $quoteFacadeMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected MockObject|QuoteResponseTransfer $quoteResponseTransferMock;

    protected QuoteWriter $quoteWriter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteFacadeMock = $this->getMockBuilder(CollaborativeCartToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteWriter = new QuoteWriter($this->quoteFacadeMock);
    }

    /**
     * @return void
     */
    public function testUpdateWithError(): void
    {
        $this->quoteFacadeMock->expects(self::atLeastOnce())
            ->method('updateQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(self::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn(null);

        $this->quoteResponseTransferMock->expects(self::never())
            ->method('getIsSuccessful');

        self::assertEquals(
            null,
            $this->quoteWriter->update($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->quoteFacadeMock->expects(self::atLeastOnce())
            ->method('updateQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(self::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMock->expects(self::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        self::assertEquals(
            $this->quoteTransferMock,
            $this->quoteWriter->update($this->quoteTransferMock),
        );
    }
}
