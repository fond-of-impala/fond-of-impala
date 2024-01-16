<?php

namespace FondOfImpala\Zed\CompanyUserQuote\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteExpanderInterface;
use FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteReaderInterface;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CompanyUserQuoteFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserQuote\Business\CompanyUserQuoteFacade
     */
    protected $companyUserQuoteFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserQuote\Business\CompanyUserQuoteBusinessFactory
     */
    protected $companyUserQuoteBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCriteriaFilterTransfer
     */
    protected $quoteCriteriaFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteReaderInterface
     */
    protected $companyUserQuoteReaderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected $quoteCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteExpanderInterface
     */
    protected $companyUserQuoteExpanderInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserQuoteBusinessFactoryMock = $this->getMockBuilder(CompanyUserQuoteBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCriteriaFilterTransferMock = $this->getMockBuilder(QuoteCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteReaderInterfaceMock = $this->getMockBuilder(CompanyUserQuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCollectionTransferMock = $this->getMockBuilder(QuoteCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteExpanderInterfaceMock = $this->getMockBuilder(CompanyUserQuoteExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteFacade = new CompanyUserQuoteFacade();
        $this->companyUserQuoteFacade->setFactory($this->companyUserQuoteBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testGetCompanyUserQuoteCollection(): void
    {
        $this->companyUserQuoteBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyUserQuoteReader')
            ->willReturn($this->companyUserQuoteReaderInterfaceMock);

        $this->companyUserQuoteReaderInterfaceMock->expects($this->atLeastOnce())
            ->method('getFilteredCompanyUserQuoteCollection')
            ->with($this->quoteCriteriaFilterTransferMock)
            ->willReturn($this->quoteCollectionTransferMock);

        $this->assertInstanceOf(
            QuoteCollectionTransfer::class,
            $this->companyUserQuoteFacade->getCompanyUserQuoteCollection(
                $this->quoteCriteriaFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQuoteWithCompanyUser(): void
    {
        $this->companyUserQuoteBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyUserQuoteExpander')
            ->willReturn($this->companyUserQuoteExpanderInterfaceMock);

        $this->companyUserQuoteExpanderInterfaceMock->expects($this->atLeastOnce())
            ->method('expand')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->companyUserQuoteFacade->expandQuoteWithCompanyUser(
                $this->quoteTransferMock,
            ),
        );
    }
}
