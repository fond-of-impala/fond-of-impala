<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\CancellationManagerInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander\ErpOrderCancellationExpanderInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission\PermissionCheckerInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiDependencyProvider;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiEntityManager;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Zed\Kernel\Container;

class ErpOrderCancellationRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiEntityManager
     */
    protected MockObject|ErpOrderCancellationRestApiEntityManager $entityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Psr\Log\LoggerInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|LoggerInterface $loggerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepository
     */
    protected MockObject|ErpOrderCancellationRestApiRepository $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface
     */
    protected MockObject|ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface
     */
    protected MockObject|ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\ErpOrderCancellationRestApiBusinessFactory
     */
    protected ErpOrderCancellationRestApiBusinessFactory $businessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(ErpOrderCancellationRestApiEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ErpOrderCancellationRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderFacadeMock = $this->getMockBuilder(ErpOrderCancellationRestApiToErpOrderFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationFacadeMock = $this->getMockBuilder(ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->businessFactory = new class ($this->loggerMock) extends ErpOrderCancellationRestApiBusinessFactory {
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

        $this->businessFactory->setRepository($this->repositoryMock);
        $this->businessFactory->setEntityManager($this->entityManagerMock);
        $this->businessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCancellationManager(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case ErpOrderCancellationRestApiDependencyProvider::FACADE_ERP_ORDER_CANCELLATION:
                        return $self->erpOrderCancellationFacadeMock;
                    case ErpOrderCancellationRestApiDependencyProvider::FACADE_ERP_ORDER:
                        return $self->erpOrderFacadeMock;
                    case ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_REST_FILTER_TO_FILTER_MAPPER_EXPANDER:
                        return [];
                    case ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_PERMISSION:
                        return [];
                    case ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_EXPANDER:
                        return [];
                }
            });

        static::assertInstanceOf(
            CancellationManagerInterface::class,
            $this->businessFactory->createCancellationManager(),
        );
    }

    /**
     * @return void
     */
    public function testCreateRestDataMapper(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) {
                switch ($key) {
                    case ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_EXPANDER:
                        return [];
                }
            });

        static::assertInstanceOf(
            RestDataMapperInterface::class,
            $this->businessFactory->createRestDataMapper(),
        );
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellationExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) {
                switch ($key) {
                    case ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_EXPANDER:
                        return [];
                }
            });

        static::assertInstanceOf(
            ErpOrderCancellationExpanderInterface::class,
            $this->businessFactory->createErpOrderCancellationExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreatePermissionChecker(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) {
                switch ($key) {
                    case ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_PERMISSION:
                        return [];
                }
            });

        static::assertInstanceOf(
            PermissionCheckerInterface::class,
            $this->businessFactory->createPermissionChecker(),
        );
    }

    /**
     * @return void
     */
    public function testCreateRestFilterToFilterMapper(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) {
                switch ($key) {
                    case ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_REST_FILTER_TO_FILTER_MAPPER_EXPANDER:
                        return [];
                }
            });

        static::assertInstanceOf(
            RestFilterToFilterMapperInterface::class,
            $this->businessFactory->createRestFilterToFilterMapper(),
        );
    }
}
