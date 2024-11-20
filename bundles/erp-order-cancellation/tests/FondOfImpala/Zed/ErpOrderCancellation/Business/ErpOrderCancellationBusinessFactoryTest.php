<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Handler\ErpOrderCancellationItemHandlerInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReaderInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriterInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationWriterInterface;
use FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationDependencyProvider;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManager;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Zed\Kernel\Container;

class ErpOrderCancellationBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManager
     */
    protected MockObject|ErpOrderCancellationEntityManager $entityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Psr\Log\LoggerInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|LoggerInterface $loggerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepository
     */
    protected MockObject|ErpOrderCancellationRepository $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationBusinessFactory
     */
    protected ErpOrderCancellationBusinessFactory $businessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(ErpOrderCancellationEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ErpOrderCancellationRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->businessFactory = new class ($this->loggerMock) extends ErpOrderCancellationBusinessFactory {
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
    public function testCreateErpOrderCancellationWriter(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $callCount = static::atLeastOnce();
        $this->containerMock->expects($callCount)
            ->method('get')
            ->willReturnCallback(
                static function (string $key) use ($self, $callCount) {
                    /** @phpstan-ignore-next-line */
                    if (method_exists($callCount, 'getInvocationCount')) {
                        /** @phpstan-ignore-next-line */
                        $count = $callCount->getInvocationCount();
                    } else {
                        /** @phpstan-ignore-next-line */
                        $count = $callCount->numberOfInvocations();
                    }

                    switch ($count) {
                        case 1:
                            $self->assertEquals(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_PRE_SAVE, $key);

                            return new ArrayObject();
                        case 2:
                            $self->assertEquals(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_POST_SAVE, $key);

                            return new ArrayObject();
                        case 3:
                            $self->assertEquals(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_POST_TRANSACTION, $key);

                            return new ArrayObject();
                    }

                    throw new Exception('Invalid key');
                },
            );

        static::assertInstanceOf(
            ErpOrderCancellationWriterInterface::class,
            $this->businessFactory->createErpOrderCancellationWriter(),
        );
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellationItemWriter(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $callCount = static::atLeastOnce();
        $this->containerMock->expects($callCount)
            ->method('get')
            ->willReturnCallback(
                static function (string $key) use ($self, $callCount) {
                    /** @phpstan-ignore-next-line */
                    if (method_exists($callCount, 'getInvocationCount')) {
                        /** @phpstan-ignore-next-line */
                        $count = $callCount->getInvocationCount();
                    } else {
                        /** @phpstan-ignore-next-line */
                        $count = $callCount->numberOfInvocations();
                    }

                    switch ($count) {
                        case 1:
                            $self->assertEquals(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_PRE_SAVE, $key);

                            return new ArrayObject();
                        case 2:
                            $self->assertEquals(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_POST_SAVE, $key);

                            return new ArrayObject();
                        case 3:
                            $self->assertEquals(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_POST_TRANSACTION, $key);

                            return new ArrayObject();
                    }

                    throw new Exception('Invalid key');
                },
            );

        static::assertInstanceOf(
            ErpOrderCancellationItemWriterInterface::class,
            $this->businessFactory->createErpOrderCancellationItemWriter(),
        );
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellationItemHandler(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $callCount = static::atLeastOnce();
        $this->containerMock->expects($callCount)
            ->method('get')
            ->willReturnCallback(
                static function (string $key) use ($self, $callCount) {
                    /** @phpstan-ignore-next-line */
                    if (method_exists($callCount, 'getInvocationCount')) {
                        /** @phpstan-ignore-next-line */
                        $count = $callCount->getInvocationCount();
                    } else {
                        /** @phpstan-ignore-next-line */
                        $count = $callCount->numberOfInvocations();
                    }

                    switch ($count) {
                        case 1:
                            $self->assertEquals(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_PRE_SAVE, $key);

                            return new ArrayObject();
                        case 2:
                            $self->assertEquals(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_POST_SAVE, $key);

                            return new ArrayObject();
                        case 3:
                            $self->assertEquals(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_POST_TRANSACTION, $key);

                            return new ArrayObject();
                    }

                    throw new Exception('Invalid key');
                },
            );

        static::assertInstanceOf(
            ErpOrderCancellationItemHandlerInterface::class,
            $this->businessFactory->createErpOrderCancellationItemHandler(),
        );
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellationReader(): void
    {
        static::assertInstanceOf(
            ReaderInterface::class,
            $this->businessFactory->createErpOrderCancellationReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellationItemReader(): void
    {
        static::assertInstanceOf(
            ErpOrderCancellationItemReaderInterface::class,
            $this->businessFactory->createErpOrderCancellationItemReader(),
        );
    }

    /**
     * @return void
     */
    public function testGetErpOrderCancellationPreSavePlugin(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_PRE_SAVE)
            ->willReturn(new ArrayObject());

        static::assertIsArray(
            $this->businessFactory->getErpOrderCancellationPreSavePlugin(),
        );
    }

    /**
     * @return void
     */
    public function testGetErpOrderCancellationPostSavePlugin(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_POST_SAVE)
            ->willReturn(new ArrayObject());

        static::assertIsArray(
            $this->businessFactory->getErpOrderCancellationPostSavePlugin(),
        );
    }

    /**
     * @return void
     */
    public function testGetErpOrderCancellationItemPreSavePlugin(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_PRE_SAVE)
            ->willReturn(new ArrayObject());

        static::assertIsArray(
            $this->businessFactory->getErpOrderCancellationItemPreSavePlugin(),
        );
    }

    /**
     * @return void
     */
    public function testGetErpOrderCancellationItemPostSavePlugin(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_POST_SAVE)
            ->willReturn(new ArrayObject());

        static::assertIsArray(
            $this->businessFactory->getErpOrderCancellationItemPostSavePlugin(),
        );
    }
}
