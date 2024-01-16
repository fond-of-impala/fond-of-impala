<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter\QuoteDeleterInterface;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReaderInterface;
use Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;

class CompanyUserReferenceQuoteConnectorFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\CompanyUserReferenceQuoteConnectorBusinessFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReaderInterface
     */
    protected $quoteReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected $quoteCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer
     */
    protected $companyUserReferenceCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter\QuoteDeleterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteDeleterMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\CompanyUserReferenceQuoteConnectorFacade
     */
    protected $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyUserReferenceQuoteConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteReaderMock = $this->getMockBuilder(QuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCollectionTransferMock = $this->getMockBuilder(QuoteCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceCollectionTransferMock = $this->getMockBuilder(CompanyUserReferenceCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteDeleterMock = $this->getMockBuilder(QuoteDeleterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CompanyUserReferenceQuoteConnectorFacade();
        $this->facade->setFactory(
            $this->factoryMock,
        );
    }

    /**
     * @return void
     */
    public function testFindQuotesByCompanyUserReferences(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteReader')
            ->willReturn($this->quoteReaderMock);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('findQuotesByCompanyUserReferences')
            ->with($this->companyUserReferenceCollectionTransferMock)
            ->willReturn($this->quoteCollectionTransferMock);

        static::assertEquals(
            $this->quoteCollectionTransferMock,
            $this->facade->findQuotesByCompanyUserReferences(
                $this->companyUserReferenceCollectionTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteQuotesByCompanyUser(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteDeleter')
            ->willReturn($this->quoteDeleterMock);

        $this->quoteDeleterMock->expects(static::atLeastOnce())
            ->method('deleteByCompanyUser')
            ->with($this->companyUserTransferMock);

        $this->facade->deleteQuotesByCompanyUser($this->companyUserTransferMock);
    }
}
