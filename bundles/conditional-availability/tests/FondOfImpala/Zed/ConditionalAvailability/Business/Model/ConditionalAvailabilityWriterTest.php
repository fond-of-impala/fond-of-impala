<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface;

class ConditionalAvailabilityWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Psr\Log\LoggerInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected LoggerInterface|MockObject $loggerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|TransactionHandlerInterface $transactionHandlerMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityTransfer|MockObject $conditionalAvailabilityTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityEntityManagerInterface $entityManagerMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutorInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityPluginExecutorInterface $conditionalAvailabilityPluginExecutorMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriter
     */
    protected ConditionalAvailabilityWriter $conditionalAvailabilityWriter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transactionHandlerMock = $this->getMockBuilder(TransactionHandlerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(ConditionalAvailabilityEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPluginExecutorMock = $this->getMockBuilder(ConditionalAvailabilityPluginExecutorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityWriter = new class (
            $this->entityManagerMock,
            $this->conditionalAvailabilityPluginExecutorMock,
            $this->loggerMock,
            $this->transactionHandlerMock
        ) extends ConditionalAvailabilityWriter {
            /**
             * @var \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
             */
            protected TransactionHandlerInterface $transactionHandler;

            /**
             * @param \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface $entityManager
             * @param \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutorInterface $conditionalAvailabilityPluginExecutor
             * @param \Psr\Log\LoggerInterface $logger
             * @param \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface $transactionHandler
             */
            public function __construct(
                ConditionalAvailabilityEntityManagerInterface $entityManager,
                ConditionalAvailabilityPluginExecutorInterface $conditionalAvailabilityPluginExecutor,
                LoggerInterface $logger,
                TransactionHandlerInterface $transactionHandler
            ) {
                parent::__construct($entityManager, $conditionalAvailabilityPluginExecutor, $logger);

                $this->transactionHandler = $transactionHandler;
            }

            /**
             * @return \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
             */
            public function getTransactionHandler(): TransactionHandlerInterface
            {
                return $this->transactionHandler;
            }
        };
    }

    /**
     * @return void
     */
    public function testCreateWithError(): void
    {
        $exception = new Exception('foo');
        $serializedData = '{}';

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static fn ($callable) => $callable(),
            );

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('saveConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willThrowException($exception);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('serialize')
            ->willReturn($serializedData);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error')
            ->with($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $serializedData,
            ]);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityWriter->create(
            $this->conditionalAvailabilityTransferMock,
        );

        static::assertFalse($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(null, $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer());
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static fn ($callable) => $callable(),
            );

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('saveConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->withAnyParameters()
            ->willReturnCallback(
                static fn (
                    ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
                ): ConditionalAvailabilityResponseTransfer => $conditionalAvailabilityResponseTransfer,
            );

        $this->conditionalAvailabilityTransferMock->expects(static::never())
            ->method('serialize');

        $this->loggerMock->expects(static::never())
            ->method('error');

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityWriter->create(
            $this->conditionalAvailabilityTransferMock,
        );

        static::assertTrue($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static fn ($callable) => $callable(),
            );

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('persistConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->withAnyParameters()
            ->willReturnCallback(
                static fn (
                    ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
                ): ConditionalAvailabilityResponseTransfer => $conditionalAvailabilityResponseTransfer,
            );

        $this->conditionalAvailabilityTransferMock->expects(static::never())
            ->method('serialize');

        $this->loggerMock->expects(static::never())
            ->method('error');

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityWriter->persist(
            $this->conditionalAvailabilityTransferMock,
        );

        static::assertTrue($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testPersistWithError(): void
    {
        $exception = new Exception('foo');
        $serializedData = '{}';

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static fn ($callable) => $callable(),
            );

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('persistConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willThrowException($exception);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('serialize')
            ->willReturn($serializedData);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error')
            ->with($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $serializedData,
            ]);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityWriter->persist(
            $this->conditionalAvailabilityTransferMock,
        );

        static::assertFalse($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(null, $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer());
    }

    /**
     * @return void
     */
    public function testUpdateWithError(): void
    {
        $exception = new Exception('foo');
        $serializedData = '{}';

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static fn ($callable) => $callable(),
            );

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('saveConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willThrowException($exception);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('serialize')
            ->willReturn($serializedData);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error')
            ->with($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $serializedData,
            ]);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityWriter->update(
            $this->conditionalAvailabilityTransferMock,
        );

        static::assertFalse($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(null, $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer());
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static fn ($callable) => $callable(),
            );

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('saveConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->withAnyParameters()
            ->willReturnCallback(
                static fn (
                    ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
                ): ConditionalAvailabilityResponseTransfer => $conditionalAvailabilityResponseTransfer,
            );

        $this->conditionalAvailabilityTransferMock->expects(static::never())
            ->method('serialize');

        $this->loggerMock->expects(static::never())
            ->method('error');

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityWriter->update(
            $this->conditionalAvailabilityTransferMock,
        );

        static::assertTrue($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testDeleteWithError(): void
    {
        $idConditionalAvailability = 1;

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static fn ($callable) => $callable(),
            );

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('requireIdConditionalAvailability')
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('deleteConditionalAvailabilityById')
            ->with($idConditionalAvailability)
            ->willThrowException(new Exception());

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityWriter->delete(
            $this->conditionalAvailabilityTransferMock,
        );

        static::assertFalse($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(
            null,
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $idConditionalAvailability = 1;

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static fn ($callable) => $callable(),
            );

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('requireIdConditionalAvailability')
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('deleteConditionalAvailabilityById')
            ->with($idConditionalAvailability);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityWriter->delete(
            $this->conditionalAvailabilityTransferMock,
        );

        static::assertTrue($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(
            null,
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );
    }
}
