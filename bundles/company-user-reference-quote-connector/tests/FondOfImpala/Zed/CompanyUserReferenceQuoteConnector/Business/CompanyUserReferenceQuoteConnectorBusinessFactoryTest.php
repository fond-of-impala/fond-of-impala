<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter\QuoteDeleter;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReader;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\CompanyUserReferenceQuoteConnectorDependencyProvider;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepository;
use Spryker\Zed\Kernel\Container;

class CompanyUserReferenceQuoteConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepository
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface
     */
    protected $quoteFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\CompanyUserReferenceQuoteConnectorBusinessFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserReferenceQuoteConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CompanyUserReferenceQuoteConnectorBusinessFactory();
        $this->factory->setContainer($this->containerMock);
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateQuoteReader(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyUserReferenceQuoteConnectorDependencyProvider::FACADE_QUOTE)
            ->willReturn($this->quoteFacadeMock);

        $quoteReader = $this->factory->createQuoteReader();

        static::assertInstanceOf(QuoteReader::class, $quoteReader);
    }

    /**
     * @return void
     */
    public function testCreateQuoteDeleter(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyUserReferenceQuoteConnectorDependencyProvider::FACADE_QUOTE)
            ->willReturn($this->quoteFacadeMock);

        static::assertInstanceOf(
            QuoteDeleter::class,
            $this->factory->createQuoteDeleter(),
        );
    }
}
