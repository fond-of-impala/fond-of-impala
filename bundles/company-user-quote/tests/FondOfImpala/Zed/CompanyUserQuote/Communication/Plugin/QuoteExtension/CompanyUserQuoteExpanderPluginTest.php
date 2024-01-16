<?php

namespace FondOfImpala\Zed\CompanyUserQuote\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserQuote\Business\CompanyUserQuoteFacade;
use Generated\Shared\Transfer\QuoteTransfer;

class CompanyUserQuoteExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserQuote\Communication\Plugin\QuoteExtension\CompanyUserQuoteExpanderPlugin
     */
    protected $companyUserQuoteExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserQuote\Business\CompanyUserQuoteFacade
     */
    protected $companyUserQuoteFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteFacadeMock = $this->getMockBuilder(CompanyUserQuoteFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteExpanderPlugin = new CompanyUserQuoteExpanderPlugin();
        $this->companyUserQuoteExpanderPlugin->setFacade($this->companyUserQuoteFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->companyUserQuoteFacadeMock->expects($this->atLeastOnce())
            ->method('expandQuoteWithCompanyUser')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->companyUserQuoteExpanderPlugin->expand(
                $this->quoteTransferMock,
            ),
        );
    }
}
