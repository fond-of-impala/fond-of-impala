<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface;

class ErpOrderCancellationWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Psr\Log\LoggerInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|LoggerInterface $loggerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface
     */
    protected MockObject|LoggerInterface $erpOrderCancellationPluginExecutorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    protected MockObject|ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface
     */
    protected MockObject|ErpOrderCancellationEntityManagerInterface $entityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|TransactionHandlerInterface $transactionHandlerMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationWriterInterface
     */
    protected ErpOrderCancellationWriterInterface $writer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->entityManagerMock = $this
            ->getMockBuilder(ErpOrderCancellationEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationResponseTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationPluginExecutorMock = $this
            ->getMockBuilder(ErpOrderCancellationPluginExecutorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this
            ->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transactionHandlerMock = $this
            ->getMockBuilder(TransactionHandlerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->writer = new class (
            $this->entityManagerMock,
            $this->erpOrderCancellationPluginExecutorMock,
            $this->loggerMock,
            $this->transactionHandlerMock
        ) extends ErpOrderCancellationWriter {
            /**
             * @var \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
             */
            protected TransactionHandlerInterface $transactionHandler;

            /**
             * @param \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface $entityManager
             * @param \FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface $erpOrderCancellationPluginExecutor
             * @param \Psr\Log\LoggerInterface $logger
             * @param \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface $transactionHandler
             */
            public function __construct(
                ErpOrderCancellationEntityManagerInterface $entityManager,
                ErpOrderCancellationPluginExecutorInterface $erpOrderCancellationPluginExecutor,
                LoggerInterface $logger,
                TransactionHandlerInterface $transactionHandler
            ) {
                parent::__construct($entityManager, $erpOrderCancellationPluginExecutor, $logger);

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
    public function testCreate(): void
    {
        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    return $callable();
                },
            );

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreSavePlugins')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellation')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostTransactionPlugins')
            ->willReturnCallback(static function (ErpOrderCancellationResponseTransfer $responseTransfer) {
                return $responseTransfer;
            });

        $responseTransfer = $this->writer->create($this->erpOrderCancellationTransferMock);

        static::assertTrue($responseTransfer->getIsSuccessful());
        static::assertEquals(
            $this->erpOrderCancellationTransferMock,
            $responseTransfer->getErpOrderCancellation(),
        );
    }

    /**
     * @return void
     */
    public function testCreateWithException(): void
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

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreSavePlugins')
            ->with($this->erpOrderCancellationTransferMock)
            ->willThrowException($exception);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('serialize')
            ->willReturn($serializedData);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error')
            ->with($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $serializedData,
            ]);

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostTransactionPlugins')
            ->willReturnCallback(static function (ErpOrderCancellationResponseTransfer $responseTransfer) {
                return $responseTransfer;
            });

        $responseTransfer = $this->writer->create($this->erpOrderCancellationTransferMock);

        static::assertFalse($responseTransfer->getIsSuccessful());
        static::assertEquals(null, $responseTransfer->getErpOrderCancellation());
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

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreSavePlugins')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellation')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostTransactionPlugins')
            ->willReturnCallback(static function (ErpOrderCancellationResponseTransfer $responseTransfer) {
                return $responseTransfer;
            });

        $responseTransfer = $this->writer->update($this->erpOrderCancellationTransferMock);

        static::assertTrue($responseTransfer->getIsSuccessful());
        static::assertEquals(
            $this->erpOrderCancellationTransferMock,
            $responseTransfer->getErpOrderCancellation(),
        );
    }

    /**
     * @return void
     */
    public function testUpdateWithException(): void
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

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreSavePlugins')
            ->with($this->erpOrderCancellationTransferMock)
            ->willThrowException($exception);

        $this->erpOrderCancellationPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostTransactionPlugins')
            ->willReturnCallback(static function (ErpOrderCancellationResponseTransfer $responseTransfer) {
                return $responseTransfer;
            });

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('serialize')
            ->willReturn($serializedData);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error')
            ->with($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $serializedData,
            ]);

        $responseTransfer = $this->writer->update($this->erpOrderCancellationTransferMock);

        static::assertFalse($responseTransfer->getIsSuccessful());
        static::assertEquals(null, $responseTransfer->getErpOrderCancellation());
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $idErpOrderCancellation = 1;
        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    return $callable();
                },
            );

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('deleteErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation);

        $this->writer->delete($idErpOrderCancellation);
    }

    /**
     * @return void
     */
    public function testDeleteWithException(): void
    {
        $idErpOrderCancellation = 1;
        $exception = new Exception('foo');

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    return $callable();
                },
            );

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('deleteErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willThrowException($exception);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error')
            ->with($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $idErpOrderCancellation,
            ]);

        try {
            $this->writer->delete($idErpOrderCancellation);
            static::fail();
        } catch (Exception) {
        }
    }
}
