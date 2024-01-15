<?php

namespace FondOfImpala\Client\CompanyUserQuote;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserQuote\Zed\CompanyUserQuoteStubInterface;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;

class CompanyUserQuoteClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyUserQuote\CompanyUserQuoteClient
     */
    protected $companyUserQuoteClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUserQuote\CompanyUserQuoteFactory
     */
    protected $companyUserQuoteFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCriteriaFilterTransfer
     */
    protected $quoteCriteriaFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUserQuote\Zed\CompanyUserQuoteStubInterface
     */
    protected $companyUserQuoteStubInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected $quoteCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserQuoteFactoryMock = $this->getMockBuilder(CompanyUserQuoteFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCriteriaFilterTransferMock = $this->getMockBuilder(QuoteCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteStubInterfaceMock = $this->getMockBuilder(CompanyUserQuoteStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCollectionTransferMock = $this->getMockBuilder(QuoteCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteClient = new CompanyUserQuoteClient();
        $this->companyUserQuoteClient->setFactory($this->companyUserQuoteFactoryMock);
    }

    /**
     * @return void
     */
    public function testGetCompanyUserQuoteCollectionByCriteria(): void
    {
        $this->companyUserQuoteFactoryMock->expects($this->atLeastOnce())
            ->method('createZedCompanyUserQuoteStub')
            ->willReturn($this->companyUserQuoteStubInterfaceMock);

        $this->companyUserQuoteStubInterfaceMock->expects($this->atLeastOnce())
            ->method('getCompanyUserQuoteCollectionByCriteria')
            ->with($this->quoteCriteriaFilterTransferMock)
            ->willReturn($this->quoteCollectionTransferMock);

        $this->assertInstanceOf(
            QuoteCollectionTransfer::class,
            $this->companyUserQuoteClient->getCompanyUserQuoteCollectionByCriteria(
                $this->quoteCriteriaFilterTransferMock,
            ),
        );
    }
}
