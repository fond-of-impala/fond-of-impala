<?php

namespace FondOfImpala\Zed\CompanyUserQuote\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteExpanderInterface;
use FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteReaderInterface;
use FondOfImpala\Zed\CompanyUserQuote\CompanyUserQuoteDependencyProvider;
use FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade\CompanyUserQuoteToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuoteRepository;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Quote\Dependency\Facade\QuoteToStoreFacadeInterface;
use Spryker\Zed\Quote\QuoteDependencyProvider;

class CompanyUserQuoteBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserQuote\Business\CompanyUserQuoteBusinessFactory
     */
    protected $companyUserQuoteBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuoteRepository
     */
    protected $companyUserQuoteRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var array
     */
    protected $quoteExpanderPluginInterfaceMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade\CompanyUserQuoteToCompanyUserReferenceFacadeInterface
     */
    protected $companyUserQuoteToCompanyUserReferenceFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Quote\Dependency\Facade\QuoteToStoreFacadeInterface
     */
    protected $quoteToStoreFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserQuoteRepositoryMock = $this->getMockBuilder(CompanyUserQuoteRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteToCompanyUserReferenceFacadeInterfaceMock = $this->getMockBuilder(CompanyUserQuoteToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteToStoreFacadeInterfaceMock = $this->getMockBuilder(QuoteToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteExpanderPluginInterfaceMocks = [];

        $this->companyUserQuoteBusinessFactory = new CompanyUserQuoteBusinessFactory();
        $this->companyUserQuoteBusinessFactory->setRepository($this->companyUserQuoteRepositoryMock);
        $this->companyUserQuoteBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserQuoteReader(): void
    {
        $this->containerMock->expects($this->atLeast(2))
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [QuoteDependencyProvider::PLUGINS_QUOTE_EXPANDER],
                [QuoteDependencyProvider::FACADE_STORE],
            )
            ->willReturnOnConsecutiveCalls(
                $this->quoteExpanderPluginInterfaceMocks,
                $this->quoteToStoreFacadeInterfaceMock,
            );

        $this->assertInstanceOf(
            CompanyUserQuoteReaderInterface::class,
            $this->companyUserQuoteBusinessFactory->createCompanyUserQuoteReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserQuoteExpander(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn(CompanyUserQuoteDependencyProvider::FACADE_COMPANY_USER_REFERENCE)
            ->willReturn($this->companyUserQuoteToCompanyUserReferenceFacadeInterfaceMock);

        $this->assertInstanceOf(
            CompanyUserQuoteExpanderInterface::class,
            $this->companyUserQuoteBusinessFactory->createCompanyUserQuoteExpander(),
        );
    }
}
