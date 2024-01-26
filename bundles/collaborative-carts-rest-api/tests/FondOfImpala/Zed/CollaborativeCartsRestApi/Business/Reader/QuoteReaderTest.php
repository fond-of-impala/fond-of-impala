<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeInterface;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class QuoteReaderTest extends Unit
{
    protected MockObject|CollaborativeCartsRestApiToQuoteFacadeInterface $quoteFacadeMock;

    protected MockObject|QuoteResponseTransfer $quoteResponseTransferMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected QuoteReader $quoteReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteFacadeMock = $this->getMockBuilder(CollaborativeCartsRestApiToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteReader = new QuoteReader($this->quoteFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetByUuid(): void
    {
        $uuid = '0ed29c58-2b94-492c-9bdd-4bb4135a2cf5';

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteByUuid')
            ->with(
                static::callback(
                    static fn (QuoteTransfer $quoteTransfer): bool => $quoteTransfer->getUuid() === $uuid,
                ),
            )->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->quoteReader->getByUuid($uuid),
        );
    }

    /**
     * @return void
     */
    public function testGetByUuidWithNonExistingQuote(): void
    {
        $uuid = '0ed29c58-2b94-492c-9bdd-4bb4135a2cf5';

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteByUuid')
            ->with(
                static::callback(
                    static fn (QuoteTransfer $quoteTransfer): bool => $quoteTransfer->getUuid() === $uuid,
                ),
            )->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn(null);

        $this->quoteResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        static::assertEquals(
            null,
            $this->quoteReader->getByUuid($uuid),
        );
    }
}
