<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer;

use Exception;
use FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Throwable;

class ErpOrderCancellationWriter implements ErpOrderCancellationWriterInterface
{
    use TransactionTrait;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface
     */
    protected $erpOrderCancellationPluginExecutor;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface $entityManager
     * @param \FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface $erpOrderCancellationPluginExecutor
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ErpOrderCancellationEntityManagerInterface $entityManager,
        ErpOrderCancellationPluginExecutorInterface $erpOrderCancellationPluginExecutor,
        LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->erpOrderCancellationPluginExecutor = $erpOrderCancellationPluginExecutor;
        $this->logger = $logger;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function create(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer
    {
        $self = $this;
        $responseTransfer = (new ErpOrderCancellationResponseTransfer())
            ->setErpOrderCancellation($erpOrderCancellationTransfer)
            ->setIsSuccessful(true);
        try {
            $responseTransfer = $this->getTransactionHandler()->handleTransaction(
                static function () use ($responseTransfer, $self) {
                    return $self->executePersistTransaction($responseTransfer);
                },
            );
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $erpOrderCancellationTransfer->serialize(),
            ]);

            $responseTransfer->setErpOrderCancellation(null)
                ->setIsSuccessful(false);
        }

        return $this->erpOrderCancellationPluginExecutor->executePostTransactionPlugins($responseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function update(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer
    {
        $self = $this;
        $responseTransfer = (new ErpOrderCancellationResponseTransfer())
            ->setErpOrderCancellation($erpOrderCancellationTransfer)
            ->setIsSuccessful(true);
        try {
            $responseTransfer = $this->getTransactionHandler()->handleTransaction(
                static function () use ($responseTransfer, $self) {
                    return $self->executeUpdateTransaction($responseTransfer);
                },
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $erpOrderCancellationTransfer->serialize(),
            ]);

            $responseTransfer->setErpOrderCancellation(null)
                ->setIsSuccessful(false);
        }

        return $this->erpOrderCancellationPluginExecutor->executePostTransactionPlugins($responseTransfer);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function delete(int $idErpOrderCancellation): void
    {
        $self = $this;

        try {
            $this->getTransactionHandler()->handleTransaction(
                static function () use ($idErpOrderCancellation, $self) {
                    $self->executeDeleteTransaction($idErpOrderCancellation);
                },
            );
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $idErpOrderCancellation,
            ]);

            throw $exception;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    protected function executeUpdateTransaction(
        ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer
    ): ErpOrderCancellationResponseTransfer {
        $erpOrderCancellationTransfer = $erpOrderCancellationResponseTransfer->getErpOrderCancellation();
        $erpOrderCancellationTransfer = $this->erpOrderCancellationPluginExecutor->executePreSavePlugins($erpOrderCancellationTransfer);
        $erpOrderCancellationTransfer = $this->entityManager->updateErpOrderCancellation($erpOrderCancellationTransfer);
        $erpOrderCancellationTransfer = $this->erpOrderCancellationPluginExecutor->executePostSavePlugins($erpOrderCancellationTransfer);

        return $erpOrderCancellationResponseTransfer->setErpOrderCancellation($erpOrderCancellationTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    protected function executePersistTransaction(
        ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer
    ): ErpOrderCancellationResponseTransfer {
        $erpOrderCancellationTransfer = $erpOrderCancellationResponseTransfer->getErpOrderCancellation();
        $erpOrderCancellationTransfer = $this->erpOrderCancellationPluginExecutor->executePreSavePlugins($erpOrderCancellationTransfer);
        $erpOrderCancellationTransfer = $this->entityManager->createErpOrderCancellation($erpOrderCancellationTransfer);
        $erpOrderCancellationTransfer = $this->erpOrderCancellationPluginExecutor->executePostSavePlugins($erpOrderCancellationTransfer);

        return $erpOrderCancellationResponseTransfer->setErpOrderCancellation($erpOrderCancellationTransfer);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return void
     */
    protected function executeDeleteTransaction(int $idErpOrderCancellation): void
    {
        $this->entityManager->deleteErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);
    }
}
