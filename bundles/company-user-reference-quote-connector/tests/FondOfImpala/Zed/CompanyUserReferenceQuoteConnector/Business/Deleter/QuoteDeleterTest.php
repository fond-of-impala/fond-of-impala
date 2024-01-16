<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReaderInterface;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteDeleterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter\QuoteDeleter
     */
    protected $quoteDeleter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteReaderMock = $this->getMockBuilder(QuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCollectionTransferMock = $this->getMockBuilder(QuoteCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteDeleter = new QuoteDeleter($this->quoteReaderMock, $this->quoteFacadeMock);
    }

    /**
     * @return void
     */
    public function testDeleteByCompanyUser(): void
    {
        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('findByCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->quoteCollectionTransferMock);

        $this->quoteCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getQuotes')
            ->willReturn(new ArrayObject([$this->quoteTransferMock]));

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('deleteQuote')
            ->with($this->quoteTransferMock);

        $this->quoteDeleter->deleteByCompanyUser($this->companyUserTransferMock);
    }
}
