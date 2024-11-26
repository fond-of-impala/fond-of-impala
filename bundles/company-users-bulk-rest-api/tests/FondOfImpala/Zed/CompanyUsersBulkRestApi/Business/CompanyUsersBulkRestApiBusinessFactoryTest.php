<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CompanyBusinessUnitToCompanyTransferExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CompanyExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CompanyRolesToCompanyTransferExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CustomerByMailExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager\BulkManagerInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Zed\Kernel\Container;

class CompanyUsersBulkRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Container|MockObject $containerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiToEventFacadeInterface|MockObject $eventFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiToCompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiRepository|MockObject $repositoryMock;

    /**
     * @var \Psr\Log\LoggerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected LoggerInterface|MockObject $loggerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiBusinessFactory
     */
    protected CompanyUsersBulkRestApiBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this
            ->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this
            ->getMockBuilder(CompanyUsersBulkRestApiToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this
            ->getMockBuilder(CompanyUsersBulkRestApiToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this
            ->getMockBuilder(CompanyUsersBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this
            ->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new class ($this->loggerMock) extends CompanyUsersBulkRestApiBusinessFactory {
            /**
             * @var \Psr\Log\LoggerInterface
             */
            protected LoggerInterface $loggerMock;

            /**
             * @param \Psr\Log\LoggerInterface $logger
             */
            public function __construct(LoggerInterface $logger)
            {
                $this->loggerMock = $logger;
            }

            /**
             * @param \Spryker\Shared\Log\Config\LoggerConfigInterface|null $loggerConfig
             *
             * @return \Psr\Log\LoggerInterface
             */
            public function getLogger(?LoggerConfigInterface $loggerConfig = null): LoggerInterface
            {
                return $this->loggerMock;
            }
        };
        $this->factory->setContainer($this->containerMock);
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateBulkManager(): void
    {
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUsersBulkRestApiDependencyProvider::FACADE_EVENT:
                        return $self->eventFacadeMock;
                    case CompanyUsersBulkRestApiDependencyProvider::FACADE_COMPANY_USER:
                        return $self->companyUserFacadeMock;
                    case CompanyUsersBulkRestApiDependencyProvider::PLUGINS_DATA_EXPANDER:
                        return [];
                    case CompanyUsersBulkRestApiDependencyProvider::PLUGINS_DATA_POST_EXPANDER:
                        return [];
                    case CompanyUsersBulkRestApiDependencyProvider::PLUGINS_PRE_HANDLING:
                        return [];
                    case CompanyUsersBulkRestApiDependencyProvider::PLUGINS_POST_HANDLING:
                        return [];
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            BulkManagerInterface::class,
            $this->factory->createBulkManager(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyExpander(): void
    {
        static::assertInstanceOf(
            CompanyExpander::class,
            $this->factory->createCompanyExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCustomerByMailExpander(): void
    {
        static::assertInstanceOf(
            CustomerByMailExpander::class,
            $this->factory->createCustomerByMailExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitToCompanyTransferExpander(): void
    {
        static::assertInstanceOf(
            CompanyBusinessUnitToCompanyTransferExpander::class,
            $this->factory->createCompanyBusinessUnitToCompanyTransferExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyRolesToCompanyTransferExpander(): void
    {
        static::assertInstanceOf(
            CompanyRolesToCompanyTransferExpander::class,
            $this->factory->createCompanyRolesToCompanyTransferExpander(),
        );
    }
}
