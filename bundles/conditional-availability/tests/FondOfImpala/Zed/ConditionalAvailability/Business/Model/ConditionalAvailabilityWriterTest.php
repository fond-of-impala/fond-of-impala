<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface;

class ConditionalAvailabilityWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Psr\Log\LoggerInterface
     */
    protected $loggerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
     */
    protected $transactionHandlerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutorInterface
     */
    protected $conditionalAvailabilityPluginExecutorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface
     */
    protected $conditionalAvailabilityEntityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    protected $conditionalAvailabilityTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriter
     */
    protected $conditionalAvailabilityWriter;

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

        $this->conditionalAvailabilityEntityManagerMock = $this->getMockBuilder(ConditionalAvailabilityEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPluginExecutorMock = $this->getMockBuilder(ConditionalAvailabilityPluginExecutorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityWriter = new class (
            $this->conditionalAvailabilityEntityManagerMock,
            $this->conditionalAvailabilityPluginExecutorMock,
            $this->loggerMock,
            $this->transactionHandlerMock
        ) extends ConditionalAvailabilityWriter {
            /**
             * @var \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
             */
            protected $transactionHandler;

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
                static function ($callable) {
                    $callable();
                },
            );

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
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
                static function ($callable) {
                    return $callable();
                },
            );

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
            ->method('saveConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->withAnyParameters()
            ->willReturnCallback(static function (ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer) {
                return $conditionalAvailabilityResponseTransfer;
            });

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
                static function ($callable) {
                    return $callable();
                },
            );

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
            ->method('persistConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->withAnyParameters()
            ->willReturnCallback(static function (ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer) {
                return $conditionalAvailabilityResponseTransfer;
            });

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
                static function ($callable) {
                    return $callable();
                },
            );

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
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
                static function ($callable) {
                    return $callable();
                },
            );

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
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
                static function ($callable) {
                    return $callable();
                },
            );

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
            ->method('saveConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->withAnyParameters()
            ->willReturnCallback(static function (ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer) {
                return $conditionalAvailabilityResponseTransfer;
            });

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
                static function ($callable) {
                    return $callable();
                },
            );

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('requireIdConditionalAvailability')
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
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
                static function ($callable) {
                    return $callable();
                },
            );

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('requireIdConditionalAvailability')
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
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
