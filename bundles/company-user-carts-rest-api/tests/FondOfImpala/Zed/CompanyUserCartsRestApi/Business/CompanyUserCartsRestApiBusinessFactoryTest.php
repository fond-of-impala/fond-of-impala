<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator\QuoteCreator;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Deleter\QuoteDeleter;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinder;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater\QuoteUpdater;
use FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig;
use FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCartFacadeBridge;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeBridge;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeBridge;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Zed\Kernel\Container;

class CompanyUserCartsRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserCartsRestApiConfig $configMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCartFacadeBridge&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCartsRestApiToCartFacadeBridge|MockObject $cartFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeBridge&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCartsRestApiToQuoteFacadeBridge|MockObject $quoteFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeBridge&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserCartsRestApiToCompanyUserReferenceFacadeBridge $companyUserReferenceFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCartsRestApiToPermissionFacadeInterface|MockObject $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Kernel\Container&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Psr\Log\LoggerInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected LoggerInterface|MockObject $loggerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteCreateExpanderInterface|MockObject $quoteCreateExpanderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\CompanyUserCartsRestApiBusinessFactory
     */
    protected CompanyUserCartsRestApiBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(CompanyUserCartsRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToCartFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToQuoteFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToCompanyUserReferenceFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCreateExpanderMock = $this->getMockBuilder(QuoteCreateExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new class ($this->loggerMock) extends CompanyUserCartsRestApiBusinessFactory {
            /**
             * @var \Psr\Log\LoggerInterface
             */
            protected LoggerInterface $logger;

            /**
             * @param \Psr\Log\LoggerInterface $logger
             */
            public function __construct(LoggerInterface $logger)
            {
                $this->logger = $logger;
            }

            /**
             * @param \Spryker\Shared\Log\Config\LoggerConfigInterface|null $loggerConfig
             *
             * @return \Psr\Log\LoggerInterface
             */
            protected function getLogger(?LoggerConfigInterface $loggerConfig = null): LoggerInterface
            {
                return $this->logger;
            }
        };
        $this->factory->setConfig($this->configMock);
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateQuoteCreator(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyUserCartsRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_CART],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_CART],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_QUOTE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_PERMISSION],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_PERMISSION],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_QUOTE],
                [CompanyUserCartsRestApiDependencyProvider::PLUGIN_QUOTE_CREATE_EXPANDER],
            )->willReturnOnConsecutiveCalls(
                $this->companyUserReferenceFacadeMock,
                $this->cartFacadeMock,
                $this->cartFacadeMock,
                $this->quoteFacadeMock,
                $this->companyUserReferenceFacadeMock,
                $this->permissionFacadeMock,
                $this->companyUserReferenceFacadeMock,
                $this->permissionFacadeMock,
                $this->quoteFacadeMock,
                [],
            );

        static::assertInstanceOf(
            QuoteCreator::class,
            $this->factory->createQuoteCreator(),
        );
    }

    /**
     * @return void
     */
    public function testCreateQuoteUpdater(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyUserCartsRestApiDependencyProvider::FACADE_QUOTE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_PERMISSION],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_CART],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_CART],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_PERMISSION],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_QUOTE],
            )->willReturnOnConsecutiveCalls(
                $this->quoteFacadeMock,
                $this->companyUserReferenceFacadeMock,
                $this->permissionFacadeMock,
                $this->cartFacadeMock,
                $this->cartFacadeMock,
                $this->companyUserReferenceFacadeMock,
                $this->permissionFacadeMock,
                $this->quoteFacadeMock,
            );

        static::assertInstanceOf(
            QuoteUpdater::class,
            $this->factory->createQuoteUpdater(),
        );
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
            ->withConsecutive(
                [CompanyUserCartsRestApiDependencyProvider::FACADE_QUOTE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_PERMISSION],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_QUOTE],
            )->willReturnOnConsecutiveCalls(
                $this->quoteFacadeMock,
                $this->companyUserReferenceFacadeMock,
                $this->permissionFacadeMock,
                $this->quoteFacadeMock,
            );

        static::assertInstanceOf(
            QuoteDeleter::class,
            $this->factory->createQuoteDeleter(),
        );
    }

    /**
     * @return void
     */
    public function testCreateQuoteFinder(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyUserCartsRestApiDependencyProvider::FACADE_QUOTE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
                [CompanyUserCartsRestApiDependencyProvider::FACADE_PERMISSION],
            )->willReturnOnConsecutiveCalls(
                $this->quoteFacadeMock,
                $this->companyUserReferenceFacadeMock,
                $this->permissionFacadeMock,
            );

        static::assertInstanceOf(
            QuoteFinder::class,
            $this->factory->createQuoteFinder(),
        );
    }
}
