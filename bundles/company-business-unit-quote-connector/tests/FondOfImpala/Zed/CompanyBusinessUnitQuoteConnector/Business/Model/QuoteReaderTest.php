<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\CompanyUserReaderInterface
     */
    protected $companyUserReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface
     */
    protected $companyUserReferenceQuoteConnectorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer
     */
    protected $companyBusinessUnitQuoteListRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected $quoteCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer
     */
    protected $companyUserReferenceCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\QuoteReader
     */
    protected $quoteReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceQuoteConnectorFacadeMock = $this->getMockBuilder(
            CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface::class,
        )->disableOriginalConstructor()->getMock();

        $this->companyBusinessUnitQuoteListRequestTransferMock = $this->getMockBuilder(
            CompanyBusinessUnitQuoteListRequestTransfer::class,
        )->disableOriginalConstructor()->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(
            QuoteTransfer::class,
        )->disableOriginalConstructor()->getMock();

        $this->quoteCollectionTransferMock = $this->getMockBuilder(
            QuoteCollectionTransfer::class,
        )->disableOriginalConstructor()->getMock();

        $this->companyUserReferenceCollectionTransferMock = $this->getMockBuilder(
            CompanyUserReferenceCollectionTransfer::class,
        )->disableOriginalConstructor()->getMock();

        $this->quoteReader = new QuoteReader(
            $this->companyUserReaderMock,
            $this->companyUserReferenceQuoteConnectorFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindByCompanyBusinessUnitQuoteListRequest(): void
    {
        $quoteMocks = new ArrayObject([$this->quoteTransferMock]);

        $this->companyUserReaderMock->expects(self::atLeastOnce())
            ->method('getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock)
            ->willReturn($this->companyUserReferenceCollectionTransferMock);

        $this->companyUserReferenceQuoteConnectorFacadeMock->expects(self::atLeastOnce())
            ->method('findQuotesByCompanyUserReferences')
            ->with($this->companyUserReferenceCollectionTransferMock)
            ->willReturn($this->quoteCollectionTransferMock);

        $this->quoteCollectionTransferMock->expects(self::atLeastOnce())
            ->method('getQuotes')
            ->willReturn($quoteMocks);

        $companyBusinessUnitQuoteListTransfer = $this->quoteReader->findByCompanyBusinessUnitQuoteListRequest(
            $this->companyBusinessUnitQuoteListRequestTransferMock,
        );

        self::assertEquals(
            $quoteMocks,
            $companyBusinessUnitQuoteListTransfer->getQuotes(),
        );
    }
}
