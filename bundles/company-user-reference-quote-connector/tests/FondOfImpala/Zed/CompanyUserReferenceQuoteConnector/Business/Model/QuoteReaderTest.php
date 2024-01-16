<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepository;
use Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;

class QuoteReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepository
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface
     */
    protected $quoteFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected $quoteCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer
     */
    protected $companyUserReferenceCollectionTransferMock;

    /**
     * @var array<string>
     */
    protected $companyUserReferences;

    /**
     * @var array<int>
     */
    protected $quoteIds;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReader
     */
    protected $quoteReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserReferenceQuoteConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCollectionTransferMock = $this->getMockBuilder(QuoteCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceCollectionTransferMock = $this->getMockBuilder(CompanyUserReferenceCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferences = ['STORE--CU-1'];
        $this->quoteIds = [1, 2, 5];

        $this->quoteReader = new QuoteReader(
            $this->repositoryMock,
            $this->quoteFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindQuotesByCompanyUserReferences(): void
    {
        $self = $this;

        $this->companyUserReferenceCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferences')
            ->willReturn($this->companyUserReferences);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findQuoteIdsByCompanyUserReferences')
            ->with($this->companyUserReferences)
            ->willReturn($this->quoteIds);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('getQuoteCollection')
            ->with(
                static::callback(static function (QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer) use ($self) {
                    return $self->quoteIds === $quoteCriteriaFilterTransfer->getQuoteIds();
                }),
            )->willReturn($this->quoteCollectionTransferMock);

        $quoteCollectionTransfer = $this->quoteReader->findQuotesByCompanyUserReferences(
            $this->companyUserReferenceCollectionTransferMock,
        );

        static::assertEquals(
            $this->quoteCollectionTransferMock,
            $quoteCollectionTransfer,
        );
    }

    /**
     * @return void
     */
    public function testFindQuotesByCompanyUserReferencesWithEmptyResult(): void
    {
        $this->companyUserReferenceCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferences')
            ->willReturn($this->companyUserReferences);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findQuoteIdsByCompanyUserReferences')
            ->with($this->companyUserReferences)
            ->willReturn([]);

        $quoteCollectionTransfer = $this->quoteReader->findQuotesByCompanyUserReferences(
            $this->companyUserReferenceCollectionTransferMock,
        );

        static::assertCount(0, $quoteCollectionTransfer->getQuotes());
    }

    /**
     * @return void
     */
    public function testFindQuotesByCompanyUser(): void
    {
        $companyUserReference = 'FOO--CU-1';
        $quoteIds = [1];

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findQuoteIdsByCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($quoteIds);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('getQuoteCollection')
            ->with(
                static::callback(
                    static function (QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer) use ($quoteIds) {
                        return $quoteIds === $quoteCriteriaFilterTransfer->getQuoteIds();
                    },
                ),
            )->willReturn($this->quoteCollectionTransferMock);

        static::assertEquals(
            $this->quoteCollectionTransferMock,
            $this->quoteReader->findByCompanyUser($this->companyUserTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindQuotesByCompanyUserWithoutCompanyUserReference(): void
    {
        $companyUserReference = null;

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->repositoryMock->expects(static::never())
            ->method('findQuoteIdsByCompanyUserReference');

        $this->quoteFacadeMock->expects(static::never())
            ->method('getQuoteCollection');

        $quoteCollectionTransfer = $this->quoteReader->findByCompanyUser($this->companyUserTransferMock);

        static::assertCount(
            0,
            $quoteCollectionTransfer->getQuotes(),
        );
    }
}
