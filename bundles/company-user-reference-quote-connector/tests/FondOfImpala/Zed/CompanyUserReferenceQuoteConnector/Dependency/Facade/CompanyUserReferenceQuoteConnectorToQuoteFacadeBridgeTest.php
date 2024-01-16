<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Quote\Business\QuoteFacadeInterface;

class CompanyUserReferenceQuoteConnectorToQuoteFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Quote\Business\QuoteFacadeInterface
     */
    protected $quoteFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCriteriaFilterTransfer
     */
    protected $quoteCriteriaFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected $quoteCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteFacadeMock = $this->getMockBuilder(QuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCriteriaFilterTransferMock = $this->getMockBuilder(QuoteCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCollectionTransferMock = $this->getMockBuilder(QuoteCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CompanyUserReferenceQuoteConnectorToQuoteFacadeBridge(
            $this->quoteFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetQuoteCollection(): void
    {
        $this->quoteFacadeMock->expects(self::atLeastOnce())
            ->method('getQuoteCollection')
            ->with($this->quoteCriteriaFilterTransferMock)
            ->willReturn($this->quoteCollectionTransferMock);

        self::assertEquals(
            $this->quoteCollectionTransferMock,
            $this->bridge->getQuoteCollection(
                $this->quoteCriteriaFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteQuote(): void
    {
        $this->quoteFacadeMock->expects(self::atLeastOnce())
            ->method('deleteQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        self::assertEquals(
            $this->quoteResponseTransferMock,
            $this->bridge->deleteQuote($this->quoteTransferMock),
        );
    }
}
